<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $companySettings = Setting::where('group', 'company')->get()->keyBy('key');
        $invoiceSettings = Setting::where('group', 'invoice')->get()->keyBy('key');

        return view('admin.settings.index', compact('companySettings', 'invoiceSettings'));
    }

    /**
     * Update company settings
     */
    public function updateCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'company_city_state_zip' => 'nullable|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'nullable|string|max:50',
            'company_website' => 'nullable|string|max:255',
            'company_tax_id' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach ($request->only([
            'company_name',
            'company_address',
            'company_city_state_zip',
            'company_email',
            'company_phone',
            'company_website',
            'company_tax_id',
        ]) as $key => $value) {
            Setting::set($key, $value ?? '', 'string', 'company');
        }

        Setting::clearCache();

        return back()->with('success', 'Company settings updated successfully!');
    }

    /**
     * Update invoice settings
     */
    public function updateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_footer_note' => 'nullable|string',
            'invoice_terms' => 'nullable|string',
            'invoice_prefix' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach ($request->only([
            'invoice_footer_note',
            'invoice_terms',
            'invoice_prefix',
        ]) as $key => $value) {
            $type = in_array($key, ['invoice_footer_note', 'invoice_terms']) ? 'text' : 'string';
            Setting::set($key, $value ?? '', $type, 'invoice');
        }

        Setting::clearCache();

        return back()->with('success', 'Invoice settings updated successfully!');
    }
}
