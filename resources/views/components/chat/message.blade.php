@props([
    'message',
    'type' => 'user', // user, assistant, or system
    'avatar' => null,
    'timestamp' => null,
    'status' => 'sent', // sent, delivered, read, or error
    'isLoading' => false,
    'showActions' => true
])

<div class="chat-message chat-message-{{ $type }} {{ $isLoading ? 'is-loading' : '' }}">
    <div class="chat-message-avatar">
        @if($avatar)
            <img src="{{ asset($avatar) }}" alt="{{ ucfirst($type) }} Avatar">
        @else
            <div class="chat-message-avatar-placeholder">
                @if($type === 'user')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                @endif
            </div>
        @endif
    </div>

    <div class="chat-message-content">
        <div class="chat-message-header">
            <span class="chat-message-name">{{ ucfirst($type) }}</span>
            @if($timestamp)
                <span class="chat-message-time">{{ $timestamp }}</span>
            @endif
        </div>

        <div class="chat-message-body">
            {{ $message }}
        </div>

        @if($showActions)
            <div class="chat-message-actions">
                <button class="chat-action-btn" title="Copy message">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                    </svg>
                </button>
                @if($type === 'assistant')
                    <button class="chat-action-btn" title="Regenerate response">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 4v6h-6"></path>
                            <path d="M1 20v-6h6"></path>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10"></path>
                            <path d="M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                        </svg>
                    </button>
                @endif
            </div>
        @endif

        @if($status !== 'sent' || $isLoading)
            <div class="chat-message-status">
                @if($isLoading)
                    <x-chat.typing-indicator style="minimal" />
                @elseif($status === 'delivered')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M20 6L9 17l-5-5"></path>
                    </svg>
                @elseif($status === 'read')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M20 6L9 17l-5-5"></path>
                        <path d="M23 6L12 17l-5-5"></path>
                    </svg>
                @elseif($status === 'error')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
.chat-message {
    display: flex;
    gap: 16px;
    padding: 16px;
    transition: background-color 0.2s ease;
}

.chat-message:hover {
    background: rgba(255, 255, 255, 0.02);
}

.chat-message.is-loading .chat-message-body {
    opacity: 0.7;
}

.chat-message-avatar {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.05);
}

.chat-message-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-message-avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.7);
}

.chat-message-avatar-placeholder svg {
    width: 24px;
    height: 24px;
}

.chat-message-content {
    flex: 1;
    min-width: 0;
    position: relative;
}

.chat-message-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.chat-message-name {
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
}

.chat-message-time {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.5);
}

.chat-message-body {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.5;
    font-size: 15px;
    white-space: pre-wrap;
    word-break: break-word;
}

.chat-message-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.chat-message:hover .chat-message-actions {
    opacity: 1;
}

.chat-action-btn {
    padding: 6px;
    border: none;
    background: transparent;
    color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.chat-action-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.9);
}

.chat-action-btn svg {
    width: 16px;
    height: 16px;
}

.chat-message-status {
    position: absolute;
    right: 0;
    bottom: -4px;
    display: flex;
    align-items: center;
    gap: 4px;
    color: rgba(255, 255, 255, 0.5);
}

.chat-message-status svg {
    width: 16px;
    height: 16px;
}

/* Message Type Styles */
.chat-message-user {
    background: rgba(255, 255, 255, 0.02);
}

.chat-message-assistant {
    background: rgba(255, 34, 0, 0.03);
}

.chat-message-system {
    background: rgba(0, 102, 255, 0.03);
}
</style>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy message functionality
    document.querySelectorAll('.chat-action-btn[title="Copy message"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const message = this.closest('.chat-message').querySelector('.chat-message-body').textContent;
            navigator.clipboard.writeText(message.trim()).then(() => {
                // Show feedback
                const originalTitle = this.getAttribute('title');
                this.setAttribute('title', 'Copied!');
                setTimeout(() => {
                    this.setAttribute('title', originalTitle);
                }, 2000);
            });
        });
    });
});
</script>
@endpush
@endonce