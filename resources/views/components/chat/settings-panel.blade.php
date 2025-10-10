@props(['show' => false])

<div
    x-data="{ 
        show: false,
        settings: {
            notifications: true,
            sound: true,
            theme: 'dark',
            fontSize: 'medium'
        },
        
        init() {
            // Load saved settings
            const savedTheme = localStorage.getItem('chat-theme') || 'dark';
            const savedFontSize = localStorage.getItem('chat-fontSize') || 'medium';
            const savedNotifications = localStorage.getItem('chat-notifications') !== 'false';
            const savedSound = localStorage.getItem('chat-sound') !== 'false';
            
            this.settings.theme = savedTheme;
            this.settings.fontSize = savedFontSize;
            this.settings.notifications = savedNotifications;
            this.settings.sound = savedSound;
            
            // Watch for changes
            this.$watch('settings.theme', (value) => {
                localStorage.setItem('chat-theme', value);
                this.$dispatch('theme-changed', value);
            });
            
            this.$watch('settings.fontSize', (value) => {
                localStorage.setItem('chat-fontSize', value);
                this.$dispatch('font-size-changed', value);
            });
            
            this.$watch('settings.notifications', (value) => {
                localStorage.setItem('chat-notifications', value);
            });
            
            this.$watch('settings.sound', (value) => {
                localStorage.setItem('chat-sound', value);
            });
        }
    }"
    x-init="init"
    x-show="show"
    @settings-toggle.window="show = !show"
    @click.away="show = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 rounded-lg shadow-lg border border-gray-700 p-4"
>
    <h3 class="text-lg font-semibold text-gray-200 mb-4">Chat Settings</h3>
    
    <div class="space-y-4">
                <!-- Notifications -->
        <div class="flex items-center justify-between">
            <label class="text-gray-300">Notifications</label>
            <button 
                @click="settings.notifications = !settings.notifications"
                class="relative w-11 h-6 transition-colors duration-200 ease-in-out bg-gray-700 rounded-full"
                :class="{ 'bg-blue-600': settings.notifications }"
            >
                <span
                    class="absolute left-0.5 top-0.5 inline-block w-5 h-5 transition-transform duration-200 ease-in-out bg-white rounded-full shadow-sm transform"
                    :class="{ 'translate-x-5': settings.notifications }"
                ></span>
            </button>
        </div>

        <!-- Sound -->
        <div class="flex items-center justify-between">
            <label class="text-gray-300">Sound</label>
            <button 
                @click="settings.sound = !settings.sound"
                class="relative w-11 h-6 transition-colors duration-200 ease-in-out bg-gray-700 rounded-full"
                :class="{ 'bg-blue-600': settings.sound }"
            >
                <span
                    class="absolute left-0.5 top-0.5 inline-block w-5 h-5 transition-transform duration-200 ease-in-out bg-white rounded-full shadow-sm transform"
                    :class="{ 'translate-x-5': settings.sound }"
                ></span>
            </button>
        </div>

        <!-- Theme -->
        <div class="space-y-2">
            <label class="text-gray-300">Theme</label>
            <select 
                x-model="settings.theme"
                class="w-full bg-gray-800 text-gray-300 rounded-lg p-2.5 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none cursor-pointer"
                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%239CA3AF%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E');
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 1em;"
            >
                <option value="dark">Dark</option>
                <option value="light">Light</option>
                <option value="system">System</option>
            </select>
        </div>

        <!-- Font Size -->
        <div class="space-y-2">
            <label class="text-gray-300">Font Size</label>
            <select 
                x-model="settings.fontSize"
                class="w-full bg-gray-800 text-gray-300 rounded-lg p-2.5 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none cursor-pointer"
                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%239CA3AF%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E');
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 1em;"
            >
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
        </div>
    </div>
</div>