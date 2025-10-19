<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user as the creator
        $creator = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Administrator', 'Super Admin']);
        })->first();

        $creatorId = $creator ? $creator->id : null;

        $services = $this->getServicesData();

        foreach ($services as $serviceData) {
            // Get category
            $category = Category::where('slug', $serviceData['category_slug'])->first();
            
            if (!$category) {
                $this->command->warn("Category '{$serviceData['category_slug']}' not found for service '{$serviceData['title']}'");
                continue;
            }

            // Create or update service
            $service = Service::updateOrCreate(
                ['slug' => $serviceData['slug']],
                [
                    'uuid' => Str::uuid(),
                    'title' => $serviceData['title'],
                    'short_description' => $serviceData['short_description'],
                    'long_description' => $serviceData['long_description'],
                    'type' => $serviceData['type'],
                    'price' => $serviceData['price'],
                    'currency' => $serviceData['currency'],
                    'billing_interval' => $serviceData['billing_interval'],
                    'metadata' => $serviceData['metadata'],
                    'available' => $serviceData['available'],
                    'visible' => $serviceData['visible'],
                    'created_by' => $creatorId,
                ]
            );

            // Attach to category
            $service->categories()->syncWithoutDetaching([$category->id]);
        }

        $this->command->info('Services seeded successfully.');
    }

    /**
     * Get all services data
     */
    private function getServicesData(): array
    {
        return [
            // Website Development Services
            [
                'title' => 'Website Essentials',
                'slug' => 'website-essentials',
                'short_description' => 'Perfect for getting started with your online presence',
                'long_description' => 'Our Website Essentials package is designed for small businesses and startups who need a professional online presence without breaking the bank. This package includes responsive design, basic SEO setup, contact form integration, and social media links to help you connect with your customers.',
                'type' => 'subscription',
                'price' => 18.52,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'website-development',
                'metadata' => [
                    'features' => [
                        'Up to 5 pages',
                        'Responsive design',
                        'Basic SEO setup',
                        'Contact form integration',
                        'Social media links',
                        '2 rounds of revisions',
                        '30-day support'
                    ],
                    'delivery_time' => '1-2 weeks',
                    'included_revisions' => 2
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Website Professional',
                'slug' => 'website-professional',
                'short_description' => 'Most popular for growing teams and businesses',
                'long_description' => 'Our Website Professional package is perfect for growing businesses that need a comprehensive online solution. It includes custom UI/UX design, advanced SEO optimization, content management system, blog functionality, and e-commerce capabilities for up to 50 products.',
                'type' => 'subscription',
                'price' => 37.04,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'website-development',
                'metadata' => [
                    'features' => [
                        'Up to 15 pages',
                        'Custom UI/UX design',
                        'Advanced SEO optimization',
                        'CMS integration',
                        'Blog functionality',
                        'E-commerce ready (up to 50 products)',
                        'Analytics integration',
                        'Unlimited revisions',
                        '90-day support'
                    ],
                    'delivery_time' => '2-4 weeks',
                    'included_revisions' => 'unlimited',
                    'most_popular' => true
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Website Enterprise',
                'slug' => 'website-enterprise',
                'short_description' => 'For mission-critical projects and large organizations',
                'long_description' => 'Our Website Enterprise package is designed for large organizations with complex requirements. It includes unlimited pages, premium custom design, advanced functionality, multi-language support, custom integrations & APIs, and a dedicated project team.',
                'type' => 'subscription',
                'price' => 111.11,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'website-development',
                'metadata' => [
                    'features' => [
                        'Unlimited pages',
                        'Premium custom design',
                        'Advanced functionality',
                        'Multi-language support',
                        'Custom integrations & APIs',
                        'Advanced e-commerce (unlimited products)',
                        'Dedicated project team',
                        'Priority support & maintenance',
                        '1-year support included'
                    ],
                    'delivery_time' => '4-8 weeks',
                    'included_revisions' => 'unlimited',
                    'dedicated_support' => true
                ],
                'available' => true,
                'visible' => true,
            ],

            // UI/UX Design Services
            [
                'title' => 'Basic UI/UX Design',
                'slug' => 'basic-ui-ux-design',
                'short_description' => 'Essential design services for your digital product',
                'long_description' => 'Our Basic UI/UX Design package provides essential design services for startups and small businesses. It includes wireframe sketches, basic user flow mapping, mobile responsive design, and Figma source files to get your digital product off the ground.',
                'type' => 'one_time',
                'price' => 185.19,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'ui-ux-design',
                'metadata' => [
                    'features' => [
                        'Up to 3 screen designs',
                        'Wireframe sketches',
                        'Basic user flow',
                        'Mobile responsive design',
                        '2 revision rounds',
                        'Figma source files',
                        'Style guide basics'
                    ],
                    'delivery_time' => '1-2 weeks',
                    'included_revisions' => 2,
                    'deliverables' => [
                        'Figma files',
                        'Style guide',
                        'Design specifications'
                    ]
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Professional UI/UX Design',
                'slug' => 'professional-ui-ux-design',
                'short_description' => 'Complete design system for growing products',
                'long_description' => 'Our Professional UI/UX Design package offers a comprehensive design solution for growing businesses. It includes interactive prototypes, complete user journey mapping, responsive design for all devices, user research & personas, and a complete design system with developer handoff package.',
                'type' => 'one_time',
                'price' => 444.44,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'ui-ux-design',
                'metadata' => [
                    'features' => [
                        'Up to 10 screen designs',
                        'Interactive prototypes',
                        'Complete user journey mapping',
                        'Responsive design (mobile, tablet, desktop)',
                        'User research & personas',
                        'Unlimited revisions',
                        'Complete design system',
                        'Developer handoff package',
                        '60-day support'
                    ],
                    'delivery_time' => '2-4 weeks',
                    'included_revisions' => 'unlimited',
                    'most_popular' => true,
                    'deliverables' => [
                        'Interactive prototypes',
                        'Design system',
                        'User research report',
                        'Developer handoff'
                    ]
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Enterprise UI/UX Design',
                'slug' => 'enterprise-ui-ux-design',
                'short_description' => 'Full-scale UX solution for complex products',
                'long_description' => 'Our Enterprise UI/UX Design package is designed for large organizations with complex digital products. It includes unlimited screens & flows, advanced interactive prototypes, user testing & validation, multi-platform design system, accessibility compliance, and a dedicated design team.',
                'type' => 'one_time',
                'price' => 740.74,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'ui-ux-design',
                'metadata' => [
                    'features' => [
                        'Unlimited screens & flows',
                        'Advanced interactive prototypes',
                        'User testing & validation',
                        'Multi-platform design system',
                        'Accessibility compliance (WCAG)',
                        'UX strategy & consulting',
                        'Animation & micro-interactions',
                        'Dedicated design team',
                        '6-month support & updates'
                    ],
                    'delivery_time' => 'Custom timeline',
                    'included_revisions' => 'unlimited',
                    'dedicated_support' => true,
                    'deliverables' => [
                        'Complete design system',
                        'User testing reports',
                        'Accessibility audit',
                        'Animation specifications'
                    ]
                ],
                'available' => true,
                'visible' => true,
            ],

            // Web Hosting Services
            [
                'title' => 'Starter Web Hosting',
                'slug' => 'starter-web-hosting',
                'short_description' => 'Basic shared hosting for small websites',
                'long_description' => 'Perfect for small websites and blogs. Our Starter hosting includes 5GB SSD storage, 50GB bandwidth, free SSL certificate, and daily backups.',
                'type' => 'subscription',
                'price' => 3.70,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'web-hosting',
                'metadata' => [
                    'features' => [
                        '5GB SSD storage',
                        '50GB bandwidth',
                        'Free SSL certificate',
                        '1 website',
                        'Daily backups',
                        'Email support'
                    ],
                    'delivery_time' => 'Instant setup'
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Business Web Hosting',
                'slug' => 'business-web-hosting',
                'short_description' => 'Enhanced hosting for growing businesses',
                'long_description' => 'Ideal for growing businesses with multiple websites. Includes 25GB SSD storage, 200GB bandwidth, up to 5 websites, and priority support.',
                'type' => 'subscription',
                'price' => 11.11,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'web-hosting',
                'metadata' => [
                    'features' => [
                        '25GB SSD storage',
                        '200GB bandwidth',
                        'Free SSL certificate',
                        'Up to 5 websites',
                        'Daily backups',
                        'Priority support',
                        'Free CDN'
                    ],
                    'delivery_time' => 'Instant setup',
                    'most_popular' => true
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Premium Web Hosting',
                'slug' => 'premium-web-hosting',
                'short_description' => 'Maximum performance hosting solution',
                'long_description' => 'Our most powerful hosting solution with 100GB SSD storage, unlimited bandwidth, unlimited websites, and dedicated resources.',
                'type' => 'subscription',
                'price' => 29.63,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'web-hosting',
                'metadata' => [
                    'features' => [
                        '100GB SSD storage',
                        'Unlimited bandwidth',
                        'Free SSL certificate',
                        'Unlimited websites',
                        'Hourly backups',
                        '24/7 priority support',
                        'Free CDN & caching',
                        'Dedicated IP'
                    ],
                    'delivery_time' => 'Instant setup'
                ],
                'available' => true,
                'visible' => true,
            ],

            // Domain Name Services
            [
                'title' => '.com Domain Registration',
                'slug' => 'com-domain-registration',
                'short_description' => 'Most popular domain extension worldwide',
                'long_description' => 'Register your .com domain - the most trusted and recognized domain extension globally. Includes free DNS management and WHOIS privacy.',
                'type' => 'subscription',
                'price' => 22.22,
                'currency' => 'USD',
                'billing_interval' => 'yearly',
                'category_slug' => 'domain-names',
                'metadata' => [
                    'features' => [
                        'Free DNS management',
                        'Free WHOIS privacy',
                        'Email forwarding',
                        '24/7 support'
                    ],
                    'delivery_time' => 'Instant registration'
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => '.gh Domain Registration',
                'slug' => 'gh-domain-registration',
                'short_description' => 'Ghana local domain for local businesses',
                'long_description' => 'Register your .gh domain to establish local presence in Ghana. Perfect for businesses targeting Ghanaian customers with local SEO advantages.',
                'type' => 'subscription',
                'price' => 44.44,
                'currency' => 'USD',
                'billing_interval' => 'yearly',
                'category_slug' => 'domain-names',
                'metadata' => [
                    'features' => [
                        'Free DNS management',
                        'Local SEO advantage',
                        'Email forwarding',
                        'Ghana business credibility',
                        '24/7 support'
                    ],
                    'delivery_time' => '1-2 business days',
                    'most_popular' => true
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Premium Domain Acquisition',
                'slug' => 'premium-domain-acquisition',
                'short_description' => 'Premium and brandable domain names',
                'long_description' => 'Acquire premium, short, and brandable domain names for your business. We handle research, negotiation, and transfer for high-value domains.',
                'type' => 'one_time',
                'price' => 0.00,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'domain-names',
                'metadata' => [
                    'features' => [
                        'Short & memorable names',
                        'Brandable domains',
                        'Market research included',
                        'Negotiation assistance',
                        'Free transfer support'
                    ],
                    'delivery_time' => '1-4 weeks',
                    'custom_pricing' => true
                ],
                'available' => true,
                'visible' => true,
            ],

            // Mobile App Development Services
            [
                'title' => 'Simple Mobile App',
                'slug' => 'simple-mobile-app',
                'short_description' => 'Basic mobile app for single platform',
                'long_description' => 'Perfect for startups and small businesses looking to establish mobile presence. Includes basic UI/UX design, essential features, and single platform development.',
                'type' => 'one_time',
                'price' => 370.37,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'mobile-app-development',
                'metadata' => [
                    'features' => [
                        'iOS or Android (single platform)',
                        'Up to 5 screens',
                        'Basic UI/UX design',
                        'Push notifications',
                        'User authentication',
                        '30-day support'
                    ],
                    'delivery_time' => '2-4 weeks'
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Professional Mobile App',
                'slug' => 'professional-mobile-app',
                'short_description' => 'Full-featured app for both platforms',
                'long_description' => 'Comprehensive mobile app solution for growing businesses. Includes custom UI/UX design, backend integration, payment gateway, and deployment to both app stores.',
                'type' => 'one_time',
                'price' => 1851.85,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'mobile-app-development',
                'metadata' => [
                    'features' => [
                        'iOS & Android (both platforms)',
                        'Up to 15 screens',
                        'Custom UI/UX design',
                        'Backend integration',
                        'Payment gateway',
                        'Analytics integration',
                        '90-day support'
                    ],
                    'delivery_time' => '6-8 weeks',
                    'most_popular' => true
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Enterprise Mobile App',
                'slug' => 'enterprise-mobile-app',
                'short_description' => 'Complex mobile solutions for enterprises',
                'long_description' => 'Enterprise-grade mobile application with advanced features, multi-platform support, real-time functionality, and dedicated development team.',
                'type' => 'one_time',
                'price' => 3703.70,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'mobile-app-development',
                'metadata' => [
                    'features' => [
                        'Multi-platform (iOS, Android, Web)',
                        'Unlimited screens',
                        'Premium design & branding',
                        'Advanced features & integrations',
                        'Real-time functionality',
                        'Dedicated team',
                        '1-year support & maintenance'
                    ],
                    'delivery_time' => 'Custom timeline'
                ],
                'available' => true,
                'visible' => true,
            ],

            // Consulting Services
            [
                'title' => 'Hourly Technical Consulting',
                'slug' => 'hourly-technical-consulting',
                'short_description' => 'Expert advice on demand',
                'long_description' => 'Get expert technical advice, strategy planning, code review, and architecture design on an hourly basis. Perfect for specific questions and short-term guidance.',
                'type' => 'consulting',
                'price' => 37.04,
                'currency' => 'USD',
                'billing_interval' => 'hourly',
                'category_slug' => 'consulting-services',
                'metadata' => [
                    'features' => [
                        'Technical advice',
                        'Strategy planning',
                        'Code review',
                        'Architecture design',
                        'Follow-up email summary'
                    ],
                    'delivery_time' => 'Flexible scheduling',
                    'minimum_hours' => 2
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Monthly Consulting Retainer',
                'slug' => 'monthly-consulting-retainer',
                'short_description' => 'Ongoing technical support and guidance',
                'long_description' => 'Monthly retainer for ongoing technical consulting with dedicated consultant, priority scheduling, and comprehensive support.',
                'type' => 'subscription',
                'price' => 370.37,
                'currency' => 'USD',
                'billing_interval' => 'monthly',
                'category_slug' => 'consulting-services',
                'metadata' => [
                    'features' => [
                        '10 consulting hours/month',
                        'Priority scheduling',
                        'Dedicated consultant',
                        'Strategic roadmap',
                        'Monthly reports',
                        'Email & Slack support'
                    ],
                    'delivery_time' => 'Ongoing support',
                    'most_popular' => true
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Project-Based Consulting',
                'slug' => 'project-based-consulting',
                'short_description' => 'Custom consulting engagement',
                'long_description' => 'Comprehensive consulting for specific projects including full assessment, technology selection, team augmentation, and implementation support.',
                'type' => 'custom',
                'price' => 0.00,
                'currency' => 'USD',
                'billing_interval' => 'project',
                'category_slug' => 'consulting-services',
                'metadata' => [
                    'features' => [
                        'Full project assessment',
                        'Technology selection',
                        'Team augmentation',
                        'Implementation support',
                        'Post-launch optimization',
                        'Custom SLA'
                    ],
                    'delivery_time' => 'Custom timeline',
                    'custom_pricing' => true
                ],
                'available' => true,
                'visible' => true,
            ],

            // Training Services
            [
                'title' => 'Individual Technical Training',
                'slug' => 'individual-technical-training',
                'short_description' => 'One-on-one personalized training',
                'long_description' => 'Personalized technical training sessions designed for individual learning goals. Includes hands-on exercises, progress tracking, and certification.',
                'type' => 'package',
                'price' => 222.22,
                'currency' => 'USD',
                'billing_interval' => 'session',
                'category_slug' => 'training-services',
                'metadata' => [
                    'features' => [
                        'Personalized curriculum',
                        'Hands-on exercises',
                        'Progress tracking',
                        'Certificate of completion',
                        'Learning resources included'
                    ],
                    'delivery_time' => 'Flexible scheduling'
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Team Technical Training',
                'slug' => 'team-technical-training',
                'short_description' => 'Group training for teams (5-10 people)',
                'long_description' => 'Interactive team training workshops designed for groups of 5-10 people. Includes customized content, team projects, and post-training support.',
                'type' => 'package',
                'price' => 148.15,
                'currency' => 'USD',
                'billing_interval' => 'session',
                'category_slug' => 'training-services',
                'metadata' => [
                    'features' => [
                        'Customized content',
                        'Interactive sessions',
                        'Team projects',
                        'Post-training support (30 days)',
                        'Certificates for all participants',
                        'Training materials'
                    ],
                    'delivery_time' => 'Full-day workshop',
                    'most_popular' => true
                ],
                'available' => true,
                'visible' => true,
            ],
            [
                'title' => 'Corporate Training Program',
                'slug' => 'corporate-training-program',
                'short_description' => 'Large-scale training for organizations',
                'long_description' => 'Comprehensive training programs for large organizations with unlimited participants, custom curriculum design, and extended support.',
                'type' => 'custom',
                'price' => 0.00,
                'currency' => 'USD',
                'billing_interval' => 'program',
                'category_slug' => 'training-services',
                'metadata' => [
                    'features' => [
                        'Unlimited participants',
                        'Custom curriculum design',
                        'On-site or remote delivery',
                        'Skills assessment',
                        '90-day post-training support',
                        'Management reporting'
                    ],
                    'delivery_time' => 'Multi-day programs',
                    'custom_pricing' => true
                ],
                'available' => true,
                'visible' => true,
            ],
        ];
    }
}
