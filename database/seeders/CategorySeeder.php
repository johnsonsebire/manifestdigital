<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Website Development',
                'slug' => 'website-development',
                'description' => 'Professional website development services from simple business sites to complex enterprise solutions.',
                'order' => 1,
                'visible' => true,
                'metadata' => null,
            ],
            [
                'title' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'User interface and user experience design services for digital products and applications.',
                'order' => 2,
                'visible' => true,
                'metadata' => null,
            ],
            [
                'title' => 'Web Hosting',
                'slug' => 'web-hosting',
                'description' => 'Reliable and secure web hosting solutions for businesses of all sizes.',
                'order' => 3,
                'visible' => true,
                'metadata' => null,
            ],
            [
                'title' => 'Domain Names',
                'slug' => 'domain-names',
                'description' => 'Domain registration and management services for establishing your online presence.',
                'order' => 4,
                'visible' => true,
                'metadata' => null,
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'Native and cross-platform mobile application development for iOS and Android.',
                'order' => 5,
                'visible' => true,
                'metadata' => null,
            ],
            [
                'title' => 'Consulting Services',
                'slug' => 'consulting-services',
                'description' => 'Expert technology consulting and strategic guidance for your digital initiatives.',
                'order' => 6,
                'visible' => true,
                'metadata' => null,
            ],
            [
                'title' => 'Training Services',
                'slug' => 'training-services',
                'description' => 'Professional development and technical training programs for individuals and teams.',
                'order' => 7,
                'visible' => true,
                'metadata' => null,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'uuid' => Str::uuid(),
                    'title' => $categoryData['title'],
                    'description' => $categoryData['description'],
                    'order' => $categoryData['order'],
                    'visible' => $categoryData['visible'],
                    'metadata' => $categoryData['metadata'],
                ]
            );
        }

        $this->command->info('Service categories seeded successfully.');
    }
}
