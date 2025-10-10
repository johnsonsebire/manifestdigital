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
                'title' => 'KokoPlus Education',
                'slug' => 'kokoplus',
                'description' => 'E-learning platform focused on STEM education for African students with interactive lessons and assessments.',
                'category' => 'education',
                'image' => '/images/projects/kokoplus.png',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'AWS']
            ],
            [
                'id' => 2,
                'title' => 'LTime Properties',
                'slug' => 'ltime-properties',
                'description' => 'Real estate management platform with virtual tours, property listings, and booking system.',
                'category' => 'business',
                'image' => '/images/projects/ltimeproperties.png',
                'technologies' => ['React', 'Node.js', 'MongoDB', 'Stripe']
            ],
            [
                'id' => 3,
                'title' => 'Johnson Sebire Portfolio',
                'slug' => 'johnson-sebire',
                'description' => 'Personal portfolio website showcasing software development projects and technical expertise.',
                'category' => 'tech',
                'image' => '/images/projects/johnsonsebire.png',
                'technologies' => ['Next.js', 'Tailwind CSS', 'TypeScript', 'Vercel']
            ],
            [
                'id' => 4,
                'title' => 'Alpha Health Group',
                'slug' => 'alpha-health-group',
                'description' => 'Healthcare platform connecting patients with medical professionals and managing appointments.',
                'category' => 'health',
                'image' => '/images/projects/alphahealthgroup.png',
                'technologies' => ['Laravel', 'Alpine.js', 'PostgreSQL', 'Twilio']
            ],
            [
                'id' => 5,
                'title' => 'Chrissy Foundation',
                'slug' => 'chrissy-foundation',
                'description' => 'Nonprofit organization website for community outreach and donation management.',
                'category' => 'nonprofit',
                'image' => '/images/projects/chrissyfoundation.png',
                'technologies' => ['WordPress', 'PHP', 'MySQL', 'Stripe']
            ],
            [
                'id' => 6,
                'title' => 'Bosch School',
                'slug' => 'bosch-school',
                'description' => 'Educational institution management system with student portal and online learning.',
                'category' => 'education',
                'image' => '/images/projects/boschschool.png',
                'technologies' => ['Django', 'React', 'PostgreSQL', 'Redis']
            ],
            [
                'id' => 7,
                'title' => 'Barjul Travels',
                'slug' => 'barjul-travels',
                'description' => 'Travel booking platform with flight search, hotel reservations, and tour packages.',
                'category' => 'business',
                'image' => '/images/projects/barjultravels.png',
                'technologies' => ['Vue.js', 'Laravel', 'MySQL', 'Amadeus API']
            ],
            [
                'id' => 8,
                'title' => 'CCEM Ghana',
                'slug' => 'ccem-ghana',
                'description' => 'Church management system with event scheduling and member engagement tools.',
                'category' => 'nonprofit',
                'image' => '/images/projects/ccemghana.png',
                'technologies' => ['Laravel', 'Livewire', 'MySQL', 'Pusher']
            ],
            [
                'id' => 9,
                'title' => 'Samak Technology',
                'slug' => 'samak-technology',
                'description' => 'Tech startup website showcasing innovative software solutions and services.',
                'category' => 'tech',
                'image' => '/images/projects/samaktechnology.png',
                'technologies' => ['Next.js', 'Sanity CMS', 'GraphQL', 'Vercel']
            ],
            [
                'id' => 10,
                'title' => 'FMS Foundation',
                'slug' => 'fms-foundation',
                'description' => 'Nonprofit foundation supporting educational initiatives and community development.',
                'category' => 'nonprofit',
                'image' => '/images/projects/fmsfoundation.png',
                'technologies' => ['WordPress', 'WooCommerce', 'MySQL', 'PayPal']
            ],
            [
                'id' => 11,
                'title' => 'Nkunim App',
                'slug' => 'nkunim',
                'description' => 'Mobile-first learning application for skill development and certification.',
                'category' => 'education',
                'image' => '/images/projects/nkunim.png',
                'technologies' => ['React Native', 'Firebase', 'Node.js', 'Expo']
            ],
            [
                'id' => 12,
                'title' => 'CliqHost',
                'slug' => 'cliqhost',
                'description' => 'Web hosting platform with automated deployment and domain management.',
                'category' => 'tech',
                'image' => '/images/projects/cliqhost.png',
                'technologies' => ['Laravel', 'Vue.js', 'cPanel API', 'Docker']
            ],
        ];
        
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