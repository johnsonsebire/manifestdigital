// Chat component
export default () => ({
    messages: [],
    hasUnreadMessages: false,
    isTyping: false,
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
            this.audioPlayer.src = '/sounds/notification.mp3';
            this.audioPlayer.play();
        }
    },
    
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
            const response = await fetch('/ai/chat/message', {
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
    },
    
    async handleVoiceMessage(event) {
        const { audio } = event.detail;
        if (!audio) return;
        
        // Show typing indicator
        this.isTyping = true;
        
        try {
            const formData = new FormData();
            formData.append('audio', audio);
            
            const response = await fetch('/ai/chat/voice', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            
            // Add transcribed message as user message
            if (data.transcription) {
                this.messages.push({
                    type: 'user',
                    message: data.transcription,
                    timestamp: new Date().toLocaleTimeString()
                });
            }
            
            // Add AI response if present
            if (data.response) {
                this.messages.push({
                    type: 'assistant',
                    message: data.response,
                    timestamp: new Date().toLocaleTimeString()
                });
            }
        } catch (error) {
            console.error('Error processing voice message:', error);
            this.messages.push({
                type: 'system',
                message: 'Sorry, there was an error processing your voice message. Please try again.',
                timestamp: new Date().toLocaleTimeString(),
                status: 'error'
            });
        } finally {
            this.isTyping = false;
            this.scrollToBottom();
        }
    }
});