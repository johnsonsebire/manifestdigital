@props(['position' => 'bottom'])

<div
    x-data="{ 
        show: false,
        emojis: ['👋', '😊', '🤔', '👍', '❤️', '🎉', '🔥', '💡', '✨', '🚀', '💪', '🙌', '👏', '🤝', '💯', '⭐', '🎯', '💫'],
        position: '{{ $position }}'
    }"
    x-show="show"
    @emoji-picker-toggle.window="show = !show"
    @click.away="show = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="absolute z-50 p-2 bg-gray-800 rounded-lg shadow-lg border border-gray-700"
    :class="{
        'bottom-full mb-2': position === 'top',
        'top-full mt-2': position === 'bottom'
    }"
    style="width: 250px;"
>
    <div class="grid grid-cols-6 gap-2">
        <template x-for="emoji in emojis" :key="emoji">
            <button
                type="button"
                @click.prevent.stop="$dispatch('emoji-selected', emoji); show = false"
                class="p-2 hover:bg-gray-700 rounded-lg transition-colors duration-150 text-xl"
                x-text="emoji"
            ></button>
        </template>
    </div>
</div>