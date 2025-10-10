@props(['position' => 'bottom'])

<div
    x-data="{
        isRecording: false,
        mediaRecorder: null,
        audioChunks: [],
        audioUrl: null,
        duration: 0,
        durationTimer: null,
        permissionGranted: false,
        
        async requestPermission() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.setupRecorder(stream);
                this.permissionGranted = true;
            } catch (err) {
                console.error('Microphone permission denied:', err);
                // Show error message to user
                $dispatch('show-toast', { 
                    message: 'Please allow microphone access to record audio messages',
                    type: 'error'
                });
            }
        },
        
        setupRecorder(stream) {
            this.mediaRecorder = new MediaRecorder(stream);
            
            this.mediaRecorder.addEventListener('dataavailable', (event) => {
                this.audioChunks.push(event.data);
            });
            
            this.mediaRecorder.addEventListener('stop', () => {
                const audioBlob = new Blob(this.audioChunks, { type: 'audio/mp3' });
                this.audioUrl = URL.createObjectURL(audioBlob);
                this.audioChunks = [];
            });
        },
        
        startRecording() {
            if (!this.permissionGranted) {
                this.requestPermission();
                return;
            }
            
            this.isRecording = true;
            this.audioChunks = [];
            this.duration = 0;
            this.mediaRecorder.start();
            
            // Start duration timer
            this.durationTimer = setInterval(() => {
                this.duration++;
            }, 1000);
            
            // Dispatch recording started event
            $dispatch('recording-started');
        },
        
        stopRecording() {
            if (!this.isRecording) return;
            
            this.mediaRecorder.stop();
            this.isRecording = false;
            clearInterval(this.durationTimer);
            
            // Dispatch recording stopped event
            $dispatch('recording-stopped');
        },
        
        cancelRecording() {
            this.stopRecording();
            this.audioUrl = null;
            this.duration = 0;
            this.audioChunks = [];
        },
        
        async submitRecording() {
            if (!this.audioUrl) return;
            
            // Convert blob URL to blob data
            const response = await fetch(this.audioUrl);
            const blob = await response.blob();
            
            // Create form data
            const formData = new FormData();
            formData.append('audio', blob, 'recording.mp3');
            
            // Dispatch event with audio data
            $dispatch('audio-message', { 
                audioBlob: blob,
                duration: this.duration,
                url: this.audioUrl
            });
            
            // Reset state
            this.cancelRecording();
        },
        
        formatDuration(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
        }
    }"
    class="relative"
>
    <button 
        type="button"
        @click="isRecording ? stopRecording() : startRecording()"
        class="p-2 rounded-full transition-colors duration-200"
        :class="isRecording ? 'text-red-500 bg-red-500/10' : 'text-gray-400 hover:text-gray-300'"
    >
        <template x-if="!isRecording">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
            </svg>
        </template>
        <template x-if="isRecording">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <rect x="6" y="6" width="12" height="12" rx="2" />
            </svg>
        </template>
    </button>

    <!-- Recording Status -->
    <div
        x-show="isRecording || audioUrl"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute bottom-full mb-2 right-0 bg-gray-800 rounded-lg shadow-lg border border-gray-700 p-3 min-w-[200px]"
    >
        <div class="flex items-center gap-3">
            <!-- Recording Indicator -->
            <div x-show="isRecording" class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                <span class="text-sm text-gray-300">Recording...</span>
            </div>
            
            <!-- Duration -->
            <span class="text-sm text-gray-400" x-text="formatDuration(duration)"></span>
            
            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    @click="cancelRecording"
                    class="p-1 text-gray-400 hover:text-gray-300"
                    title="Cancel"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <button
                    x-show="audioUrl"
                    type="button"
                    @click="submitRecording"
                    class="p-1 text-blue-400 hover:text-blue-300"
                    title="Send"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Audio Preview -->
        <template x-if="audioUrl">
            <audio
                :src="audioUrl"
                controls
                class="mt-2 w-full h-8"
            ></audio>
        </template>
    </div>
</div>