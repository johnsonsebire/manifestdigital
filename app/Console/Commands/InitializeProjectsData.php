<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InitializeProjectsData extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'projects:initialize';

    /**
     * The console command description.
     */
    protected $description = 'Initialize projects data from template or create empty structure';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $storageFile = storage_path('app/projects-data.json');
        
        // Check if file already exists
        if (File::exists($storageFile)) {
            $this->info('✅ Projects data file already exists at: ' . $storageFile);
            $projects = json_decode(File::get($storageFile), true);
            $this->info('📊 Current projects count: ' . count($projects));
            return Command::SUCCESS;
        }

        // Try to copy from template first
        $templateFile = resource_path('views/manifest-template/components/projects-data.json');
        
        if (File::exists($templateFile)) {
            File::copy($templateFile, $storageFile);
            $this->info('✅ Copied projects data from template to: ' . $storageFile);
        } else {
            // Create default projects data if template doesn't exist
            $defaultProjects = $this->getDefaultProjectsData();
            File::put($storageFile, json_encode($defaultProjects, JSON_PRETTY_PRINT));
            $this->info('✅ Created new projects data file at: ' . $storageFile);
        }

        $projects = json_decode(File::get($storageFile), true);
        $this->info('📊 Initialized with ' . count($projects) . ' projects');
        
        return Command::SUCCESS;
    }

    /**
     * Get default projects data structure.
     */
    private function getDefaultProjectsData(): array
    {
        return [
            [
                "id" => 1,
                "title" => "My Help Your Help Foundation",
                "slug" => "my-help-your-help-foundation",
                "category" => "nonprofit",
                "displayCategory" => "Nonprofit",
                "excerpt" => "A non-profit organization dedicated to community development and education.",
                "image" => "/images/projects/myhelpyourhelp.png",
                "url" => "https://myhelpyourhelp.org",
                "featured" => true
            ],
            [
                "id" => 2,
                "title" => "L-Time Properties",
                "slug" => "ltime-properties",
                "category" => "business",
                "displayCategory" => "Real Estate",
                "excerpt" => "Real estate platform connecting buyers with premium properties.",
                "image" => "/images/ltimeproperties.png",
                "url" => "https://ltimepropertiesltd.com",
                "featured" => true
            ],
            [
                "id" => 3,
                "title" => "Koko Plus Foundation",
                "slug" => "koko-plus-foundation",
                "category" => "nonprofit",
                "displayCategory" => "Nonprofit",
                "excerpt" => "Foundation supporting underprivileged communities through education.",
                "image" => "/images/kokoplus.png",
                "url" => "https://kokoplusfoundation.org",
                "featured" => true
            ],
            [
                "id" => 4,
                "title" => "Good News Library",
                "slug" => "good-news-library",
                "category" => "education",
                "displayCategory" => "Education",
                "excerpt" => "Educational library platform providing digital resources.",
                "image" => "/images/goodnewslibrary.png",
                "url" => "https://goodnewslibrary.com",
                "featured" => true
            ],
            [
                "id" => 5,
                "title" => "Barjul Travels",
                "slug" => "barjul-travels",
                "category" => "business",
                "displayCategory" => "Travel & Tourism",
                "excerpt" => "Travel agency offering curated tourism experiences.",
                "image" => "/images/projects/barjultravels.png",
                "url" => "https://barjultravels.com",
                "featured" => false
            ]
        ];
    }
}