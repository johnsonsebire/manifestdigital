<?php

namespace App\Http\Controllers;

use App\Models\TeamProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TeamProfileController extends Controller
{
    /**
     * Show the team profile form
     */
    public function create()
    {
        return view('pages.team-profile-form');
    }

    /**
     * Store a new team profile
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'id_key' => 'required|string|max:255|regex:/^[a-z0-9-]+$/|unique:team_profiles,id_key',
            'photo' => 'nullable|image|max:2048', // 2MB Max
            'contact.email' => 'required|email',
            'contact.phone' => 'nullable|string',
            'contact.location' => 'nullable|string',
            'contact.linkedin' => 'nullable|url',
            'contact.github' => 'nullable|url',
            'contact.other_social' => 'nullable|string',
            'bio' => 'required|string',
            'skills' => 'required|array|min:1',
            'skills.*.category' => 'required|string',
            'skills.*.items' => 'required|string',
            'experience' => 'required|array|min:1',
            'experience.*.title' => 'required|string',
            'experience.*.company' => 'required|string',
            'experience.*.duration' => 'required|string',
            'experience.*.location' => 'nullable|string',
            'experience.*.description' => 'required|string',
            'achievements' => 'required|array|min:1',
            'achievements.*.title' => 'required|string',
            'achievements.*.year' => 'nullable|string',
            'achievements.*.description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process skills - convert comma-separated values to arrays
        $processedSkills = [];
        foreach ($request->skills as $skill) {
            $processedSkills[$skill['category']] = array_map('trim', explode(',', $skill['items']));
        }

        // Process experience
        $processedExperience = [];
        foreach ($request->experience as $exp) {
            $processedExperience[] = [
                'title' => $exp['title'],
                'company' => $exp['company'],
                'duration' => $exp['duration'],
                'location' => $exp['location'] ?? '',
                'description' => $exp['description']
            ];
        }

        // Process achievements
        $processedAchievements = [];
        foreach ($request->achievements as $achievement) {
            $processedAchievements[] = [
                'title' => $achievement['title'],
                'year' => $achievement['year'] ?? '',
                'description' => $achievement['description']
            ];
        }

        // Handle photo upload
        $photoReference = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('team-photos', 'public');
            $photoReference = Storage::url($photoPath);
        }

        // Create or update the team profile in the database
        TeamProfile::create([
            'id_key' => $request->id_key,
            'name' => $request->name,
            'role' => $request->role,
            'photo' => $photoReference ?? 'fas fa-user', // Default to Font Awesome icon if no photo
            'contact' => $request->contact,
            'bio' => $request->bio,
            'skills' => $processedSkills,
            'experience' => $processedExperience,
            'achievements' => $processedAchievements,
            'is_active' => true,
            'display_order' => TeamProfile::count() + 1, // Default to the end of the list
        ]);

        return redirect()->back()->with('success', 'Team profile has been successfully submitted!');
    }


}