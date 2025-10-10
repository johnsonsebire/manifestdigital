<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $projects = [
            [
                'id' => 1,
                'title' => 'Good News Library',
                'slug' => 'good-news-library',
                'description' => 'A digital library management system with advanced search and cataloging features.',
                'category' => 'nonprofit',
                'image' => '/images/projects/goodnewslibrary.png',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'AWS']
            ],
            [
                'id' => 2,
                'title' => 'LTime Properties',
                'slug' => 'ltime-properties',
                'description' => 'Real estate management platform with virtual tours and booking system.',
                'category' => 'business',
                'image' => '/images/projects/ltimeproperties.png',
                'technologies' => ['React', 'Node.js', 'MongoDB', 'Digital Ocean']
            ],
            [
                'id' => 3,
                'title' => 'KokoPlus',
                'slug' => 'kokoplus',
                'description' => 'E-learning platform focused on STEM education for African students.',
                'category' => 'education',
                'image' => '/images/projects/kokoplus.png',
                'technologies' => ['Django', 'React', 'PostgreSQL', 'Google Cloud']
            ],
        ];
        
        return response()->json([
            'projects' => $projects,
            'hasMore' => false
        ]);
    }
}