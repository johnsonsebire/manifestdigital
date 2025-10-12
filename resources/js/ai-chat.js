document.addEventListener("DOMContentLoaded", function() {
    // AI Chat functionality
let chatHistory = [];
let isVoiceRecording = false;

// Theme toggle functionality
function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');
    const isLightTheme = body.classList.contains('light-theme');

    if (isLightTheme) {
        body.classList.remove('light-theme');
        themeIcon.className = 'fas fa-sun';
        localStorage.setItem('aiSenseiTheme', 'dark');
    } else {
        body.classList.add('light-theme');
        themeIcon.className = 'fas fa-moon';
        localStorage.setItem('aiSenseiTheme', 'light');
    }
}

function loadTheme() {
    const savedTheme = localStorage.getItem('aiSenseiTheme');
    const themeIcon = document.getElementById('themeIcon');

    if (savedTheme === 'light') {
        document.body.classList.add('light-theme');
        themeIcon.className = 'fas fa-moon';
    } else {
        themeIcon.className = 'fas fa-sun';
    }
}

// Initialize chat
document.addEventListener('DOMContentLoaded', function () {
    loadTheme();
    loadChatHistory();
    adjustTextareaHeight();

    // Auto-resize textarea
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.addEventListener('input', adjustTextareaHeight);

        // Handle Enter key (Shift+Enter for new line, Enter to send)
        messageInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    // Chat form submission
    const chatForm = document.getElementById('chatForm');
    if (chatForm) {
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            sendMessage();
        });
    }
});

function adjustTextareaHeight() {
    const textarea = document.getElementById('messageInput');
    if (textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
    }
}

function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    if (!messageInput) return;
    
    const message = messageInput.value.trim();

    if (!message) return;

    // Hide typing indicator first
    hideTypingIndicator();

    // Add user message
    addMessage(message, 'user');

    // Clear input
    messageInput.value = '';
    adjustTextareaHeight();

    // Hide welcome container
    const welcomeContainer = document.getElementById('welcomeContainer');
    if (welcomeContainer) {
        welcomeContainer.style.display = 'none';
    }

    // Show typing indicator AFTER user message
    showTypingIndicator();

    // Simulate AI response
    setTimeout(() => {
        const response = generateAIResponse(message);
        hideTypingIndicator();
        addMessage(response, 'ai');
        saveChatHistory();
    }, 1000 + Math.random() * 2000); // Random delay 1-3 seconds
}

function sendQuickMessage(message) {
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.value = message;
        sendMessage();
    }
}

function addMessage(content, sender) {
    const messagesContainer = document.getElementById('messagesContainer');
    if (!messagesContainer) return;
    
    const messageElement = document.createElement('div');
    messageElement.className = `message ${sender}`;

    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    messageElement.innerHTML = `
        <div class="message-avatar ${sender}">
            <i class="fas fa-${sender === 'ai' ? 'robot' : 'user'}"></i>
        </div>
        <div class="message-content ${sender}">
            ${content.replace(/\\n/g, '<br>').replace(/\n/g, '<br>')}
            <div class="message-time">${currentTime}</div>
        </div>
    `;

    messagesContainer.appendChild(messageElement);
    
    // Smart scrolling
    if (sender === 'ai') {
        setTimeout(() => {
            const targetScrollTop = messageElement.offsetTop - 60;
            messagesContainer.scrollTo({
                top: Math.max(0, targetScrollTop),
                behavior: 'smooth'
            });
        }, 200);
    } else {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Add to chat history
    chatHistory.push({
        content: content,
        sender: sender,
        timestamp: new Date().toISOString()
    });
}

function showTypingIndicator() {
    const typingIndicator = document.getElementById('typingIndicator');
    const messagesContainer = document.getElementById('messagesContainer');
    
    if (!typingIndicator || !messagesContainer) return;

    typingIndicator.style.display = 'none';
    messagesContainer.appendChild(typingIndicator);
    typingIndicator.style.display = 'flex';
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function hideTypingIndicator() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.style.display = 'none';
    }
}

