<?php

namespace App\View\Components\Layouts\Frontend;

use Illuminate\View\Component;

class FooterNavigation extends Component
{
    /**
     * The navigation groups for the footer.
     *
     * @var array
     */
    public $navigationGroups;

    /**
     * Create a new component instance.
     *
     * @param array|null $navigationGroups
     * @return void
     */
    public function __construct($navigationGroups = null)
    {
        // If no navigation groups provided, use default structure
        $this->navigationGroups = $navigationGroups ?? [
            [
                'links' => [
                    ['label' => 'About Us', 'url' => 'about-us'],
                    ['label' => 'Opportunities', 'url' => 'opportunities'],
                    ['label' => 'Our Blog', 'url' => 'blog'],
                    ['label' => 'Solutions', 'url' => 'solutions'],
                    ['label' => 'Policies', 'url' => 'policies'],
                ]
            ],
            [
                'links' => [
                    ['label' => 'Mobile App Design', 'url' => 'mobile-app-design'],
                    ['label' => 'Website Development', 'url' => 'website-development'],
                    ['label' => 'SAP Consulting', 'url' => 'sap-consulting'],
                    ['label' => 'Brand Positioning', 'url' => 'brand-positioning'],
                    ['label' => 'IT Training', 'url' => 'it-training'],
                ]
            ],
            [
                'links' => [
                    ['label' => 'SEO Services', 'url' => 'seo-services'],
                    ['label' => 'QA Testing', 'url' => 'qa-testing'],
                    ['label' => 'Blockchain Solutions', 'url' => 'blockchain-solutions'],
                    ['label' => 'Cyber Security', 'url' => 'cyber-security'],
                    ['label' => 'Cloud Computing', 'url' => 'cloud-computing'],
                ]
            ]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layouts.frontend.footer-navigation');
    }
}