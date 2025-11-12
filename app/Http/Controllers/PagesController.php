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
        return view('pages.ai-sensei');
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
     * Show the Mobile App Design page.
     *
     * @return \Illuminate\View\View
     */
    public function mobileAppDesign()
    {
        return view('pages.mobile-app-design');
    }

    /**
     * Show the Website Development page.
     *
     * @return \Illuminate\View\View
     */
    public function websiteDevelopment()
    {
        return view('pages.website-development');
    }

    /**
     * Show the SAP Consulting page.
     *
     * @return \Illuminate\View\View
     */
    public function sapConsulting()
    {
        return view('pages.sap-consulting');
    }

    /**
     * Show the Brand Positioning page.
     *
     * @return \Illuminate\View\View
     */
    public function brandPositioning()
    {
        return view('pages.brand-positioning');
    }

    /**
     * Show the IT Training page.
     *
     * @return \Illuminate\View\View
     */
    public function itTraining()
    {
        return view('pages.it-training');
    }

    /**
     * Show the SEO Services page.
     *
     * @return \Illuminate\View\View
     */
    public function seoServices()
    {
        return view('pages.seo-services');
    }

    /**
     * Show the QA Testing page.
     *
     * @return \Illuminate\View\View
     */
    public function qaTesting()
    {
        return view('pages.qa-testing');
    }

    /**
     * Show the Blockchain Solutions page.
     *
     * @return \Illuminate\View\View
     */
    public function blockchainSolutions()
    {
        return view('pages.blockchain-solutions');
    }

    /**
     * Show the Cyber Security page.
     *
     * @return \Illuminate\View\View
     */
    public function cyberSecurity()
    {
        return view('pages.cyber-security');
    }

    /**
     * Show the Cloud Computing page.
     *
     * @return \Illuminate\View\View
     */
    public function cloudComputing()
    {
        return view('pages.cloud-computing');
    }
}
