@props(['activeService' => 'web'])

<div class="nav-dropdown mega-menu-wrapper" 
    x-data="{ 
        activeService: '{{ $activeService }}',
        serviceContent: @js($serviceContent),
        getActiveContent() {
            return this.serviceContent[this.activeService] || {};
        }
    }">
    <a href="#" class="dropdown-toggle">Services <i class="fas fa-chevron-down"></i></a>
    <div class="mega-menu">
        <div class="mega-menu-content">
            <div class="mega-menu-section">
                <h3>Development Services</h3>
                <div class="service-grid">
                    <a href="#web-development" 
                       class="service-item" 
                       :class="{ 'active': activeService === 'web' }"
                       @click.prevent="activeService = 'web'"
                       data-service="web">
                        <i class="fas fa-code" style="padding-left:15px;"></i>
                        <div>
                            <h4>Web Development</h4>
                            <p>Custom websites and web applications built with modern frameworks</p>
                        </div>
                    </a>
                    <a href="#mobile-development" 
                       class="service-item" 
                       :class="{ 'active': activeService === 'mobile' }"
                       @click.prevent="activeService = 'mobile'"
                       data-service="mobile">
                        <i class="fas fa-mobile-alt" style="padding-left:15px;"></i>
                        <div>
                            <h4>Mobile Apps</h4>
                            <p>Native and cross-platform mobile applications for iOS and Android</p>
                        </div>
                    </a>
                    <a href="#ecommerce" 
                       class="service-item" 
                       :class="{ 'active': activeService === 'ecommerce' }"
                       @click.prevent="activeService = 'ecommerce'"
                       data-service="ecommerce">
                        <i class="fas fa-shopping-cart" style="padding-left:15px;"></i>
                        <div>
                            <h4>E-commerce</h4>
                            <p>Online stores and marketplaces that drive sales and growth</p>
                        </div>
                    </a>
                    <a href="#api-integration" 
                       class="service-item" 
                       :class="{ 'active': activeService === 'api' }"
                       @click.prevent="activeService = 'api'"
                       data-service="api">
                        <i class="fas fa-plug" style="padding-left:15px;"></i>
                        <div>
                            <h4>API Integration</h4>
                            <p>Seamless third-party integrations and custom API development</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="mega-menu-section">
                <div class="service-categories" x-html="(() => {
                    const content = getActiveContent();
                    let html = '';
                    
                    for (const [category, items] of Object.entries(content)) {
                        html += `
                            <div class='category-column'>
                                <h4>${category}</h4>
                                <ul>
                                    ${items.map(item => `
                                        <li>
                                            <a href='${window.location.origin}/${item.url}'>${item.name}</a>
                                        </li>
                                    `).join('')}
                                </ul>
                            </div>
                        `;
                    }
                    
                    return html;
                })()">
                </div>
            </div>
            
            <div class="mega-menu-section featured-section">
                <div class="featured-service">
                    <div class="featured-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="featured-content">
                        <h4>AI Sensei</h4>
                        <p>Our AI-powered development assistant that accelerates project delivery and enhances code quality</p>
                        <a href="{{ url('ai-sensei') }}" class="cta-link">Discover AI Sensei →</a>
                    </div>
                </div>
                
                <div class="featured-service">
                    <div class="featured-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="featured-content">
                        <h4>Quick Start Package</h4>
                        <p>Get your business online in 7 days with our comprehensive starter package</p>
                        <a href="{{ url('quote-request') }}" class="cta-link">Start Today →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize AlpineJS component for mega menu
    document.addEventListener('alpine:init', () => {
        Alpine.data('megaMenu', () => ({
            activeService: '{{ $activeService }}'
        }))
    })
</script>
@endpush
