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
}
