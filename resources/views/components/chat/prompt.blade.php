@props(['text', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'])

<button 
    @click="$refs.messageInput.value = '{{ $text }}'; handleSendMessage()"
    {{ $attributes->merge(['class' => 'flex items-center space-x-2 w-full p-3 text-left text-gray-300 hover:bg-gray-800 rounded-lg transition-colors']) }}
>
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>
    <span>{{ $text }}</span>
</button>