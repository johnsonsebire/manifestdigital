<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class FormSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view-form-submissions');
        
        $formId = $request->query('form_id');
        
        if ($formId) {
            $form = Form::findOrFail($formId);
            $submissions = FormSubmission::where('form_id', $formId)
                ->with('user')
                ->latest()
                ->paginate(20);
                
            return view('admin.form-submissions.index', compact('submissions', 'form'));
        } else {
            $submissions = FormSubmission::with(['form', 'user'])
                ->latest()
                ->paginate(20);
                
            return view('admin.form-submissions.all', compact('submissions'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Not used in admin context - submissions are created from front-end forms
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Not used in admin context - submissions are created from front-end forms
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view-form-submissions');
        
        $submission = FormSubmission::with(['form.fields', 'user'])->findOrFail($id);
        
        return view('admin.form-submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Not used - submissions are not typically edited
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     * 
     * Not used - submissions are not typically edited
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('view-form-submissions');
        
        $submission = FormSubmission::findOrFail($id);
        $formId = $submission->form_id;
        
        // Delete the submission
        $submission->delete();
        
        return redirect()->route('admin.form-submissions.index', ['form_id' => $formId])
            ->with('success', 'Submission deleted successfully.');
    }
    
    /**
     * Export submissions to Excel.
     */
    public function exportToExcel(Request $request, $formId)
    {
        $this->authorize('export-form-submissions');
        
        $form = Form::with('fields')->findOrFail($formId);
        $submissions = FormSubmission::where('form_id', $formId)
            ->latest()
            ->get();
        
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set up headers
        $headers = ['ID', 'Submission Date'];
        $formFields = $form->fields->sortBy('order')->pluck('label', 'name')->toArray();
        
        foreach ($formFields as $label) {
            $headers[] = $label;
        }
        
        $headers[] = 'Submitted By';
        $headers[] = 'IP Address';
        
        // Add header row
        $sheet->fromArray([$headers], NULL, 'A1');
        
        // Add data rows
        $row = 2;
        foreach ($submissions as $submission) {
            $rowData = [
                $submission->id,
                $submission->created_at->format('Y-m-d H:i:s'),
            ];
            
            // Add field data
            foreach ($formFields as $name => $label) {
                $rowData[] = $submission->data[$name] ?? '';
            }
            
            // Add user and IP
            $rowData[] = $submission->user ? $submission->user->name : 'Guest';
            $rowData[] = $submission->ip_address;
            
            $sheet->fromArray([$rowData], NULL, 'A' . $row);
            $row++;
        }
        
        // Style the header row
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
            ->getFont()->setBold(true);
        
        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Create file in storage
        $filename = 'form_submissions_' . $form->slug . '_' . date('Y-m-d_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        
        // Create the storage path if it doesn't exist
        if (!Storage::disk('public')->exists('exports')) {
            Storage::disk('public')->makeDirectory('exports');
        }
        
        $path = storage_path('app/public/exports/' . $filename);
        $writer->save($path);
        
        // Return download response
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend();
    }
    
    /**
     * Export submissions to PDF.
     */
    public function exportToPdf(Request $request, $formId)
    {
        $this->authorize('export-form-submissions');
        
        $form = Form::with('fields')->findOrFail($formId);
        $submissions = FormSubmission::where('form_id', $formId)
            ->latest()
            ->get();
        
        $pdf = PDF::loadView('admin.form-submissions.pdf-export', [
            'form' => $form,
            'submissions' => $submissions
        ]);
        
        $filename = 'form_submissions_' . $form->slug . '_' . date('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
