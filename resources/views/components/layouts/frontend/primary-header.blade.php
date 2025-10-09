
    <x-layouts.frontend.preloader />
    <!-- Reading Tracker Progress Bar -->
    <div class="reading-tracker"></div>

    <x-notification-topbar />

    <header class="primary-header {{ $transparent ?? true ? 'transparent' : '' }}">
        <a href="{{ url('/') }}" class="logo">
        </a>
      
        <nav>
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('projects') }}" class="{{ request()->is('projects*') ? 'active' : '' }}">Projects</a>
            <a href="{{ url('ai-sensei-chat') }}" class="{{ request()->is('ai-sensei-chat*') ? 'active' : '' }}">AI Sensei</a>
            <!-- Mega Menu Component -->
             <div id="mega-menu-placeholder"></div> 
            <!-- Dropdown Component -->
            <div id="dropdown-placeholder"></div> 
            <a href="{{ url('book-a-call') }}" class="{{ request()->is('book-a-call*') ? 'active' : '' }}">Book a Call</a>
        </nav>
        <div class="header-right">
            <a href="{{ route('login') }}" class="login">Login</a>
            <a href="{{ url('quote-request') }}" class="btn-primary">Get a Quote</a>
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
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('projects') }}" class="{{ request()->is('projects*') ? 'active' : '' }}">Projects</a>
            <a href="{{ url('ai-sensei-chat') }}" class="{{ request()->is('ai-sensei-chat*') ? 'active' : '' }}">AI Sensei</a>
            <a href="{{ url('book-a-call') }}" class="{{ request()->is('book-a-call*') ? 'active' : '' }}">Book a Call</a>
        </nav>
        <div class="mobile-nav-buttons">
            <a href="{{ route('login') }}" class="login">Login</a>
            <a href="{{ url('quote-request') }}" class="btn-primary">Get a Quote</a>
        </div>
    </div>