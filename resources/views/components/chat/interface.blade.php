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
        theme: 'dark',

        init() {
            this.setupAudioPlayer();
            this.watchMessages();
            this.setupAudioMessageHandler();
            this.loadTheme();
            this.watchTheme();
            this.$nextTick(() => this.scrollToBottom());
        },
        
        loadTheme() {
            const savedTheme = localStorage.getItem('chat-theme') || 'dark';
            this.theme = savedTheme;
            this.applyTheme(savedTheme);
        },
        
        watchTheme() {
            this.$watch('theme', (value) => {
                localStorage.setItem('chat-theme', value);
                this.applyTheme(value);
            });
        },
        
        applyTheme(theme) {
            const chatInterface = this.$el.querySelector('.chat-interface-container');
            if (!chatInterface) return;
            
            // Remove all theme classes
            chatInterface.classList.remove('theme-dark', 'theme-light', 'theme-system');
            
            if (theme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                chatInterface.classList.add(prefersDark ? 'theme-dark' : 'theme-light');
            } else {
                chatInterface.classList.add(`theme-${theme}`);
            }
        },
        
        setupAudioMessageHandler() {
            // Remove any existing event listeners
            this.$el.removeEventListener('audio-message', this.handleAudioMessage);
            
            this.$watch('isRecording', (value) => {
                // Disable text input while recording
                this.$refs.messageInput.disabled = value;
            });
            
            // Define the handler as a method to allow removal
            this.handleAudioMessage = async (event) => {
                if (this.isProcessingAudio) return; // Prevent double processing
                this.isProcessingAudio = true;
                
                const { audioBlob, duration } = event.detail;
                
                // Create FormData with audio file
                const formData = new FormData();
                formData.append('audio', audioBlob, 'recording.mp3');
                formData.append('duration', duration);
                
                // Add user message with audio
                const messageId = Date.now(); // unique ID for this message
                this.messages.push({
                    id: messageId,
                    type: 'user',
                    isAudio: true, // Mark as audio message
                    message: '🎤 Voice message (' + this.formatDuration(duration) + ')',
                    timestamp: new Date().toLocaleTimeString(),
                    audio: URL.createObjectURL(audioBlob)
                });
                
                // Show typing indicator
                this.isTyping = true;
                
                try {
                    const response = await fetch('{{ route("ai.chat.voice") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });
                    
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const data = await response.json();
                    
                    // Add AI response with delay
                    setTimeout(() => {
                        this.isTyping = false;
                        this.messages.push({
                            type: 'assistant',
                            message: data.transcription || data.message,
                            timestamp: new Date().toLocaleTimeString()
                        });
                        this.scrollToBottom();
                    }, 1000);
                    
                } catch (error) {
                    console.error('Error sending audio message:', error);
                    this.messages.push({
                        type: 'system',
                        message: 'Sorry, there was an error processing your voice message. Please try again.',
                        timestamp: new Date().toLocaleTimeString(),
                        status: 'error'
                    });
                    this.isTyping = false;
                    this.isProcessingAudio = false;
                }
            };
            
            // Add the event listener
            this.$el.addEventListener('audio-message', this.handleAudioMessage);
        },
        
        formatDuration(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
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

            // Add user message with animation delay
            const userMessage = {
                type: 'user',
                message: message,
                timestamp: new Date().toLocaleTimeString()
            };
            
            // Clear input immediately
            messageInput.value = '';
            
            // Add user message with slight delay
            setTimeout(() => {
                this.messages.push(userMessage);
                this.$nextTick(() => {
                    anime({
                        targets: this.$refs.chatMessages.lastElementChild,
                        translateY: [20, 0],
                        opacity: [0, 1],
                        duration: 500,
                        easing: 'easeOutCubic'
                    });
                });
            }, 100);

            // Show typing indicator with delay
            setTimeout(() => {
                this.isTyping = true;
            }, 500);

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
                
                // Delay the response to feel more natural
                setTimeout(() => {
                    this.isTyping = false;
                    const response = {
                        type: 'assistant',
                        message: data.message,
                        timestamp: new Date().toLocaleTimeString()
                    };
                    
                    this.messages.push(response);
                    this.$nextTick(() => {
                        const lastMessage = this.$refs.chatMessages.lastElementChild;
                        anime({
                            targets: lastMessage,
                            translateY: [20, 0],
                            opacity: [0, 1],
                            duration: 600,
                            easing: 'easeOutCubic'
                        });
                        
                        // Smooth scroll to bottom
                        anime({
                            targets: this.$refs.chatMessages,
                            scrollTop: this.$refs.chatMessages.scrollHeight,
                            duration: 600,
                            easing: 'easeInOutQuad'
                        });
                    });
                }, 1000);
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
    class="chat-interface"
    @theme-changed.window="theme = $event.detail; applyTheme($event.detail)"
>
    <div class="flex h-full chat-interface-container theme-dark">
        <!-- Sidebar -->
        <div class="w-80 flex flex-col sidebar-bg border-r sidebar-border">
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
                <div class="relative">
                    <button 
                        @click="$dispatch('settings-toggle')"
                        class="flex items-center justify-center gap-2 w-full p-2 text-gray-400 hover:text-gray-300 rounded"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </button>
                    <x-chat.settings-panel />
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col main-bg">
            <div class="flex-1 overflow-y-auto custom-scrollbar" x-ref="chatMessages">
                <template x-if="messages.length === 0">
                    <div class="flex flex-col items-center justify-center h-full text-center px-4">
                        <div class="w-24 h-24 empty-state-icon-bg rounded-full mb-4 flex items-center justify-center relative">
                            <svg class="w-12 h-12 empty-state-icon absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold empty-state-title mb-2">Start a Conversation</h3>
                        <p class="empty-state-text">Send a message to begin chatting with AI Sensei</p>
                    </div>
                </template>

        <template x-for="(msg, index) in messages" :key="index">
            <div class="p-4">
                <div class="flex gap-3" :class="msg.type === 'user' ? 'flex-row-reverse' : ''">
                    <div class="flex-none">
                        <div class="w-8 h-8 rounded-full message-avatar flex items-center justify-center">
                            <template x-if="msg.type === 'assistant'">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </template>
                            <template x-if="msg.type === 'system'">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </template>
                            <template x-if="msg.type === 'user' && msg.isAudio">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </template>
                            <template x-if="msg.type === 'user' && !msg.isAudio">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </template>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1" :class="msg.type === 'user' ? 'flex-row-reverse' : ''">
                            <span class="text-sm font-medium" :class="{
                                'text-blue-400': msg.type === 'assistant',
                                'text-purple-400': msg.type === 'user' && msg.isAudio,
                                'text-green-400': msg.type === 'user' && !msg.isAudio,
                                'text-red-400': msg.type === 'system'
                            }" x-text="msg.type === 'assistant' ? 'AI Sensei' : (msg.type === 'system' ? 'System' : 'You')"></span>
                            <span class="text-xs message-timestamp" x-text="msg.timestamp"></span>
                        </div>
                        <div class="p-3 rounded-lg message-bubble" :class="{
                            'message-bubble-assistant': msg.type === 'assistant',
                            'message-bubble-user': msg.type === 'user',
                            'message-bubble-system': msg.type === 'system'
                        }">
                            <p class="whitespace-pre-wrap message-text" x-text="msg.message"></p>
                            <template x-if="msg.audio">
                                <audio
                                    :src="msg.audio"
                                    controls
                                    class="mt-2 w-full h-8 audio-player"
                                ></audio>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div x-show="isTyping" class="chat-typing">
            <x-chat.typing-indicator style="bubble" />
        </div>
    </div>

            <div class="p-4 main-bg footer-border">
                <form @submit.prevent="handleSendMessage" class="flex items-center gap-2">
                    @csrf
                    <div class="flex-1 input-bg rounded-lg border input-border focus-within:border-blue-500">
                        <div class="flex items-center px-3 py-2.5 gap-2">
                            <div class="relative flex items-center">
                                <button type="button" @click="$dispatch('emoji-picker-toggle')" class="text-gray-400 hover:text-gray-300 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                <x-chat.emoji-picker position="top" />
                            </div>
                            
                            <input
                                type="text"
                                x-ref="messageInput"
                                placeholder="Type a message..."
                                class="flex-1 bg-transparent border-none text-white placeholder-gray-400 focus:outline-none py-0.5"
                                @keydown.enter.prevent="handleSendMessage"
                                @emoji-selected.window="
                                    const input = $refs.messageInput;
                                    const start = input.selectionStart;
                                    const end = input.selectionEnd;
                                    input.value = input.value.substring(0, start) + $event.detail + input.value.substring(end);
                                    input.focus();
                                    input.setSelectionRange(start + $event.detail.length, start + $event.detail.length);
                                "
                                name="message"
                            />
                        </div>
                    </div>

                    <x-chat.audio-recorder />

                    <button type="submit" class="p-2.5 text-gray-400 hover:text-gray-300 flex items-center justify-center">
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
    height: var(--chat-height);
    max-width: 1200px;
    width: 100%;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
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

