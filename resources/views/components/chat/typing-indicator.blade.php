@props([
    'style' => 'default', // default, minimal, or bubble
])

@php
    $styles = [
        'default' => 'typing-indicator-default',
        'minimal' => 'typing-indicator-minimal',
        'bubble' => 'typing-indicator-bubble'
    ];
    $selectedStyle = $styles[$style] ?? $styles['default'];
@endphp

<div class="typing-indicator {{ $selectedStyle }}" x-show="isTyping">
    @if($style === 'bubble')
        <div class="typing-bubble">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    @else
        <div class="typing-dots">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
        @if($style === 'default')
            <div class="typing-text">AI is thinking...</div>
        @endif
    @endif
</div>

<style>
.typing-indicator {
    display: inline-flex;
    align-items: center;
    padding: 12px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

/* Default Style */
.typing-indicator-default {
    gap: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.typing-indicator-default .typing-dots {
    display: flex;
    gap: 6px;
}

.typing-indicator-default .typing-dot {
    width: 8px;
    height: 8px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    animation: typingBounce 1.4s infinite ease-in-out both;
}

.typing-indicator-default .typing-text {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    font-weight: 500;
}

/* Minimal Style */
.typing-indicator-minimal {
    padding: 8px;
    background: transparent;
}

.typing-indicator-minimal .typing-dots {
    display: flex;
    gap: 4px;
}

.typing-indicator-minimal .typing-dot {
    width: 6px;
    height: 6px;
    background: rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    animation: typingFade 1s infinite ease-in-out both;
}

/* Bubble Style */
.typing-indicator-bubble {
    padding: 0;
    background: transparent;
}

.typing-indicator-bubble .typing-bubble {
    display: flex;
    align-items: center;
    gap: 3px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
}

.typing-indicator-bubble .typing-dot {
    width: 5px;
    height: 5px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: typingScale 1s infinite ease-in-out both;
}

/* Dot Animations */
.typing-dot:nth-child(1) { animation-delay: -0.32s; }
.typing-dot:nth-child(2) { animation-delay: -0.16s; }
.typing-dot:nth-child(3) { animation-delay: 0s; }

@keyframes typingBounce {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.6;
    }
    40% {
        transform: scale(1.2);
        opacity: 1;
    }
}

@keyframes typingFade {
    0%, 80%, 100% { opacity: 0.3; }
    40% { opacity: 0.8; }
}

@keyframes typingScale {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.4;
    }
    40% {
        transform: scale(1);
        opacity: 0.8;
    }
}
</style>