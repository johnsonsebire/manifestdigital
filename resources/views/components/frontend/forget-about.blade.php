@props([
    'title' => 'Forget about',
    'problems' => [],
    'decorativeImages' => [
        'starLeft' => 'frontend/images/decorative/cta_left_mem_dots_f_circle2.svg',
        'starRight' => 'frontend/images/decorative/mem_dots_f_tri.svg'
    ],
    'animateOnScroll' => true,
    'staggerChildren' => true
])

@php
$defaultProblems = [
    [
        'icon' => 'far fa-circle-xmark',
        'title' => 'Missed deadlines'
    ],
    [
        'icon' => 'far fa-face-tired',
        'title' => 'Unending excuses'
    ],
    [
        'icon' => 'far fa-comment-dots',
        'iconSmall' => 'far fa-circle-question',
        'title' => 'Poor communication'
    ],
    [
        'icon' => 'far fa-file-lines',
        'iconSmall' => 'fas fa-minus',
        'title' => 'Losing precious data'
    ],
    [
        'icon' => 'far fa-clock',
        'iconSmall' => 'fas fa-dollar-sign',
        'title' => 'Paying more for crappy services'
    ],
    [
        'icon' => 'fa-solid fa-triangle-exclamation',
        'iconSmall' => 'fas fa-chain-broken',
        'title' => 'Poor quality'
    ]
];

$problemsList = empty($problems) ? $defaultProblems : $problems;
@endphp

<section class="forget-about">
    <div class="forget-header{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        <img src="{{ asset($decorativeImages['starLeft']) }}" alt="" class="forget-star-left">
        <h2>{{ $title }}</h2>
        <img src="{{ asset($decorativeImages['starRight']) }}" alt="" class="forget-star-right">
    </div>
    
    <div class="forget-grid{{ $staggerChildren ? ' stagger-children' : '' }}">
        @foreach($problemsList as $problem)
            <div class="forget-item">
                <div class="forget-icon">
                    <i class="{{ $problem['icon'] }}"></i>
                    @if(isset($problem['iconSmall']))
                        <i class="{{ $problem['iconSmall'] }} forget-icon-small"></i>
                    @endif
                </div>
                <h3>{{ $problem['title'] }}</h3>
            </div>
        @endforeach
    </div>
</section>