/* Theme System */
/* Dark Theme (Default) with Glassmorphism */
.theme-dark {
    background: rgba(17, 24, 39, 0.7);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
}

.theme-dark .sidebar-bg {
    background: rgba(17, 24, 39, 0.8);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.1);
}

.theme-dark .sidebar-border {
    border-color: rgba(255, 255, 255, 0.1);
}

.theme-dark .main-bg {
    background: rgba(17, 24, 39, 0.6);
    backdrop-filter: blur(10px) saturate(150%);
    -webkit-backdrop-filter: blur(10px) saturate(150%);
}

.theme-dark .footer-border {
    border-color: rgba(255, 255, 255, 0.1);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 
        0 -4px 16px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.theme-dark .input-bg {
    background: rgba(31, 41, 55, 0.6);
    backdrop-filter: blur(10px) saturate(150%);
    -webkit-backdrop-filter: blur(10px) saturate(150%);
    box-shadow: 
        0 2px 8px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.05),
        inset 0 -1px 0 rgba(0, 0, 0, 0.1);
}

.theme-dark .input-border {
    border-color: rgba(255, 255, 255, 0.1);
}

.theme-dark .message-avatar {
    background: rgba(55, 65, 81, 0.6);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 
        0 2px 8px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.theme-dark .message-bubble-assistant {
    background: rgba(31, 41, 55, 0.7);
    backdrop-filter: blur(10px) saturate(150%);
    -webkit-backdrop-filter: blur(10px) saturate(150%);
    color: #ffffff;
    box-shadow: 
        0 4px 16px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1),
        inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.theme-dark .message-bubble-user {
    background: rgba(59, 130, 246, 0.15);
    backdrop-filter: blur(10px) saturate(180%);
    -webkit-backdrop-filter: blur(10px) saturate(180%);
    color: #60a5fa;
    box-shadow: 
        0 4px 16px rgba(59, 130, 246, 0.2),
        inset 0 1px 0 rgba(96, 165, 250, 0.2),
        inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(96, 165, 250, 0.2);
}

.theme-dark .message-bubble-system {
    background: rgba(239, 68, 68, 0.15);
    backdrop-filter: blur(10px) saturate(180%);
    -webkit-backdrop-filter: blur(10px) saturate(180%);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
    box-shadow: 
        0 4px 16px rgba(239, 68, 68, 0.2),
        inset 0 1px 0 rgba(248, 113, 113, 0.2),
        inset 0 -1px 0 rgba(0, 0, 0, 0.1);
}

.theme-dark .message-timestamp {
    color: rgba(156, 163, 175, 0.8);
}

.theme-dark .message-text {
    color: inherit;
}

.theme-dark .empty-state-icon-bg {
    background: rgba(31, 41, 55, 0.5);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 
        0 4px 16px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    width: 96px;
    height: 96px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.theme-dark .empty-state-icon {
    color: #9ca3af;
}

.theme-dark .empty-state-title {
    color: #e5e7eb;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.theme-dark .empty-state-text {
    color: rgba(156, 163, 175, 0.8);
}

.theme-dark .audio-player {
    filter: invert(1) hue-rotate(180deg);
    opacity: 0.9;
}

/* Light Theme */
.theme-light {
    background: #f9fafb;
}

.theme-light .sidebar-bg {
    background: #ffffff;
}

.theme-light .sidebar-border {
    border-color: #e5e7eb;
}

.theme-light .main-bg {
    background: #f9fafb;
}

.theme-light .footer-border {
    border-color: #e5e7eb;
}

.theme-light .input-bg {
    background: #ffffff;
}

.theme-light .input-border {
    border-color: #d1d5db;
}

.theme-light .message-avatar {
    background: #e5e7eb;
}

.theme-light .message-bubble-assistant {
    background: #ffffff;
    color: #111827;
    border: 1px solid #e5e7eb;
}

.theme-light .message-bubble-user {
    background: #dbeafe;
    color: #1e40af;
}

.theme-light .message-bubble-system {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.theme-light .message-timestamp {
    color: #6b7280;
}

.theme-light .message-text {
    color: inherit;
}

.theme-light .empty-state-icon-bg {
    background: #f3f4f6;
    width: 96px;
    height: 96px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.theme-light .empty-state-icon {
    color: #6b7280;
}

.theme-light .empty-state-title {
    color: #111827;
}

.theme-light .empty-state-text {
    color: #6b7280;
}

.theme-light .audio-player {
    filter: none;
}

/* Light theme text colors */
.theme-light svg,
.theme-light button,
.theme-light input,
.theme-light select,
.theme-light label,
.theme-light h3,
.theme-light p {
    color: #111827;
}

.theme-light .text-gray-400,
.theme-light .text-gray-300,
.theme-light .text-gray-200,
.theme-light .text-gray-500 {
    color: #6b7280 !important;
}

.theme-light input::placeholder {
    color: #9ca3af;
}

/* Smooth theme transitions */
.chat-interface-container,
.sidebar-bg,
.main-bg,
.input-bg,
.message-avatar,
.message-bubble-assistant,
.message-bubble-user {
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}
</style>