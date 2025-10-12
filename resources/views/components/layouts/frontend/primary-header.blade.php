    <!-- Reading Tracker Progress Bar -->
    <div class="reading-tracker"></div>

    <x-notification-topbar :style="$notificationStyle" />

    <header class="primary-header {{ $transparent ? 'transparent' : '' }}">
        <a href="{{ url('/') }}" class="logo"></a>
      
        <nav>
            @foreach($navItems as $item)
                @if($item['type'] === 'link')
                    <a href="{{ url($item['url']) }}" class="{{ request()->is(trim($item['url'], '/*')) ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @elseif($item['type'] === 'mega-menu' && $showMegaMenu)
                    <x-mega-menu />
                @elseif($item['type'] === 'dropdown' && $showDropdown)
                    <x-drop-down />
                @endif
            @endforeach
        </nav>
        <div class="header-right">
            <a href="{{ route('login') }}" class="login">Login</a>
            <a href="{{ route('request-quote') }}" class="btn-primary">Get a Quote</a>
        </div>
        
        <!-- Mobile menu toggle -->
        <button class="mobile-menu-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <!-- Mobile navigation overlay -->
    <div class="mobile-nav-overlay"></div>
    
    <!-- Mobile navigation menu -->
    <div class="mobile-nav">
        <nav>
            @foreach($navItems as $item)
                @if($item['type'] === 'link')
                    <a href="{{ url($item['url']) }}" class="{{ request()->is(trim($item['url'], '/*')) ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>
        <div class="mobile-nav-buttons">
            <a href="{{ route('login') }}" class="login">Login</a>
            <a href="{{ route('request-quote') }}" class="btn-primary">Get a Quote</a>
        </div>
    </div>