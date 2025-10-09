<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MegaMenu extends Component
{
    public $serviceContent;
    
    public function __construct()
    {
        $this->serviceContent = [
            'web' => [
                'Design & UX' => [
                    ['name' => 'Responsive Design', 'url' => 'responsive-design'],
                    ['name' => 'UI/UX Design', 'url' => 'ui-design'],
                    ['name' => 'Frontend Development', 'url' => 'frontend'],
                    ['name' => 'User Testing', 'url' => 'user-testing']
                ],
                'Development' => [
                    ['name' => 'HTML5/CSS3', 'url' => 'html-css'],
                    ['name' => 'JavaScript/React', 'url' => 'javascript'],
                    ['name' => 'Backend APIs', 'url' => 'backend'],
                    ['name' => 'Database Design', 'url' => 'database']
                ],
                'Tools & Frameworks' => [
                    ['name' => 'WordPress', 'url' => 'wordpress'],
                    ['name' => 'Laravel', 'url' => 'laravel'],
                    ['name' => 'Vue.js', 'url' => 'vue'],
                    ['name' => 'Node.js', 'url' => 'nodejs']
                ]
            ],
            'mobile' => [
                'iOS Development' => [
                    ['name' => 'Swift Programming', 'url' => 'swift'],
                    ['name' => 'SwiftUI', 'url' => 'swiftui'],
                    ['name' => 'App Store Submission', 'url' => 'app-store'],
                    ['name' => 'Core Data', 'url' => 'core-data']
                ],
                'Android Development' => [
                    ['name' => 'Kotlin Programming', 'url' => 'kotlin'],
                    ['name' => 'Android Studio', 'url' => 'android-studio'],
                    ['name' => 'Google Play Store', 'url' => 'play-store'],
                    ['name' => 'Material Design', 'url' => 'material-design']
                ],
                'Cross-Platform' => [
                    ['name' => 'React Native', 'url' => 'react-native'],
                    ['name' => 'Flutter', 'url' => 'flutter'],
                    ['name' => 'Ionic', 'url' => 'ionic'],
                    ['name' => 'Xamarin', 'url' => 'xamarin']
                ]
            ],
            'ecommerce' => [
                'Platform Development' => [
                    ['name' => 'WooCommerce', 'url' => 'woocommerce'],
                    ['name' => 'Shopify Plus', 'url' => 'shopify'],
                    ['name' => 'Magento', 'url' => 'magento'],
                    ['name' => 'Custom Solutions', 'url' => 'custom-ecommerce']
                ],
                'Payment Integration' => [
                    ['name' => 'Stripe Integration', 'url' => 'stripe'],
                    ['name' => 'PayPal Gateway', 'url' => 'paypal'],
                    ['name' => 'Mobile Money', 'url' => 'mobile-money'],
                    ['name' => 'Bank Transfers', 'url' => 'bank-transfer']
                ],
                'Store Management' => [
                    ['name' => 'Inventory System', 'url' => 'inventory'],
                    ['name' => 'Order Management', 'url' => 'orders'],
                    ['name' => 'Analytics Dashboard', 'url' => 'analytics'],
                    ['name' => 'Customer Support', 'url' => 'support']
                ]
            ],
            'api' => [
                'API Development' => [
                    ['name' => 'REST APIs', 'url' => 'rest-api'],
                    ['name' => 'GraphQL', 'url' => 'graphql'],
                    ['name' => 'Webhook Integration', 'url' => 'webhooks'],
                    ['name' => 'API Documentation', 'url' => 'api-docs']
                ],
                'Third-party Integration' => [
                    ['name' => 'Social Media APIs', 'url' => 'social-apis'],
                    ['name' => 'Payment Gateways', 'url' => 'payment-apis'],
                    ['name' => 'CRM Integration', 'url' => 'crm-apis'],
                    ['name' => 'Email Services', 'url' => 'email-apis']
                ],
                'Data & Security' => [
                    ['name' => 'Authentication', 'url' => 'auth'],
                    ['name' => 'Rate Limiting', 'url' => 'rate-limit'],
                    ['name' => 'Data Validation', 'url' => 'validation'],
                    ['name' => 'API Testing', 'url' => 'api-testing']
                ]
            ]
        ];
    }

    public function render()
    {
        return view('components.mega-menu');
    }
}