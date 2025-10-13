<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show the AI Sensei page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.ai-chat');
    }

    /**
     * Show the Projects page.
     *
     * @return \Illuminate\View\View
     */
    public function projects()
    {
         return view('pages.projects');
    }

    /**
     * Show the Project Detail page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function projectDetail($slug)
    {
        // Load projects data
        $projectsFile = storage_path('app/projects-data.json');
        $projects = json_decode(file_get_contents($projectsFile), true);
        
        // Find project by slug
        $project = collect($projects)->firstWhere('slug', $slug);
        
        // Return 404 if project not found
        if (!$project) {
            abort(404, 'Project not found');
        }
        
        return view('pages.project-detail', compact('project'));
    }

    /**
     * Show the Book a Call page.
     *
     * @return \Illuminate\View\View
     */
    public function bookACall()
    {
        return view('pages.book-a-call');
    }

    /**
     * Show the Request a Quote page.
     *
     * @return \Illuminate\View\View
     */
    public function requestQuote()
    {
        return view('pages.request-quote');
    }

    /**
     * Show the About Us page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('pages.about');
    }

    public function opportunities()
    {
        return view('pages.opportunities');
    }

    public function applicationSuccess()
    {
        return view('pages.application-success');
    }

    public function solutions()
    {
        return view('pages.solutions');
    }

    public function policies()
    {
        return view('pages.policies');
    }

    public function blog(){
        return view('pages.blog');
    }

    /**
     * Show the Blog Detail page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function blogDetail($slug)
    {
        // In a real application, you would load the blog post data here
        return view('pages.blog-detail');
    }

    /**
     * Show the Contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }
}
