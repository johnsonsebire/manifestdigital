<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Store a newly uploaded file.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // 50MB max
            'description' => 'nullable|string|max:500',
        ]);

        $file = $request->file('file');
        
        // Store file in private storage
        $path = $file->store('projects/' . $project->id, 'local');
        
        // Create file record
        $projectFile = $project->files()->create([
            'uploader_id' => auth()->id(),
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'description' => $request->description,
        ]);

        // Log activity
        $project->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'file_uploaded',
            'description' => 'File "' . $projectFile->original_name . '" uploaded by ' . auth()->user()->name,
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Download a file.
     */
    public function download(ProjectFile $file)
    {
        // Check authorization
        if (!auth()->user()->can('viewAny', Project::class) && 
            $file->model->order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized to download this file.');
        }

        if (!Storage::exists($file->path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($file->path, $file->original_name);
    }

    /**
     * Delete a file.
     */
    public function destroy(Project $project, ProjectFile $file)
    {
        $fileName = $file->original_name;
        
        // Delete file (model's boot method will delete from storage)
        $file->delete();

        // Log activity
        $project->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'file_deleted',
            'description' => 'File "' . $fileName . '" deleted by ' . auth()->user()->name,
        ]);

        return back()->with('success', 'File deleted successfully.');
    }

    /**
     * Update file description.
     */
    public function updateDescription(Request $request, Project $project, ProjectFile $file)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        $file->update([
            'description' => $request->description,
        ]);

        // Log activity
        $project->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'file_updated',
            'description' => 'File "' . $file->original_name . '" description updated by ' . auth()->user()->name,
        ]);

        return back()->with('success', 'File description updated successfully.');
    }
}
