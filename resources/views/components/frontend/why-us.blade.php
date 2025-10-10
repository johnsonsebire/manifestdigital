@props([
    'title' => 'Why Purpose-Driven Organizations <br /> Choose Manifest Digital',
    'highlightColor' => '#ff2200',
    'content' => [],
    'decorativeImages' => [
        'leftDots' => 'images/decorative/cta_left_mem_dots_f_circle2.svg',
        'rightShapes' => 'images/decorative/mem_dots_f_tri.svg'
    ],
    'animateOnScroll' => true
])

@php
$defaultContent = [
    [
        'text' => 'Since 2014, we\'ve been delivering data-driven, customer-centric digital solutions that drive real business results for organizations that matter.',
        'class' => 'why-intro',
        'bold' => ['data-driven, customer-centric digital solutions']
    ],
    [
        'text' => 'With over 10 years of proven excellence, Manifest Digital brings together a full-stack team of developers, Software Engineers, UX designers, brand strategists, and project managers under one roof. What typically requires coordinating multiple agencies, we deliver seamlessly as your single, trusted digital partner.',
        'class' => 'why-emphasis',
        'bold' => ['10 years of proven excellence', 'single, trusted digital partner']
    ],
    [
        'text' => 'Skip the lengthy hiring process, eliminate freelancer uncertainty, and forget about managing multiple vendors. Our people-first approach means transparent communication, consistent quality, and dedicated support throughout your project journey—all at a fraction of the cost of building an in-house team.',
        'class' => 'why-contrast',
        'bold' => ['people-first approach']
    ],
    [
        'text' => 'We\'ve helped organizations across Ghana, UK, and USA—from nonprofits to enterprises—achieve their digital goals. Our clients report 50% traffic increases, improved conversions, and measurable ROI. Join purpose-driven organizations worldwide who trust Manifest Digital to deliver, period.',
        'class' => 'why-solution',
        'bold' => ['50% traffic increases', 'deliver, period']
    ]
];

$contentList = empty($content) ? $defaultContent : $content;

// Function to highlight bold text
function highlightBoldText($text, $boldPhrases = []) {
    foreach ($boldPhrases as $phrase) {
        $text = str_replace($phrase, "<strong>{$phrase}</strong>", $text);
    }
    return $text;
}
@endphp

<section class="why-us">
    <!-- Decorative elements for why-us section -->
    <img src="{{ asset($decorativeImages['leftDots']) }}" alt="" class="decorative-element why-left-dots">
    <img src="{{ asset($decorativeImages['rightShapes']) }}" alt="" class="decorative-element why-right-shapes">
    
    <h2{{ $animateOnScroll ? ' class=animate-on-scroll' : '' }}>
        {!! str_replace(['Purpose-Driven', 'Manifest Digital'], 
            ['<span style="color: ' . $highlightColor . ';">Purpose-Driven</span>', 
             '<span style="color: ' . $highlightColor . ';">Manifest Digital</span>'], 
            $title) !!}
    </h2>
    
    <div class="why-content{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        @foreach($contentList as $paragraph)
            <p class="{{ $paragraph['class'] ?? '' }}">
                {!! highlightBoldText($paragraph['text'], $paragraph['bold'] ?? []) !!}
            </p>
        @endforeach
    </div>
</section>