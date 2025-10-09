// AI Chat functionality
window.chat = () => ({
        messages: [],
        isTyping: false,
        audioContext: null,
        audioStream: null,
        mediaRecorder: null,
        audioChunks: [],

        init() {
            this.setupAudioContext();
            this.initializeVoiceRecording();
        },

        async setupAudioContext() {
            try {
                this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
            } catch (error) {
                console.error('AudioContext setup failed:', error);
            }
        },

        async initializeVoiceRecording() {
            try {
                this.audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(this.audioStream);

                this.mediaRecorder.ondataavailable = (event) => {
                    this.audioChunks.push(event.data);
                };

                this.mediaRecorder.onstop = async () => {
                    const audioBlob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    await this.processVoiceMessage(audioBlob);
                    this.audioChunks = [];
                };
            } catch (error) {
                console.error('Voice recording initialization failed:', error);
            }
        },

        async sendMessage(event) {
            const { text, attachments } = event.detail;
            if (!text.trim() && (!attachments || attachments.length === 0)) return;

            // Add user message
            this.messages.push({
                type: 'user',
                message: text,
                timestamp: new Date().toLocaleTimeString()
            });

            this.isTyping = true;

            try {
                const formData = new FormData();
                formData.append('message', text);
                
                if (attachments) {
                    attachments.forEach((file, index) => {
                        formData.append(`attachments[${index}]`, file);
                    });
                }

                const response = await fetch(route('ai.chat.message'), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                if (!response.ok) throw new Error('Message sending failed');

                const data = await response.json();

                // Add AI response
                this.messages.push({
                    type: 'assistant',
                    message: data.message,
                    timestamp: data.timestamp
                });

                // Play notification sound
                this.playNotificationSound();

            } catch (error) {
                console.error('Message sending failed:', error);
                this.messages.push({
                    type: 'system',
                    message: 'Failed to send message. Please try again.',
                    timestamp: new Date().toLocaleTimeString(),
                    status: 'error'
                });
            } finally {
                this.isTyping = false;
            }
        },

        async processVoiceMessage(audioBlob) {
            this.isTyping = true;

            try {
                const formData = new FormData();
                formData.append('audio', audioBlob);

                const response = await fetch(route('ai.chat.voice'), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                if (!response.ok) throw new Error('Voice processing failed');

                const data = await response.json();

                // Add transcription as user message
                this.messages.push({
                    type: 'user',
                    message: data.transcription,
                    timestamp: data.timestamp,
                    isVoice: true
                });

                // Process the transcribed text as a regular message
                await this.sendMessage({
                    detail: {
                        text: data.transcription,
                        attachments: []
                    }
                });

            } catch (error) {
                console.error('Voice processing failed:', error);
                this.messages.push({
                    type: 'system',
                    message: 'Failed to process voice message. Please try again.',
                    timestamp: new Date().toLocaleTimeString(),
                    status: 'error'
                });
            } finally {
                this.isTyping = false;
            }
        },

        playNotificationSound() {
            if (this.audioContext && document.hidden) {
                const oscillator = this.audioContext.createOscillator();
                const gainNode = this.audioContext.createGain();

                oscillator.connect(gainNode);
                gainNode.connect(this.audioContext.destination);

                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(440, this.audioContext.currentTime); // A4 note
                gainNode.gain.setValueAtTime(0.1, this.audioContext.currentTime);

                oscillator.start();
                oscillator.stop(this.audioContext.currentTime + 0.1);
            }
        },

        clearChat() {
            this.messages = [];
        },

        async exportChat() {
            const chat = this.messages.map(msg => ({
                role: msg.type,
                content: msg.message,
                timestamp: msg.timestamp
            }));

            const blob = new Blob([JSON.stringify(chat, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            
            const a = document.createElement('a');
            a.href = url;
            a.download = `chat-export-${new Date().toISOString()}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    }));
});