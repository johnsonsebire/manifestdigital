@props([
    'aiTitle' => 'AI Sensei',
    'aiSubtitle' => 'Your Digital Business Assistant',
    'quickStarters' => [
        '💻 Web Development Services' => 'Tell me about your web development services',
        '📱 Digital Marketing Tips' => 'What digital marketing strategies do you recommend?',
        '🚀 Business Growth Ideas' => 'How can I improve my business online presence?',
        '🎨 Design Trends 2024' => 'What are the latest web design trends?'
    ],
    'capabilities' => [
        ['icon' => 'fas fa-code', 'title' => 'Web Development'],
        ['icon' => 'fas fa-chart-line', 'title' => 'Digital Marketing'],
        ['icon' => 'fas fa-palette', 'title' => 'UI/UX Design'],
        ['icon' => 'fas fa-search', 'title' => 'SEO Optimization'],
        ['icon' => 'fas fa-mobile-alt', 'title' => 'Mobile Apps'],
        ['icon' => 'fas fa-lightbulb', 'title' => 'Business Strategy']
    ]
])

<div class="chat-sidebar" id="chatSidebar">
    <div class="sidebar-content">
        <!-- AI Avatar -->
        <div class="ai-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <h2 class="ai-title">{{ $aiTitle }}</h2>
        <p class="ai-subtitle">{{ $aiSubtitle }}</p>

        <!-- Conversation Starters -->
        <div class="sidebar-section">
            <h4><i class="fas fa-comments"></i> Quick Start</h4>
            @foreach($quickStarters as $buttonText => $messageText)
            <button class="starter-button" onclick="sendQuickMessage('{{ $messageText }}')">
                {{ $buttonText }}
            </button>
            @endforeach
        </div>

        <!-- AI Capabilities -->
        <div class="sidebar-section">
            <h4><i class="fas fa-brain"></i> I Can Help With</h4>
            @foreach($capabilities as $capability)
            <div class="capability-item">
                <i class="{{ $capability['icon'] }}"></i>
                <span>{{ $capability['title'] }}</span>
            </div>
            @endforeach
        </div>

        <!-- Clear Chat -->
        <div class="sidebar-section">
            <button class="clear-chat-btn" onclick="clearChat()">
                <i class="fas fa-trash"></i> Clear Chat History
            </button>
        </div>
    </div>
</div>