function generateAIResponse(userMessage) {
    const message = userMessage.toLowerCase();

    // Simple response generation based on keywords
    if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
        return "Hello! 👋 I'm AI Sensei, your digital business assistant. I'm here to help you with web development, digital marketing, business growth strategies, and more. What can I help you with today?";
    }

    if (message.includes('web development') || message.includes('website')) {
        return "Great question about web development! 💻 At Manifest, we offer comprehensive web development services including:\\n\\n• Custom WordPress Development\\n• E-commerce Solutions\\n• Progressive Web Apps\\n• API Development\\n• Website Maintenance\\n\\nOur development process focuses on performance, security, and user experience. Would you like to know more about any specific service or discuss your project requirements?";
    }

    if (message.includes('digital marketing') || message.includes('marketing')) {
        return "Digital marketing is crucial for business growth! 📱 Here are some key strategies I recommend:\\n\\n• Content Marketing & SEO\\n• Social Media Management\\n• Email Marketing Campaigns\\n• Pay-Per-Click Advertising\\n• Analytics & Performance Tracking\\n\\nThe best strategy depends on your target audience and business goals. What type of business are you looking to promote?";
    }

    if (message.includes('pricing') || message.includes('cost') || message.includes('price')) {
        return "Our pricing is tailored to each project's unique requirements! 💰 Here's a general overview:\\n\\n• Basic Website: $500 - $2,000\\n• E-commerce Site: $2,000 - $10,000\\n• Custom Web App: $5,000 - $50,000\\n• Digital Marketing: $500 - $5,000/month\\n\\nFactors affecting cost include complexity, features, timeline, and ongoing support. Would you like a detailed quote for your specific project? I can connect you with our team for a free consultation!";
    }

    if (message.includes('seo') || message.includes('search')) {
        return "SEO is essential for online visibility! 🔍 Here are key strategies to improve your search rankings:\\n\\n• Keyword Research & Optimization\\n• Quality Content Creation\\n• Technical SEO (site speed, mobile-friendly)\\n• Local SEO for businesses\\n• Link Building & Authority\\n\\nSEO is a long-term investment that typically shows results in 3-6 months. Would you like me to analyze your current website or discuss a custom SEO strategy?";
    }

    if (message.includes('portfolio') || message.includes('projects') || message.includes('work')) {
        return "I'd love to show you our work! 💼 We've completed 50+ successful projects including:\\n\\n• KokoPlus - Fintech Mobile App\\n• Alpha Health Group - Healthcare Platform\\n• Bosch School - Educational Website\\n• CCEM Ghana - NGO Digital Presence\\n\\nEach project showcases our expertise in different industries. You can view our full portfolio at manifestghana.com/projects or I can discuss specific case studies relevant to your industry. What type of business are you in?";
    }

    if (message.includes('book') || message.includes('call') || message.includes('consultation') || message.includes('meeting')) {
        return "Perfect! I'd be happy to help you schedule a consultation! 📞 Here are your options:\\n\\n• Free Strategy Call (30 minutes)\\n• Technical Consultation (60 minutes)\\n• Project Planning Session (90 minutes)\\n\\nDuring the call, we'll discuss your goals, challenges, and how we can help. You can book directly at manifestghana.com/book-a-call or I can have our team contact you. Which option works best for you?";
    }

    if (message.includes('mobile app') || message.includes('app development')) {
        return "Mobile app development is one of our specialties! 📱 We create:\\n\\n• Native iOS & Android Apps\\n• Cross-Platform Solutions (React Native, Flutter)\\n• Progressive Web Apps (PWAs)\\n• App Store Optimization\\n• Ongoing Maintenance & Updates\\n\\nOur process includes UI/UX design, development, testing, and deployment. Apps typically take 3-8 months depending on complexity. What type of app are you considering?";
    }

    if (message.includes('business') || message.includes('grow') || message.includes('online presence')) {
        return "Growing your online presence is key to business success! 🚀 Here's a strategic approach:\\n\\n• Professional Website (your digital headquarters)\\n• Search Engine Optimization (get found online)\\n• Social Media Strategy (engage your audience)\\n• Content Marketing (build authority)\\n• Email Marketing (nurture relationships)\\n• Analytics (measure and improve)\\n\\nThe best strategy depends on your industry and target market. What's your current biggest challenge with online growth?";
    }

    // Default response
    return "Thank you for your question! 🤔 I'd be happy to help you with that. As your AI assistant specializing in digital solutions, I can provide guidance on web development, digital marketing, SEO, mobile apps, and business growth strategies.\\n\\nCould you provide a bit more detail about what you're looking for? Or would you prefer to speak with one of our human experts? I can arrange a free consultation call where we can discuss your specific needs in detail.";
}

