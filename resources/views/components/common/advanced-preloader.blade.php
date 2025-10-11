@props([
    'logo' => 'resources/images/logos/logo.png',
    'loadingText' => 'Loading amazing experiences...'
])

<div id="preloader">
    <div class="preloader-bg-animation"></div>
    <div class="preloader-rotating-border"></div>
    <div class="preloader-container">
        <div class="preloader-content">
            <div class="preloader-logo">
                <img src="{{Vite::asset($logo)}}" alt="Manifest Digital">
            </div>
            <div class="preloader-dots">
                <div class="preloader-dot"></div>
                <div class="preloader-dot"></div>
                <div class="preloader-dot"></div>
            </div>
            <div class="preloader-progress">
                <div class="preloader-progress-bar"></div>
            </div>
            <div class="preloader-text">{{ $loadingText }}</div>
        </div>
    </div>
</div>
