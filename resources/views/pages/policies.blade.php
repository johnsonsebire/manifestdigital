<x-layouts.frontend 
    title="Policies | Legal Information - Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="dark">

    @push('styles')
    <style>
        /* Policies Page Specific Styles */

        .policies-hero {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 100px 0 60px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .policies-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/images/decorative/hero_left_mem_dots_f_circle3.svg') no-repeat left center;
            opacity: 0.1;
            pointer-events: none;
        }

        .policies-hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .policies-hero h1 {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .policies-hero p {
            font-size: 18px;
            opacity: 0.9;
        }

        .policies-hero .highlight {
            color: #ff2200;
        }

        /* Policies Navigation */
        .policies-nav {
            background: white;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .policies-nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 20px;
            overflow-x: auto;
        }

        .policy-nav-btn {
            padding: 12px 24px;
            background: transparent;
            border: 2px solid #ddd;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #333;
            white-space: nowrap;
            text-decoration: none;
            display: inline-block;
        }

        .policy-nav-btn:hover,
        .policy-nav-btn.active {
            background: #ff2200;
            border-color: #ff2200;
            color: white;
        }

        /* Policies Content */
        .policies-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 60px 20px 80px;
        }

        .policy-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .policy-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .policy-header {
            margin-bottom: 40px;
        }

        .policy-header h2 {
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }

        .last-updated {
            color: #666;
            font-size: 15px;
            font-style: italic;
        }

        .policy-content h3 {
            font-size: 24px;
            font-weight: 800;
            margin-top: 40px;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .policy-content h4 {
            font-size: 20px;
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 15px;
            color: #333;
        }

        .policy-content p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
        }

        .policy-content ul {
            margin: 20px 0;
            padding-left: 30px;
        }

        .policy-content ul li {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 12px;
        }

        .policy-content ol {
            margin: 20px 0;
            padding-left: 30px;
        }

        .policy-content ol li {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 12px;
        }

        .policy-content strong {
            color: #1a1a1a;
            font-weight: 700;
        }

        .highlight-box {
            background: #f8f9fa;
            border-left: 4px solid #ff2200;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }

        .highlight-box p:last-child {
            margin-bottom: 0;
        }

        .contact-info {
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
        }

        .contact-info h4 {
            color: white;
            margin-bottom: 15px;
        }

        .contact-info p {
            color: white;
            margin-bottom: 10px;
        }

        .contact-info a {
            color: white;
            text-decoration: underline;
        }

        .contact-info a:hover {
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .policies-hero h1 {
                font-size: 36px;
            }

            .policies-hero p {
                font-size: 16px;
            }

            .policies-nav-container {
                justify-content: flex-start;
            }

            .policy-header h2 {
                font-size: 28px;
            }

            .policy-content h3 {
                font-size: 22px;
            }
        }
    </style>
    @endpush

    <!-- Hero Section -->
    <section class="policies-hero">
        <div class="policies-hero-content">
            <h1>Our <span class="highlight">Policies</span></h1>
            <p>Transparency and trust are at the core of everything we do</p>
        </div>
    </section>

    <!-- Policies Navigation -->
    <nav class="policies-nav">
        <div class="policies-nav-container">
            <button class="policy-nav-btn active" data-policy="privacy">Privacy Policy</button>
            <button class="policy-nav-btn" data-policy="terms">Terms of Service</button>
            <button class="policy-nav-btn" data-policy="cookie">Cookie Policy</button>
            <button class="policy-nav-btn" data-policy="refund">Refund Policy</button>
        </div>
    </nav>

    <!-- Policies Content -->
    <div class="policies-content">
        <!-- Privacy Policy -->
        <section id="privacy-policy" class="policy-section active">
            <div class="policy-header">
                <h2>Privacy Policy</h2>
                <p class="last-updated">Last Updated: October 12, 2025</p>
            </div>

            <div class="policy-content">
                <p>At Manifest Digital, we are committed to protecting your privacy and ensuring the security of your
                    personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your
                    information when you visit our website or use our services.</p>

                <h3>1. Information We Collect</h3>

                <h4>Personal Information</h4>
                <p>We may collect personal information that you voluntarily provide to us when you:</p>
                <ul>
                    <li>Register for our services</li>
                    <li>Subscribe to our newsletter</li>
                    <li>Fill out contact forms</li>
                    <li>Book a consultation or call</li>
                    <li>Make a purchase or payment</li>
                </ul>

                <p>This information may include:</p>
                <ul>
                    <li>Name and contact information (email, phone number, address)</li>
                    <li>Business information (company name, job title)</li>
                    <li>Payment information (processed securely through third-party providers)</li>
                    <li>Project details and requirements</li>
                </ul>

                <h4>Automatically Collected Information</h4>
                <p>When you visit our website, we automatically collect certain information about your device and
                    browsing behavior, including:</p>
                <ul>
                    <li>IP address and location data</li>
                    <li>Browser type and version</li>
                    <li>Pages visited and time spent</li>
                    <li>Referring website addresses</li>
                    <li>Device information (operating system, screen resolution)</li>
                </ul>

                <h3>2. How We Use Your Information</h3>
                <p>We use the information we collect for various purposes, including:</p>
                <ul>
                    <li><strong>Service Delivery:</strong> To provide, maintain, and improve our digital services</li>
                    <li><strong>Communication:</strong> To respond to your inquiries, send updates, and provide customer
                        support</li>
                    <li><strong>Marketing:</strong> To send promotional materials, newsletters, and service
                        announcements (with your consent)</li>
                    <li><strong>Analytics:</strong> To understand how our website is used and optimize user experience
                    </li>
                    <li><strong>Legal Compliance:</strong> To comply with legal obligations and protect our rights</li>
                    <li><strong>Security:</strong> To detect, prevent, and address technical issues and fraudulent
                        activity</li>
                </ul>

                <h3>3. Information Sharing and Disclosure</h3>
                <p>We do not sell, trade, or rent your personal information to third parties. We may share your
                    information only in the following circumstances:</p>
                <ul>
                    <li><strong>Service Providers:</strong> With trusted third-party vendors who assist in operating our
                        business (e.g., hosting, payment processing, analytics)</li>
                    <li><strong>Legal Requirements:</strong> When required by law, court order, or government regulation
                    </li>
                    <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets
                    </li>
                    <li><strong>With Your Consent:</strong> When you explicitly authorize us to share your information
                    </li>
                </ul>

                <h3>4. Data Security</h3>
                <p>We implement industry-standard security measures to protect your personal information, including:</p>
                <ul>
                    <li>SSL/TLS encryption for data transmission</li>
                    <li>Secure servers and firewalls</li>
                    <li>Regular security audits and updates</li>
                    <li>Access controls and authentication</li>
                    <li>Employee training on data protection</li>
                </ul>

                <div class="highlight-box">
                    <p><strong>Important:</strong> While we strive to protect your personal information, no method of
                        transmission over the internet or electronic storage is 100% secure. We cannot guarantee
                        absolute security but are committed to using reasonable measures to safeguard your data.</p>
                </div>

                <h3>5. Your Rights and Choices</h3>
                <p>You have the following rights regarding your personal information:</p>
                <ul>
                    <li><strong>Access:</strong> Request access to the personal information we hold about you</li>
                    <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information</li>
                    <li><strong>Deletion:</strong> Request deletion of your personal information (subject to legal
                        obligations)</li>
                    <li><strong>Opt-Out:</strong> Unsubscribe from marketing communications at any time</li>
                    <li><strong>Data Portability:</strong> Request a copy of your data in a portable format</li>
                    <li><strong>Objection:</strong> Object to processing of your personal information for certain
                        purposes</li>
                </ul>

                <h3>6. Cookies and Tracking Technologies</h3>
                <p>We use cookies and similar tracking technologies to enhance your experience on our website. For more
                    information, please see our Cookie Policy section.</p>

                <h3>7. Children's Privacy</h3>
                <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect
                    personal information from children. If we become aware that we have collected information from a
                    child, we will take steps to delete such information.</p>

                <h3>8. International Data Transfers</h3>
                <p>Your information may be transferred to and processed in countries other than Ghana. We ensure that
                    adequate safeguards are in place to protect your data in accordance with this Privacy Policy and
                    applicable laws.</p>

                <h3>9. Changes to This Policy</h3>
                <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal
                    requirements. We will notify you of any material changes by posting the new policy on our website
                    and updating the "Last Updated" date.</p>

                <div class="contact-info">
                    <h4>Contact Us</h4>
                    <p>If you have questions about this Privacy Policy or wish to exercise your rights, please contact
                        us:</p>
                    <p><strong>Email:</strong> <a href="mailto:privacy@manifestghana.com">privacy@manifestghana.com</a>
                    </p>
                    <p><strong>Phone:</strong> +233 54 953 9417</p>
                    <p><strong>Address:</strong> Accra, Ghana</p>
                </div>
            </div>
        </section>

        <!-- Terms of Service -->
        <section id="terms-service" class="policy-section">
            <div class="policy-header">
                <h2>Terms of Service</h2>
                <p class="last-updated">Last Updated: October 12, 2025</p>
            </div>

            <div class="policy-content">
                <p>Welcome to Manifest Digital. These Terms of Service ("Terms") govern your use of our website and
                    services. By accessing or using our services, you agree to be bound by these Terms.</p>

                <h3>1. Acceptance of Terms</h3>
                <p>By accessing and using Manifest Digital's services, you accept and agree to be bound by these Terms
                    and our Privacy Policy. If you do not agree to these Terms, please do not use our services.</p>

                <h3>2. Services Description</h3>
                <p>Manifest Digital provides digital solutions including but not limited to:</p>
                <ul>
                    <li>Web development and design</li>
                    <li>Mobile application development</li>
                    <li>AI and machine learning solutions</li>
                    <li>Cloud computing services</li>
                    <li>Cyber security solutions</li>
                    <li>Digital consulting and training</li>
                </ul>

                <h3>3. User Responsibilities</h3>
                <p>When using our services, you agree to:</p>
                <ul>
                    <li>Provide accurate and complete information</li>
                    <li>Maintain the confidentiality of your account credentials</li>
                    <li>Use our services only for lawful purposes</li>
                    <li>Not interfere with or disrupt our services or servers</li>
                    <li>Not attempt to gain unauthorized access to our systems</li>
                    <li>Comply with all applicable laws and regulations</li>
                </ul>

                <h3>4. Intellectual Property</h3>
                <p>All content, materials, and intellectual property on our website and in our services are owned by
                    Manifest Digital or our licensors. This includes:</p>
                <ul>
                    <li>Website design and layout</li>
                    <li>Software and source code</li>
                    <li>Text, graphics, logos, and images</li>
                    <li>Trademarks and service marks</li>
                </ul>
                <p>You may not reproduce, distribute, modify, or create derivative works without our express written
                    permission.</p>

                <h3>5. Project Agreements</h3>
                <p>Specific project terms will be outlined in separate agreements or statements of work, which may
                    include:</p>
                <ul>
                    <li>Project scope and deliverables</li>
                    <li>Timeline and milestones</li>
                    <li>Payment terms and pricing</li>
                    <li>Ownership of work product</li>
                    <li>Confidentiality obligations</li>
                </ul>

                <h3>6. Payment Terms</h3>
                <p>Unless otherwise specified in a project agreement:</p>
                <ul>
                    <li>Payment is due according to agreed-upon milestones or invoices</li>
                    <li>Late payments may incur interest charges</li>
                    <li>We reserve the right to suspend services for non-payment</li>
                    <li>All prices are in Ghana Cedis (GH₵) unless stated otherwise</li>
                </ul>

                <h3>7. Warranties and Disclaimers</h3>
                <p>We strive to provide high-quality services but:</p>
                <ul>
                    <li>Services are provided "as is" without warranties of any kind</li>
                    <li>We do not guarantee uninterrupted or error-free service</li>
                    <li>We are not responsible for third-party services or content</li>
                    <li>Results may vary based on factors outside our control</li>
                </ul>

                <div class="highlight-box">
                    <p><strong>Service Level Agreement:</strong> Specific performance guarantees and support terms are
                        defined in individual project agreements and SLAs.</p>
                </div>

                <h3>8. Limitation of Liability</h3>
                <p>To the maximum extent permitted by law, Manifest Digital shall not be liable for:</p>
                <ul>
                    <li>Indirect, incidental, or consequential damages</li>
                    <li>Loss of profits, data, or business opportunities</li>
                    <li>Damages exceeding the amount paid for services in the past 12 months</li>
                    <li>Events beyond our reasonable control (force majeure)</li>
                </ul>

                <h3>9. Confidentiality</h3>
                <p>We respect the confidentiality of your business information and agree to:</p>
                <ul>
                    <li>Keep your proprietary information confidential</li>
                    <li>Use information only for providing services</li>
                    <li>Implement reasonable security measures</li>
                    <li>Not disclose information to third parties without consent</li>
                </ul>

                <h3>10. Termination</h3>
                <p>Either party may terminate services under certain conditions:</p>
                <ul>
                    <li>For breach of these Terms (with notice and opportunity to cure)</li>
                    <li>For convenience with appropriate notice period</li>
                    <li>Immediately for material breach or illegal activity</li>
                </ul>

                <h3>11. Governing Law</h3>
                <p>These Terms are governed by the laws of Ghana. Any disputes shall be resolved in the courts of Ghana.
                </p>

                <h3>12. Changes to Terms</h3>
                <p>We reserve the right to modify these Terms at any time. Continued use of our services after changes
                    constitutes acceptance of the new Terms.</p>

                <div class="contact-info">
                    <h4>Questions About Terms?</h4>
                    <p>If you have questions about these Terms of Service, please contact us:</p>
                    <p><strong>Email:</strong> <a href="mailto:legal@manifestghana.com">legal@manifestghana.com</a></p>
                    <p><strong>Phone:</strong> +233 54 953 9417</p>
                </div>
            </div>
        </section>

        <!-- Cookie Policy -->
        <section id="cookie-policy" class="policy-section">
            <div class="policy-header">
                <h2>Cookie Policy</h2>
                <p class="last-updated">Last Updated: October 12, 2025</p>
            </div>

            <div class="policy-content">
                <p>This Cookie Policy explains how Manifest Digital uses cookies and similar tracking technologies on
                    our website.</p>

                <h3>1. What Are Cookies?</h3>
                <p>Cookies are small text files stored on your device when you visit a website. They help websites
                    remember your preferences and provide a better user experience.</p>

                <h3>2. Types of Cookies We Use</h3>

                <h4>Essential Cookies</h4>
                <p>These cookies are necessary for the website to function properly:</p>
                <ul>
                    <li>Authentication and security</li>
                    <li>Session management</li>
                    <li>Load balancing</li>
                </ul>

                <h4>Performance Cookies</h4>
                <p>These cookies help us understand how visitors interact with our website:</p>
                <ul>
                    <li>Page visit analytics</li>
                    <li>User behavior tracking</li>
                    <li>Error reporting</li>
                </ul>

                <h4>Functional Cookies</h4>
                <p>These cookies enable enhanced functionality:</p>
                <ul>
                    <li>Language preferences</li>
                    <li>Remember your choices</li>
                    <li>Personalized content</li>
                </ul>

                <h4>Marketing Cookies</h4>
                <p>These cookies track your online activity to deliver relevant advertising:</p>
                <ul>
                    <li>Ad targeting and retargeting</li>
                    <li>Campaign performance measurement</li>
                    <li>Social media integration</li>
                </ul>

                <h3>3. Third-Party Cookies</h3>
                <p>We use services from trusted third parties that may set their own cookies:</p>
                <ul>
                    <li><strong>Google Analytics:</strong> For website analytics and insights</li>
                    <li><strong>Facebook Pixel:</strong> For advertising and remarketing</li>
                    <li><strong>LinkedIn Insights:</strong> For B2B marketing analytics</li>
                    <li><strong>Hotjar:</strong> For user behavior analysis</li>
                </ul>

                <h3>4. Managing Cookies</h3>
                <p>You can control and manage cookies in several ways:</p>

                <h4>Browser Settings</h4>
                <p>Most browsers allow you to:</p>
                <ul>
                    <li>View and delete cookies</li>
                    <li>Block all cookies</li>
                    <li>Block third-party cookies</li>
                    <li>Clear cookies when closing the browser</li>
                </ul>

                <h4>Opt-Out Tools</h4>
                <p>You can opt out of specific tracking:</p>
                <ul>
                    <li>Google Analytics Opt-out: <a href="https://tools.google.com/dlpage/gaoptout"
                            target="_blank" rel="noopener">tools.google.com/dlpage/gaoptout</a></li>
                    <li>Network Advertising Initiative: <a href="https://optout.networkadvertising.org"
                            target="_blank" rel="noopener">optout.networkadvertising.org</a></li>
                </ul>

                <div class="highlight-box">
                    <p><strong>Note:</strong> Blocking or deleting cookies may affect your experience on our website and
                        limit certain features.</p>
                </div>

                <h3>5. Cookie Duration</h3>
                <ul>
                    <li><strong>Session Cookies:</strong> Deleted when you close your browser</li>
                    <li><strong>Persistent Cookies:</strong> Remain on your device for a set period or until manually
                        deleted</li>
                </ul>

                <h3>6. Updates to This Policy</h3>
                <p>We may update this Cookie Policy to reflect changes in technology or regulations. Check this page
                    periodically for updates.</p>

                <div class="contact-info">
                    <h4>Cookie Questions?</h4>
                    <p>For questions about our use of cookies, contact us:</p>
                    <p><strong>Email:</strong> <a href="mailto:privacy@manifestghana.com">privacy@manifestghana.com</a>
                    </p>
                </div>
            </div>
        </section>

        <!-- Refund Policy -->
        <section id="refund-policy" class="policy-section">
            <div class="policy-header">
                <h2>Refund Policy</h2>
                <p class="last-updated">Last Updated: October 12, 2025</p>
            </div>

            <div class="policy-content">
                <p>At Manifest Digital, we are committed to delivering high-quality digital solutions. This Refund
                    Policy outlines the terms and conditions for refunds and cancellations.</p>

                <h3>1. General Policy</h3>
                <p>Due to the custom nature of our digital services and the time invested in each project, refunds are
                    evaluated on a case-by-case basis. We strive for complete client satisfaction and will work with you
                    to resolve any issues.</p>

                <h3>2. Consultation and Discovery Calls</h3>
                <ul>
                    <li><strong>Free Consultations:</strong> Our initial discovery calls and consultations are provided
                        free of charge with no commitment required</li>
                    <li><strong>Paid Consultations:</strong> If applicable, paid consultations are non-refundable once
                        completed</li>
                </ul>

                <h3>3. Project-Based Services</h3>

                <h4>Deposit Payments</h4>
                <ul>
                    <li>Initial deposits are typically non-refundable as work begins immediately upon project initiation
                    </li>
                    <li>Deposits cover initial planning, research, and resource allocation</li>
                </ul>

                <h4>Milestone Payments</h4>
                <ul>
                    <li>Payments for completed milestones are non-refundable</li>
                    <li>If you're unsatisfied with a milestone, we'll work to revise it according to the agreed scope
                    </li>
                    <li>Additional revisions beyond the agreed scope may incur extra charges</li>
                </ul>

                <h4>Project Cancellation</h4>
                <p>If you need to cancel a project:</p>
                <ul>
                    <li><strong>Before Work Begins:</strong> Full refund minus any consultation fees and administrative
                        costs (typically 10%)</li>
                    <li><strong>After Work Begins:</strong> You'll be charged for work completed plus a 25% cancellation
                        fee on remaining contract value</li>
                    <li><strong>After 50% Completion:</strong> No refunds; payment for remaining milestones is due</li>
                </ul>

                <h3>4. Subscription Services</h3>
                <p>For ongoing subscription-based services:</p>
                <ul>
                    <li><strong>Monthly Plans:</strong> Cancel anytime; no refund for current month but service
                        continues until period end</li>
                    <li><strong>Annual Plans:</strong> Cancel with 30 days notice; refund prorated for unused months
                        minus 15% processing fee</li>
                    <li><strong>Setup Fees:</strong> Non-refundable once service is configured</li>
                </ul>

                <h3>5. Training and Workshops</h3>
                <ul>
                    <li><strong>7+ Days Before:</strong> Full refund available</li>
                    <li><strong>3-7 Days Before:</strong> 50% refund</li>
                    <li><strong>Less Than 3 Days:</strong> No refund, but can transfer to another session</li>
                    <li><strong>No-Show:</strong> No refund</li>
                </ul>

                <h3>6. Digital Products and Licenses</h3>
                <ul>
                    <li>Software licenses and digital products are non-refundable once delivered</li>
                    <li>If a product is defective, we'll provide a replacement or fix at no charge</li>
                    <li>30-day money-back guarantee applies to specific products (clearly marked)</li>
                </ul>

                <h3>7. Conditions for Refund Eligibility</h3>
                <p>Refund requests must:</p>
                <ul>
                    <li>Be submitted in writing to <a
                            href="mailto:billing@manifestghana.com">billing@manifestghana.com</a></li>
                    <li>Include detailed reasons for the refund request</li>
                    <li>Be made within 30 days of the disputed charge</li>
                    <li>Provide supporting documentation if applicable</li>
                </ul>

                <div class="highlight-box">
                    <p><strong>Satisfaction Guarantee:</strong> While refunds are limited, we're committed to your
                        satisfaction. If you're unhappy with our work, we'll revise it according to the original scope
                        at no additional charge.</p>
                </div>

                <h3>8. Refund Processing</h3>
                <ul>
                    <li>Approved refunds are processed within 10-15 business days</li>
                    <li>Refunds are issued to the original payment method</li>
                    <li>Bank processing times may vary (3-7 additional business days)</li>
                    <li>Transaction fees are non-refundable</li>
                </ul>

                <h3>9. Non-Refundable Situations</h3>
                <p>Refunds will not be issued for:</p>
                <ul>
                    <li>Change of mind after project completion</li>
                    <li>Failure to use delivered services or products</li>
                    <li>Dissatisfaction with results that meet the agreed specifications</li>
                    <li>Issues caused by third-party services or client-provided materials</li>
                    <li>Delays caused by client's failure to provide required information or approvals</li>
                </ul>

                <h3>10. Dispute Resolution</h3>
                <p>If you have a billing dispute:</p>
                <ol>
                    <li>Contact our billing team at <a
                            href="mailto:billing@manifestghana.com">billing@manifestghana.com</a></li>
                    <li>We'll review your case within 5 business days</li>
                    <li>If unresolved, we'll arrange a mediation call</li>
                    <li>Final decisions are made by senior management</li>
                </ol>

                <h3>11. Force Majeure</h3>
                <p>If we're unable to deliver services due to circumstances beyond our control (natural disasters, war,
                    pandemic, etc.), you'll receive:</p>
                <ul>
                    <li>Full refund for services not yet started</li>
                    <li>Prorated refund for partially completed work</li>
                    <li>Option to postpone service delivery at no extra cost</li>
                </ul>

                <div class="contact-info">
                    <h4>Refund Questions?</h4>
                    <p>For questions about refunds or to request a refund, contact us:</p>
                    <p><strong>Email:</strong> <a href="mailto:billing@manifestghana.com">billing@manifestghana.com</a>
                    </p>
                    <p><strong>Phone:</strong> +233 54 953 9417</p>
                    <p><strong>Response Time:</strong> Within 2 business days</p>
                </div>
            </div>
        </section>
    </div>

    

    @push('scripts')
    <script>
        // Policy Navigation
        const policyNavBtns = document.querySelectorAll('.policy-nav-btn');
        const policySections = document.querySelectorAll('.policy-section');

        function showPolicy(policyName) {
            // Remove active class from all buttons and sections
            policyNavBtns.forEach(btn => btn.classList.remove('active'));
            policySections.forEach(section => section.classList.remove('active'));

            // Add active class to selected button and section
            const selectedBtn = document.querySelector(`[data-policy="${policyName}"]`);
            const selectedSection = document.getElementById(`${policyName}-${policyName === 'privacy' ? 'policy' : policyName === 'terms' ? 'service' : 'policy'}`);

            if (selectedBtn) selectedBtn.classList.add('active');
            if (selectedSection) selectedSection.classList.add('active');

            // Scroll to top of content
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        policyNavBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const policy = btn.dataset.policy;
                showPolicy(policy);
            });
        });

        // Check URL hash on load
        window.addEventListener('load', () => {
            const hash = window.location.hash.substring(1);
            if (hash) {
                const policyMap = {
                    'privacy': 'privacy',
                    'terms': 'terms',
                    'cookie': 'cookie',
                    'refund': 'refund'
                };
                if (policyMap[hash]) {
                    showPolicy(policyMap[hash]);
                }
            }
        });
    </script>
    @endpush

</x-layouts.frontend>