function clearChat() {
    if (confirm('Are you sure you want to clear the chat history?')) {
        chatHistory = [];
        const messagesContainer = document.getElementById('messagesContainer');
        if (messagesContainer) {
            messagesContainer.innerHTML = `
                <div class="welcome-container" id="welcomeContainer">
                    <div class="welcome-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="welcome-title">Welcome to AI Sensei!</h3>
                    <p class="welcome-subtitle">I'm here to help with all your digital business questions. What would you like to know?</p>
                    
                    <div class="welcome-suggestions">
                        <div class="suggestion-card" onclick="sendQuickMessage('How can I start an online business?')">
                            <i class="fas fa-rocket"></i>
                            <div class="suggestion-title">Start Online Business</div>
                            <div class="suggestion-text">Get tips for launching your digital presence</div>
                        </div>
                        <div class="suggestion-card" onclick="sendQuickMessage('What is the cost of website development?')">
                            <i class="fas fa-dollar-sign"></i>
                            <div class="suggestion-title">Website Pricing</div>
                            <div class="suggestion-text">Learn about development costs</div>
                        </div>
                        <div class="suggestion-card" onclick="sendQuickMessage('How do I improve my website SEO?')">
                            <i class="fas fa-search"></i>
                            <div class="suggestion-title">SEO Tips</div>
                            <div class="suggestion-text">Boost your search rankings</div>
                        </div>
                        <div class="suggestion-card" onclick="sendQuickMessage('What social media strategy works best?')">
                            <i class="fas fa-share-alt"></i>
                            <div class="suggestion-title">Social Media</div>
                            <div class="suggestion-text">Effective marketing strategies</div>
                        </div>
                    </div>
                </div>

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
            `;
        }
        localStorage.removeItem('aiSenseiChatHistoryMinimal');
    }
}

function toggleVoiceInput() {
    const voiceBtn = document.getElementById('voiceBtn');
    if (!voiceBtn) return;

    if (!isVoiceRecording) {
        // Start recording
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();

            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            recognition.onstart = function () {
                isVoiceRecording = true;
                voiceBtn.classList.add('recording');
                voiceBtn.innerHTML = '<i class="fas fa-stop"></i>';
            };

            recognition.onresult = function (event) {
                const transcript = event.results[0][0].transcript;
                const messageInput = document.getElementById('messageInput');
                if (messageInput) {
                    messageInput.value = transcript;
                    adjustTextareaHeight();
                }
            };

            recognition.onend = function () {
                isVoiceRecording = false;
                voiceBtn.classList.remove('recording');
                voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            };

            recognition.onerror = function (event) {
                console.error('Speech recognition error:', event.error);
                isVoiceRecording = false;
                voiceBtn.classList.remove('recording');
                voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            };

            recognition.start();
        } else {
            alert('Speech recognition is not supported in your browser.');
        }
    } else {
        isVoiceRecording = false;
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('chatSidebar');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
}

function saveChatHistory() {
    localStorage.setItem('aiSenseiChatHistoryMinimal', JSON.stringify(chatHistory));
}

