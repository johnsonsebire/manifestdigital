<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        // Load projects from JSON file
        $jsonPath = storage_path('app/projects-data.json');
        $projects = json_decode(file_get_contents($jsonPath), true);
        
        // Apply filtering if category is specified
        $category = $request->get('category');
        if ($category && $category !== 'all') {
            $projects = array_filter($projects, function($project) use ($category) {
                return $project['category'] === $category;
            });
            $projects = array_values($projects);
        }
        
        // Apply search if search term is specified
        $search = $request->get('search');
        if ($search) {
            $projects = array_filter($projects, function($project) use ($search) {
                return stripos($project['title'], $search) !== false || 
                       stripos($project['excerpt'], $search) !== false;
            });
            $projects = array_values($projects);
        }
        
        // Pagination
        $page = $request->get('page', 1);
        $perPage = 9;
        $offset = ($page - 1) * $perPage;
        
        $paginatedProjects = array_slice($projects, $offset, $perPage);
        $hasMore = count($projects) > ($offset + $perPage);
        
        return response()->json([
            'projects' => $paginatedProjects,
            'hasMore' => $hasMore,
            'total' => count($projects),
            'currentPage' => $page
        ]);
    }
}
