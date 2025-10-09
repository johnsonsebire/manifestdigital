@props(['menuItems' => [
    [
        'icon' => 'fas fa-users',
        'label' => 'About Us',
        'url' => 'about'
    ],
    [
        'icon' => 'fas fa-blog',
        'label' => 'Blog',
        'url' => 'blog'
    ],
    [
        'icon' => 'fas fa-briefcase',
        'label' => 'Case Studies',
        'url' => 'projects'
    ],
    [
        'icon' => 'fas fa-shield-alt',
        'label' => 'Privacy & Terms',
        'url' => 'policies'
    ]
]])

<!-- Dropdown Component -->
<div class="nav-dropdown" x-data="{ isOpen: false }" @click.away="isOpen = false">
    <a href="#" 
       class="dropdown-toggle" 
       @click.prevent="isOpen = !isOpen"
       :aria-expanded="isOpen">
        Company <i class="fas fa-chevron-down" :class="{ 'rotate-180': isOpen }"></i>
    </a>
    <div class="dropdown-menu" 
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         style="display: none;">
        @foreach($menuItems as $item)
            <a href="{{ url($item['url']) }}" 
               class="{{ request()->is($item['url']) ? 'active' : '' }}">
                <i class="{{ $item['icon'] }}"></i> {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</div>