function loadChatHistory() {
    const saved = localStorage.getItem('aiSenseiChatHistoryMinimal');
    if (saved) {
        chatHistory = JSON.parse(saved);
        const messagesContainer = document.getElementById('messagesContainer');
        const welcomeContainer = document.getElementById('welcomeContainer');

        if (chatHistory.length > 0 && messagesContainer && welcomeContainer) {
            welcomeContainer.style.display = 'none';

            chatHistory.forEach(msg => {
                const messageElement = document.createElement('div');
                messageElement.className = `message ${msg.sender}`;

                const messageTime = new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                messageElement.innerHTML = `
                    <div class="message-avatar ${msg.sender}">
                        <i class="fas fa-${msg.sender === 'ai' ? 'robot' : 'user'}"></i>
                    </div>
                    <div class="message-content ${msg.sender}">
                        ${msg.content.replace(/\n/g, '<br>')}
                        <div class="message-time">${messageTime}</div>
                    </div>
                `;

                messagesContainer.appendChild(messageElement);
            });

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
}

// Close sidebar when clicking outside (mobile)
document.addEventListener('click', function (e) {
    const sidebar = document.getElementById('chatSidebar');
    const toggleBtn = e.target.closest('[onclick="toggleSidebar()"]');

    if (sidebar && !sidebar.contains(e.target) && !toggleBtn && window.innerWidth <= 992) {
        sidebar.classList.remove('show');
    }
});

// Preloader Animation
document.addEventListener('DOMContentLoaded', function () {
    // Animate progress bar
    anime({
        targets: '.preloader-progress-bar',
        width: '100%',
        duration: 3000,
        easing: 'easeInOutQuad'
    });

    // Animate logo
    anime({
        targets: '.preloader-logo',
        scale: [0.8, 1],
        opacity: [0, 1],
        duration: 1000,
        easing: 'easeOutElastic(1, .8)',
        delay: 500
    });

    // Animate dots
    anime({
        targets: '.preloader-dot',
        scale: [0, 1],
        opacity: [0, 1],
        duration: 600,
        delay: anime.stagger(100, { start: 800 }),
        easing: 'easeOutElastic(1, .8)'
    });

    // Animate text
    anime({
        targets: '.preloader-text',
        opacity: [0, 1],
        translateY: [20, 0],
        duration: 800,
        delay: 1200,
        easing: 'easeOutQuad'
    });

    // Hide preloader and show content
    setTimeout(() => {
        anime({
            targets: '#preloader',
            opacity: 0,
            duration: 800,
            easing: 'easeInOutQuad',
            complete: function () {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }

                // Animate main content
                const mainContent = document.querySelector('body > *:not(#preloader):not(.notification-topbar)');
                if (mainContent) {
                    anime({
                        targets: mainContent,
                        opacity: [0, 1],
                        translateY: [30, 0],
                        duration: 1000,
                        easing: 'easeOutQuad'
                    });
                }
            }
        });
    }, 4500); // Total preloader duration: 4.5 seconds
});

// Notification bar timing after preloader
function showNotificationAfterPreloader() {
    // Check if notification was already closed
    const notificationClosed = localStorage.getItem('notificationClosed');

    if (!notificationClosed) {
        setTimeout(() => {
            const notificationTopbar = document.querySelector('.notification-topbar');
            if (notificationTopbar) {
                notificationTopbar.classList.add('show');
                document.body.classList.add('notification-visible');
            }

            // Handle notification close
            const closeBtn = document.querySelector('.notification-close');
            if (closeBtn && !closeBtn.hasAttribute('data-listener-added')) {
                closeBtn.setAttribute('data-listener-added', 'true');
                closeBtn.addEventListener('click', function () {
                    const notificationTopbar = document.querySelector('.notification-topbar');
                    if (notificationTopbar) {
                        notificationTopbar.classList.remove('show');
                        document.body.classList.remove('notification-visible');
                        localStorage.setItem('notificationClosed', 'true');
                    }
                });
            }
        }, 300); // Show notification 300ms after preloader finishes
    }
}

// Show notification after preloader completion
setTimeout(showNotificationAfterPreloader, 4500);   
});