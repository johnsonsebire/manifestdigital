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
        
        $query = FormSubmission::with(['form', 'user']);
        
        // Filter by form
        if ($request->filled('form_id')) {
            $query->forForm($request->form_id);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Date range filter
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }
        
        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $submissions = $query->paginate(20)->withQueryString();
        
        // Get all forms for filter dropdown
        $forms = Form::orderBy('title')->get();
        
        // If specific form selected, get its details
        $form = $request->filled('form_id') ? Form::find($request->form_id) : null;
        
        // Statistics
        $stats = [
            'total' => FormSubmission::count(),
            'today' => FormSubmission::whereDate('created_at', today())->count(),
            'this_week' => FormSubmission::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => FormSubmission::whereMonth('created_at', now()->month)->count(),
        ];
        
        return view('admin.form-submissions.index', compact('submissions', 'forms', 'form', 'stats'));
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
    
    /**
     * Export a single submission to PDF.
     */
    public function exportSubmissionToPdf($id)
    {
        $this->authorize('view-form-submissions');
        
        $submission = FormSubmission::with(['form.fields', 'user'])->findOrFail($id);
        $submitterInfo = $submission->getSubmitterInfo();
        
        $pdf = PDF::loadView('admin.form-submissions.single-pdf-export', [
            'submission' => $submission,
            'submitterInfo' => $submitterInfo
        ]);
        
        $filename = 'submission_' . $submission->id . '_' . date('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * Export a single submission to Excel.
     */
    public function exportSubmissionToExcel($id)
    {
        $this->authorize('view-form-submissions');
        
        $submission = FormSubmission::with(['form.fields', 'user'])->findOrFail($id);
        $submitterInfo = $submission->getSubmitterInfo();
        
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setTitle('Submission #' . $submission->id);
        
        // Add header
        $sheet->setCellValue('A1', 'Field Name');
        $sheet->setCellValue('B1', 'Value');
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        
        $row = 2;
        
        // Add submitter info section
        if ($submitterInfo['first_name'] || $submitterInfo['last_name'] || $submitterInfo['email']) {
            $sheet->setCellValue('A' . $row, '--- Submitter Information ---');
            $sheet->mergeCells('A' . $row . ':B' . $row);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $row++;
            
            if ($submitterInfo['first_name']) {
                $sheet->setCellValue('A' . $row, 'First Name');
                $sheet->setCellValue('B' . $row, $submitterInfo['first_name']);
                $row++;
            }
            
            if ($submitterInfo['last_name']) {
                $sheet->setCellValue('A' . $row, 'Last Name');
                $sheet->setCellValue('B' . $row, $submitterInfo['last_name']);
                $row++;
            }
            
            if ($submitterInfo['email']) {
                $sheet->setCellValue('A' . $row, 'Email');
                $sheet->setCellValue('B' . $row, $submitterInfo['email']);
                $row++;
            }
            
            $row++; // Empty row
        }
        
        // Add submission metadata
        $sheet->setCellValue('A' . $row, '--- Submission Details ---');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Submitted At');
        $sheet->setCellValue('B' . $row, $submission->created_at->format('M d, Y \a\t h:i A'));
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Form');
        $sheet->setCellValue('B' . $row, $submission->form->name);
        $row++;
        
        $sheet->setCellValue('A' . $row, 'IP Address');
        $sheet->setCellValue('B' . $row, $submission->ip_address ?? 'N/A');
        $row++;
        
        $row++; // Empty row
        
        // Add form data
        $sheet->setCellValue('A' . $row, '--- Submitted Data ---');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $row++;
        
        foreach ($submission->data as $key => $value) {
            $fieldName = FormSubmission::formatFieldName($key);
            $fieldValue = is_array($value) ? implode(', ', $value) : $value;
            
            $sheet->setCellValue('A' . $row, $fieldName);
            $sheet->setCellValue('B' . $row, $fieldValue);
            $row++;
        }
        
        // Auto-size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        
        // Create file
        $filename = 'submission_' . $submission->id . '_' . date('Y-m-d_His') . '.xlsx';
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
}

