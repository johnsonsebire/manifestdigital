@props([
    'title' => 'AI Chat',
    'initialMessages' => [],
    'aiAvatar' => null,
    'userAvatar' => null,
    'isLoading' => false,
])

<div x-data="{ 
        messages: [],
        isTyping: false,
        hasUnreadMessages: false,
        audioPlayer: null,

        init() {
            this.setupAudioPlayer();
            this.watchMessages();
            this.$nextTick(() => this.scrollToBottom());
        },

        setupAudioPlayer() {
            this.audioPlayer = new Audio();
            this.audioPlayer.volume = 0.5;
        },

        watchMessages() {
            this.$watch('messages', () => {
                this.$nextTick(() => this.scrollToBottom());
                if (document.hidden) {
                    this.hasUnreadMessages = true;
                    this.playNotificationSound();
                }
            });
        },

        scrollToBottom() {
            this.$refs.chatMessages.scrollTop = this.$refs.chatMessages.scrollHeight;
        },

        playNotificationSound() {
            if (this.audioPlayer) {
                this.audioPlayer.src = '{{ asset('sounds/notification.mp3') }}';
                this.audioPlayer.play();
            }
        },

        async handleSendMessage() {
            const messageInput = this.$refs.messageInput;
            const message = messageInput.value.trim();
            if (!message) return;

            // Add user message
            this.messages.push({
                type: 'user',
                message: message,
                timestamp: new Date().toLocaleTimeString()
            });

            // Clear input and show typing indicator
            messageInput.value = '';
            this.isTyping = true;

            const url = '{{ route('ai.chat.message') }}';
            console.log('Sending message to:', url);

            try {
                const formData = new FormData();
                formData.append('message', message);

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                
                this.messages.push({
                    type: 'assistant',
                    message: data.message,
                    timestamp: new Date().toLocaleTimeString()
                });
            } catch (error) {
                console.error('Error:', error);
                this.messages.push({
                    type: 'system',
                    message: 'Sorry, there was an error processing your message. Please try again.',
                    timestamp: new Date().toLocaleTimeString(),
                    status: 'error'
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        }
    }"
    x-init="init"
        
        async handleSendMessage(event) {
            const { text, attachments } = event.detail;
            if (!text.trim() && (!attachments || attachments.length === 0)) return;
            
            // Add user message
            this.messages.push({
                type: 'user',
                message: text,
                timestamp: new Date().toLocaleTimeString(),
                attachments: attachments || []
            });
            
            // Show typing indicator
            this.isTyping = true;
            
            try {
                // Make API call to your Laravel backend
                const response = await fetch('{{ route("ai.chat.message") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: text,
                        attachments: attachments
                    })
                });
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                // Add AI response
                this.messages.push({
                    type: 'assistant',
                    message: data.message,
                    timestamp: new Date().toLocaleTimeString()
                });
            } catch (error) {
                console.error('Error:', error);
                // Add error message
                this.messages.push({
                    type: 'system',
                    message: 'Sorry, there was an error processing your message. Please try again.',
                    timestamp: new Date().toLocaleTimeString(),
                    status: 'error'
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        }
    }"
    @send-message.window="handleSendMessage"
    @voice-message.window="handleVoiceMessage"
    class="chat-interface"
>
    <div class="flex h-full dark bg-gray-900">
        <!-- Sidebar -->
        <div class="w-80 flex flex-col bg-gray-900 border-r border-gray-800">
            <div class="p-4">
                <button @click="messages = []" class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 p-4 rounded-lg border border-red-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Chat
                </button>
            </div>

            <div class="flex-1 overflow-y-auto">
                <div class="px-4 py-2">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Recent Chats</h3>
                    <p class="mt-2 text-sm text-gray-500">No recent chats</p>
                </div>

                <div class="px-4 py-2">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Suggested Prompts</h3>
                    <div class="mt-2 space-y-2">
                        <x-chat.prompt text="Tell me about your services" />
                        <x-chat.prompt text="How can you help my business?" icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        <x-chat.prompt text="What technologies do you work with?" icon="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        <x-chat.prompt text="Can you explain your process?" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-gray-800">
                <button class="flex items-center justify-center gap-2 w-full p-2 text-gray-400 hover:text-gray-300 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </button>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col bg-gray-900">
            <div class="flex-1 overflow-y-auto custom-scrollbar min-h-0" x-ref="chatMessages" style="max-height: calc(100vh - 180px);">
                <template x-if="messages.length === 0">
                    <div class="flex flex-col items-center justify-center h-full text-center px-4">
                        <div class="p-4 bg-gray-800/50 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-200 mb-2">Start a Conversation</h3>
                        <p class="text-gray-400">Send a message to begin chatting with the AI assistant.</p>
                    </div>
                </template>

        <template x-for="(msg, index) in messages" :key="index">
            <div class="p-4">
                <div class="flex gap-3" :class="msg.type === 'user' ? 'flex-row-reverse' : ''">
                    <div class="flex-none">
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">
                            <template x-if="msg.type === 'assistant'">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </template>
                            <template x-if="msg.type === 'user'">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </template>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1" :class="msg.type === 'user' ? 'flex-row-reverse' : ''">
                            <span class="text-sm font-medium" :class="msg.type === 'assistant' ? 'text-blue-400' : 'text-green-400'" x-text="msg.type.charAt(0).toUpperCase() + msg.type.slice(1)"></span>
                            <span class="text-xs text-gray-500" x-text="msg.timestamp"></span>
                        </div>
                        <div class="p-3 rounded-lg" :class="msg.type === 'assistant' ? 'bg-gray-800 text-white' : 'bg-blue-500/10 text-blue-400'">
                            <p class="whitespace-pre-wrap" x-text="msg.message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div x-show="isTyping" class="chat-typing">
            <x-chat.typing-indicator style="bubble" />
        </div>
    </div>

            <div class="p-4 bg-gray-900 border-t border-gray-800">
                <form @submit.prevent="handleSendMessage" class="flex items-end gap-2">
                    @csrf
                    <div class="flex-1 bg-gray-800 rounded-lg border border-gray-700 focus-within:border-blue-500">
                        <div class="flex items-center px-3 py-2 gap-2">
                            <button type="button" @click="$dispatch('emoji-picker-toggle')" class="text-gray-400 hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            
                            <input
                                type="text"
                                x-ref="messageInput"
                                placeholder="Type a message..."
                                class="flex-1 bg-transparent border-none text-white placeholder-gray-400 focus:outline-none"
                                @keydown.enter.prevent="handleSendMessage"
                                name="message"
                            />
                        </div>
                    </div>

                    <button type="button" class="p-2 text-gray-400 hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </button>

                    <button type="submit" class="p-2 text-gray-400 hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>

    <div
        x-show="hasUnreadMessages"
        @click="scrollToBottom(); hasUnreadMessages = false"
        class="unread-messages-indicator"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 19V5M5 12l7 7 7-7"/>
        </svg>
        New messages
    </div>
</div>

<style>
.chat-interface {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    overflow: hidden;
    position: relative;
}

.chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    background: rgba(255, 255, 255, 0.02);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.chat-title {
    font-size: 18px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

.chat-actions {
    display: flex;
    gap: 8px;
}

.chat-action-btn {
    padding: 8px;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.chat-action-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.9);
}

.chat-action-btn svg {
    width: 20px;
    height: 20px;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    scroll-behavior: smooth;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Firefox */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
}

.chat-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    padding: 32px;
    text-align: center;
    color: rgba(255, 255, 255, 0.6);
}

.empty-state-icon {
    width: 64px;
    height: 64px;
    margin-bottom: 16px;
    opacity: 0.6;
}

.empty-state-icon svg {
    width: 100%;
    height: 100%;
}

.chat-empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 8px;
    color: rgba(255, 255, 255, 0.8);
}

.chat-empty-state p {
    font-size: 14px;
    margin: 0;
    max-width: 300px;
}

.chat-typing {
    padding: 8px 0;
}

.chat-footer {
    padding: 16px;
    background: rgba(255, 255, 255, 0.02);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.unread-messages-indicator {
    position: absolute;
    bottom: 100px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(255, 34, 0, 0.9);
    color: white;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease;
}

.unread-messages-indicator:hover {
    background: rgba(255, 34, 0, 1);
    transform: translateX(-50%) scale(1.05);
}

.unread-messages-indicator svg {
    width: 16px;
    height: 16px;
}

@media (max-width: 640px) {
    .chat-header {
        padding: 12px;
    }

    .chat-messages {
        padding: 12px;
    }

    .chat-footer {
        padding: 12px;
    }

    .chat-title {
        font-size: 16px;
    }
}
</style>