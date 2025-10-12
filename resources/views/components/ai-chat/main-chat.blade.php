@props([
    'chatTitle' => 'AI Sensei Chat',
    'chatSubtitle' => 'Online • Ready to help',
    'welcomeTitle' => 'Welcome to AI Sensei!',
    'welcomeSubtitle' => "I'm here to help with all your digital business questions. What would you like to know?",
    'quickActions' => [
        '👋 Say Hello' => 'Hello!',
        '🔍 Your Services' => 'Tell me about your services',
        '📞 Book Call' => 'Book a consultation call',
        '💼 Portfolio' => 'Show me your portfolio',
        '💰 Pricing' => 'What are your pricing plans?'
    ],
    'suggestions' => [
        [
            'icon' => 'fas fa-rocket',
            'title' => 'Start Online Business',
            'text' => 'Get tips for launching your digital presence',
            'message' => 'How can I start an online business?'
        ],
        [
            'icon' => 'fas fa-dollar-sign',
            'title' => 'Website Pricing',
            'text' => 'Learn about development costs',
            'message' => 'What is the cost of website development?'
        ],
        [
            'icon' => 'fas fa-search',
            'title' => 'SEO Tips',
            'text' => 'Boost your search rankings',
            'message' => 'How do I improve my website SEO?'
        ],
        [
            'icon' => 'fas fa-share-alt',
            'title' => 'Social Media',
            'text' => 'Effective marketing strategies',
            'message' => 'What social media strategy works best?'
        ]
    ]
])

<div class="chat-main">
    <!-- Chat Header -->
    <div class="chat-header">
        <div class="chat-status">
            <div class="status-dot"></div>
            <div>
                <div class="chat-title">{{ $chatTitle }}</div>
                <div class="chat-subtitle">{{ $chatSubtitle }}</div>
            </div>
        </div>
        <button class="btn btn-outline-light d-lg-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Messages Container -->
    <div class="messages-container" id="messagesContainer">
        <!-- Welcome Message -->
        <div class="welcome-container" id="welcomeContainer">
            <div class="welcome-icon">
                <i class="fas fa-robot"></i>
            </div>
            <h3 class="welcome-title">{{ $welcomeTitle }}</h3>
            <p class="welcome-subtitle">{{ $welcomeSubtitle }}</p>

            <div class="welcome-suggestions">
                @foreach($suggestions as $suggestion)
                <div class="suggestion-card" onclick="sendQuickMessage('{{ $suggestion['message'] }}')">
                    <i class="{{ $suggestion['icon'] }}"></i>
                    <div class="suggestion-title">{{ $suggestion['title'] }}</div>
                    <div class="suggestion-text">{{ $suggestion['text'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typingIndicator">
            <div class="message">
                <div class="message-avatar ai">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="typing-dots">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Input Container -->
    <div class="chat-input-container">
        <!-- Quick Actions -->
        <div class="quick-actions">
            @foreach($quickActions as $buttonText => $messageText)
            <button class="quick-action-btn" onclick="sendQuickMessage('{{ $messageText }}')">{{ $buttonText }}</button>
            @endforeach
        </div>

        <!-- Input Form -->
        <form class="chat-input-form" id="chatForm">
            <textarea class="chat-input" id="messageInput"
                placeholder="Ask me anything about web development, marketing, or business growth..."
                rows="1"></textarea>
            <div class="input-actions">
                <button type="button" class="voice-btn" id="voiceBtn" onclick="toggleVoiceInput()">
                    <i class="fas fa-microphone"></i>
                </button>
                <button type="submit" class="send-btn" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>