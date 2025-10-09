@php
$initialMessages = [
    [
        'type' => 'assistant',
        'message' => "Hello! I'm your AI assistant. How can I help you today?",
        'timestamp' => now()->format('g:i A')
    ]
];
@endphp

<x-layouts.chat
    title="Chat with AI Assistant"
    description="Get instant help and answers from our AI assistant"
>
    <x-chat.interface
        :initialMessages="$initialMessages"
        title="AI Assistant"
        :aiAvatar="asset('frontend/images/ai-avatar.png')"
    />
</x-layouts.chat>