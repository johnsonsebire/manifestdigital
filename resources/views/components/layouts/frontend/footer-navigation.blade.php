@props([
    'navigationGroups' => [
        [
            'links' => [
                ['label' => 'About Us', 'url' => 'about'],
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
    ]
])

<nav class="footer-nav">
    @foreach($navigationGroups as $group)
        <div>
            @foreach($group['links'] as $link)
                <a href="{{ url($link['url']) }}">{{ $link['label'] }}</a>
            @endforeach
        </div>
    @endforeach
</nav>