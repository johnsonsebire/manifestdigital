@props([
    'placeholder' => 'Type your message...',
    'hasVoiceSupport' => true,
    'hasEmojiPicker' => true,
    'hasAttachments' => false,
])

<div
    x-data="{
        message: '',
        isRecording: false,
        showEmojiPicker: false,
        attachments: [],
        mediaRecorder: null,
        audioChunks: [],
        
        init() {
            if (this.hasVoiceSupport) {
                this.initializeVoiceRecording();
            }
        },
        
        async initializeVoiceRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(stream);
                
                this.mediaRecorder.ondataavailable = (event) => {
                    this.audioChunks.push(event.data);
                };
                
                this.mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    this.audioChunks = [];
                    this.$dispatch('voice-message', { audio: audioBlob });
                };
            } catch (err) {
                console.error('Voice recording not available:', err);
            }
        },
        
        startRecording() {
            if (this.mediaRecorder && this.mediaRecorder.state === 'inactive') {
                this.isRecording = true;
                this.mediaRecorder.start();
            }
        },
        
        stopRecording() {
            if (this.mediaRecorder && this.mediaRecorder.state === 'recording') {
                this.isRecording = false;
                this.mediaRecorder.stop();
            }
        },
        
        handleEmojiSelect(emoji) {
            this.message += emoji;
            this.showEmojiPicker = false;
            this.$refs.messageInput.focus();
        },
        
        handleAttachment(event) {
            const files = Array.from(event.target.files);
            this.attachments = [...this.attachments, ...files];
        },
        
        removeAttachment(index) {
            this.attachments.splice(index, 1);
        },
        
        sendMessage() {
            if (this.message.trim() || this.attachments.length > 0) {
                this.$dispatch('send-message', {
                    text: this.message,
                    attachments: this.attachments
                });
                this.message = '';
                this.attachments = [];
            }
        }
    }"
    class="chat-input-wrapper"
>
    @if($hasEmojiPicker)
        <div
            x-show="showEmojiPicker"
            @click.away="showEmojiPicker = false"
            class="emoji-picker"
        >
            <div class="emoji-picker-header">
                <input type="text" placeholder="Search emojis..." class="emoji-search">
            </div>
            <div class="emoji-list">
                <!-- Simplified emoji list for demo -->
                @php
                    $emojis = ['😊', '😂', '🥰', '😎', '🤔', '👍', '🎉', '❤️', '🔥', '✨'];
                @endphp
                
                @foreach($emojis as $emoji)
                    <button
                        @click="handleEmojiSelect('{{ $emoji }}')"
                        class="emoji-btn"
                    >{{ $emoji }}</button>
                @endforeach
            </div>
        </div>
    @endif

    <div class="chat-input">
        <div class="chat-input-actions">
            @if($hasEmojiPicker)
                <button
                    @click="showEmojiPicker = !showEmojiPicker"
                    class="chat-input-btn"
                    :class="{ 'active': showEmojiPicker }"
                    title="Open emoji picker"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                </button>
            @endif

            @if($hasAttachments)
                <label class="chat-input-btn" title="Attach files">
                    <input
                        type="file"
                        @change="handleAttachment"
                        multiple
                        class="hidden"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                </label>
            @endif
        </div>

        <div class="chat-input-field">
            <textarea
                x-ref="messageInput"
                x-model="message"
                @keydown.enter.prevent="sendMessage"
                :placeholder="isRecording ? 'Recording...' : '{{ $placeholder }}'"
                :disabled="isRecording"
                rows="1"
                class="chat-textarea"
            ></textarea>
        </div>

        <div class="chat-input-actions">
            @if($hasVoiceSupport)
                <button
                    @mousedown="startRecording"
                    @mouseup="stopRecording"
                    @mouseleave="stopRecording"
                    class="chat-input-btn"
                    :class="{ 'recording': isRecording }"
                    title="Hold to record voice message"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                        <line x1="12" y1="19" x2="12" y2="23"></line>
                        <line x1="8" y1="23" x2="16" y2="23"></line>
                    </svg>
                </button>
            @endif

            <button
                @click="sendMessage"
                class="chat-input-btn send-btn"
                :class="{ 'active': message.trim() || attachments.length > 0 }"
                title="Send message"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </div>
    </div>

    <template x-if="attachments.length > 0">
        <div class="chat-attachments">
            <template x-for="(file, index) in attachments" :key="index">
                <div class="chat-attachment">
                    <span x-text="file.name"></span>
                    <button
                        @click="removeAttachment(index)"
                        class="remove-attachment"
                        title="Remove attachment"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>

<style>
.chat-input-wrapper {
    position: relative;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 8px;
}

.chat-input {
    display: flex;
    align-items: flex-end;
    gap: 8px;
}

.chat-input-actions {
    display: flex;
    gap: 4px;
}

.chat-input-btn {
    padding: 8px;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.chat-input-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.9);
}

.chat-input-btn.active {
    background: rgba(255, 34, 0, 0.15);
    color: rgba(255, 34, 0, 0.9);
}

.chat-input-btn.recording {
    background: rgba(255, 34, 0, 0.15);
    color: rgba(255, 34, 0, 0.9);
    animation: pulse 1.5s infinite;
}

.chat-input-btn svg {
    width: 20px;
    height: 20px;
}

.chat-input-field {
    flex: 1;
    min-width: 0;
}

.chat-textarea {
    width: 100%;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 15px;
    line-height: 1.5;
    resize: none;
    transition: all 0.2s ease;
}

.chat-textarea:focus {
    outline: none;
    border-color: rgba(255, 34, 0, 0.3);
    background: rgba(255, 255, 255, 0.07);
}

.chat-textarea::placeholder {
    color: rgba(255, 255, 255, 0.4);
}

.send-btn {
    padding: 8px;
    background: rgba(255, 34, 0, 0.15);
    color: rgba(255, 34, 0, 0.6);
    opacity: 0.5;
    transform: scale(0.95);
    transition: all 0.2s ease;
}

.send-btn.active {
    opacity: 1;
    transform: scale(1);
    color: rgba(255, 34, 0, 0.9);
}

.send-btn:hover.active {
    background: rgba(255, 34, 0, 0.25);
}

/* Emoji Picker */
.emoji-picker {
    position: absolute;
    bottom: calc(100% + 8px);
    left: 0;
    width: 300px;
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    z-index: 1000;
}

.emoji-picker-header {
    padding: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.emoji-search {
    width: 100%;
    padding: 8px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
}

.emoji-search:focus {
    outline: none;
    border-color: rgba(255, 34, 0, 0.3);
}

.emoji-list {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 4px;
    padding: 8px;
    max-height: 200px;
    overflow-y: auto;
}

.emoji-btn {
    padding: 6px;
    background: transparent;
    border: none;
    font-size: 20px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.emoji-btn:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Attachments */
.chat-attachments {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 8px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: 8px;
}

.chat-attachment {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px 4px 12px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.8);
}

.remove-attachment {
    padding: 4px;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.remove-attachment:hover {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.9);
}

.remove-attachment svg {
    width: 14px;
    height: 14px;
}

.hidden {
    display: none;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 34, 0, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 34, 0, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 34, 0, 0);
    }
}
</style>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const textareas = document.querySelectorAll('.chat-textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
});
</script>
@endpush
@endonce