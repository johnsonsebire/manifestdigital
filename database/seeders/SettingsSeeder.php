<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Company Information
            [
                'key' => 'company_name',
                'value' => 'Your Company Name',
                'type' => 'string',
                'group' => 'company',
            ],
            [
                'key' => 'company_address',
                'value' => '123 Business Street',
                'type' => 'string',
                'group' => 'company',
            ],
            [
                'key' => 'company_city_state_zip',
                'value' => 'City, State 12345',
                'type' => 'string',
                'group' => 'company',
            ],
            [
                'key' => 'company_email',
                'value' => 'contact@company.com',
                'type' => 'string',
                'group' => 'company',
            ],
            [
                'key' => 'company_phone',
                'value' => '(123) 456-7890',
                'type' => 'string',
                'group' => 'company',
            ],
            [
                'key' => 'company_website',
                'value' => 'www.yourcompany.com',
                'type' => 'string',
                'group' => 'company',
            ],
            [
                'key' => 'company_tax_id',
                'value' => '',
                'type' => 'string',
                'group' => 'company',
            ],
            
            // Invoice Settings
            [
                'key' => 'invoice_footer_note',
                'value' => 'If you have any questions about this invoice, please contact us at contact@company.com',
                'type' => 'text',
                'group' => 'invoice',
            ],
            [
                'key' => 'invoice_terms',
                'value' => 'Payment is due within 30 days. Thank you for your business!',
                'type' => 'text',
                'group' => 'invoice',
            ],
            [
                'key' => 'invoice_prefix',
                'value' => 'INV',
                'type' => 'string',
                'group' => 'invoice',
            ],
            [
                'key' => 'invoice_logo_path',
                'value' => '',
                'type' => 'string',
                'group' => 'invoice',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
