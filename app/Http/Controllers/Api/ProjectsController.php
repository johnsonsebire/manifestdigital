<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Load projects from JSON file
            $jsonPath = storage_path('app/projects-data.json');
            
            // Check if file exists
            if (!file_exists($jsonPath)) {
                return response()->json([
                    'error' => 'Projects data file not found',
                    'path' => $jsonPath
                ], 404);
            }
            
            // Read and decode JSON
            $jsonContent = file_get_contents($jsonPath);
            if ($jsonContent === false) {
                return response()->json([
                    'error' => 'Unable to read projects data file',
                    'path' => $jsonPath
                ], 500);
            }
            
            $projects = json_decode($jsonContent, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'error' => 'Invalid JSON in projects data file',
                    'json_error' => json_last_error_msg()
                ], 500);
            }
            
            if (!is_array($projects)) {
                return response()->json([
                    'error' => 'Projects data is not an array'
                ], 500);
            }
        
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
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while loading projects',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
