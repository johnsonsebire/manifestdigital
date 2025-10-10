@props(['show' => false])

<div
    x-data="{ 
        show: false,
        settings: {
            notifications: true,
            sound: true,
            theme: 'dark',
            fontSize: 'medium'
        }
    }"
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
                class="relative w-10 h-6 transition-colors duration-200 ease-in-out bg-gray-600 rounded-full"
                :class="{ 'bg-blue-500': settings.notifications }"
            >
                <span
                    class="inline-block w-4 h-4 transition-transform duration-200 ease-in-out bg-white rounded-full transform translate-x-1"
                    :class="{ 'translate-x-5': settings.notifications }"
                ></span>
            </button>
        </div>

        <!-- Sound -->
        <div class="flex items-center justify-between">
            <label class="text-gray-300">Sound</label>
            <button 
                @click="settings.sound = !settings.sound"
                class="relative w-10 h-6 transition-colors duration-200 ease-in-out bg-gray-600 rounded-full"
                :class="{ 'bg-blue-500': settings.sound }"
            >
                <span
                    class="inline-block w-4 h-4 transition-transform duration-200 ease-in-out bg-white rounded-full transform translate-x-1"
                    :class="{ 'translate-x-5': settings.sound }"
                ></span>
            </button>
        </div>

        <!-- Theme -->
        <div class="space-y-2">
            <label class="text-gray-300">Theme</label>
            <select 
                x-model="settings.theme"
                class="w-full bg-gray-700 text-gray-300 rounded-lg p-2 border border-gray-600"
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
                class="w-full bg-gray-700 text-gray-300 rounded-lg p-2 border border-gray-600"
            >
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
        </div>
    </div>
</div>