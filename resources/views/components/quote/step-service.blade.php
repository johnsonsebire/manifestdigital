<div class="quote-step active" id="step1">
    <div class="step-header">
        <h2>What service do you need?</h2>
        <p>Select the primary service you're looking for. You can add additional services in the next step.</p>
    </div>

    <!-- Hidden input to store selected service -->
    <input type="hidden" name="service" id="serviceInput" value="">

    <div class="service-grid" id="serviceGrid">
        <div class="service-card" data-service="website">
            <div class="check-icon"><i class="fas fa-check"></i></div>
            <div class="service-icon"><i class="fas fa-globe"></i></div>
            <h3>Website Development</h3>
            <p>Custom websites, redesigns, and web applications built with modern technologies.</p>
            <div class="service-price">From GH₵3,000</div>
        </div>

        <div class="service-card" data-service="ecommerce">
            <div class="check-icon"><i class="fas fa-check"></i></div>
            <div class="service-icon"><i class="fas fa-shopping-cart"></i></div>
            <h3>E-commerce Store</h3>
            <p>Complete online stores with payment integration, inventory management, and more.</p>
            <div class="service-price">From GH₵5,000</div>
        </div>

        <div class="service-card" data-service="mobile-app">
            <div class="check-icon"><i class="fas fa-check"></i></div>
            <div class="service-icon"><i class="fas fa-mobile-alt"></i></div>
            <h3>Mobile App</h3>
            <p>Native and cross-platform mobile applications for iOS and Android.</p>
            <div class="service-price">From GH₵8,000</div>
        </div>

        <div class="service-card" data-service="branding">
            <div class="check-icon"><i class="fas fa-check"></i></div>
            <div class="service-icon"><i class="fas fa-palette"></i></div>
            <h3>Brand Identity</h3>
            <p>Logo design, brand guidelines, and complete visual identity packages.</p>
            <div class="service-price">From GH₵1,500</div>
        </div>

        <div class="service-card" data-service="digital-marketing">
            <div class="check-icon"><i class="fas fa-check"></i></div>
            <div class="service-icon"><i class="fas fa-chart-line"></i></div>
            <h3>Digital Marketing</h3>
            <p>SEO, social media marketing, PPC campaigns, and content marketing strategies.</p>
            <div class="service-price">From GH₵2,000/month</div>
        </div>

        <div class="service-card" data-service="consulting">
            <div class="check-icon"><i class="fas fa-check"></i></div>
            <div class="service-icon"><i class="fas fa-lightbulb"></i></div>
            <h3>IT Consulting</h3>
            <p>Technology strategy, system integration, and digital transformation consulting.</p>
            <div class="service-price">From GH₵500/hour</div>
        </div>
    </div>

    <div class="btn-navigation">
        <div></div>
        <button type="button" class="btn-quote" onclick="nextStep()" id="step1Next" disabled>
            Next Step <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>