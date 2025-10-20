@extends('admin.layouts.app')

@section('title', 'Configure Service Reminders - ' . $service->title)

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.reminders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 mb-2 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Reminders
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $service->title }}</h1>
                <p class="mt-1 text-sm text-gray-600">Configure expiration reminder schedule for this service</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200">
        <div class="flex">
            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Service Default Configuration -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900">Service Default Reminder</h2>
                    <p class="mt-1 text-sm text-gray-600">This schedule applies to all customers unless they have a specific override</p>
                </div>

                <form action="{{ route('admin.reminders.store-service', $service) }}" method="POST" class="p-6">
                    @csrf

                    <!-- Enable/Disable -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $reminder?->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm font-medium text-gray-900">Enable reminders for this service</span>
                        </label>
                    </div>

                    <!-- Reminder Days -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Reminder Schedule (days before expiration)</label>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            @php
                                $commonDays = [30, 15, 10, 7, 5, 3, 1, 0];
                                $currentDays = old('reminder_days_before', $reminder?->reminder_days_before ?? [15, 10, 5, 0]);
                            @endphp
                            
                            @foreach($commonDays as $day)
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer {{ in_array($day, $currentDays) ? 'bg-indigo-50 border-indigo-500' : '' }}">
                                <input type="checkbox" name="reminder_days_before[]" value="{{ $day }}" {{ in_array($day, $currentDays) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ $day }} {{ Str::plural('day', $day) }}</span>
                            </label>
                            @endforeach
                        </div>

                        <!-- Custom Days -->
                        <div id="custom-days-container" class="space-y-2">
                            @foreach($currentDays as $day)
                                @if(!in_array($day, $commonDays))
                                <div class="flex items-center gap-2 custom-day-row">
                                    <input type="number" name="reminder_days_before[]" value="{{ $day }}" min="0" max="90" class="w-24 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-600">days before</span>
                                    <button type="button" onclick="this.closest('.custom-day-row').remove()" class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <button type="button" onclick="addCustomDay()" class="mt-3 inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Custom Day
                        </button>

                        @error('reminder_days_before')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Template -->
                    <div class="mb-6">
                        <label for="email_template" class="block text-sm font-medium text-gray-700 mb-2">Email Template (optional)</label>
                        <input type="text" id="email_template" name="email_template" value="{{ old('email_template', $reminder?->email_template) }}" placeholder="emails.subscriptions.expiration-reminder" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Leave blank to use the default template</p>
                        @error('email_template')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Custom Message -->
                    <div class="mb-6">
                        <label for="custom_message" class="block text-sm font-medium text-gray-700 mb-2">Custom Message (optional)</label>
                        <textarea id="custom_message" name="custom_message" rows="4" placeholder="Add a custom message to include in reminder emails..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('custom_message', $reminder?->custom_message) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">This message will be included in the reminder emails</p>
                        @error('custom_message')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.reminders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="button" onclick="showPreview()" class="px-4 py-2 border border-indigo-300 rounded-lg text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview Email
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Overrides Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Customer Overrides</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ $customerOverrides->count() }} custom configurations</p>
                </div>

                <div class="p-6">
                    @if($customerOverrides->isEmpty())
                    <p class="text-sm text-gray-500 text-center py-8">No customer-specific overrides for this service.</p>
                    @else
                    <div class="space-y-3">
                        @foreach($customerOverrides as $override)
                        <div class="border border-gray-200 rounded-lg p-3 hover:border-indigo-300">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $override->customer->name }}</p>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach($override->reminder_days_before as $day)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            {{ $day }}d
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $override->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $override->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('admin.reminders.configure-customer', [$service, $override->customer]) }}" class="text-xs text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.reminders.destroy', $override) }}" method="POST" class="inline" onsubmit="return confirm('Remove this override?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-900">Remove</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($customers->isNotEmpty())
                    <div class="mt-6">
                        <label for="add-customer" class="block text-sm font-medium text-gray-700 mb-2">Add Customer Override</label>
                        <select id="add-customer" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a customer...</option>
                            @foreach($customers as $customer)
                                @if(!$customerOverrides->contains('customer_id', $customer->id))
                                <option value="{{ route('admin.reminders.configure-customer', [$service, $customer]) }}">{{ $customer->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addCustomDay() {
    const container = document.getElementById('custom-days-container');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2 custom-day-row';
    div.innerHTML = `
        <input type="number" name="reminder_days_before[]" value="14" min="0" max="90" class="w-24 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        <span class="text-sm text-gray-600">days before</span>
        <button type="button" onclick="this.closest('.custom-day-row').remove()" class="text-red-600 hover:text-red-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    `;
    container.appendChild(div);
}

document.getElementById('add-customer')?.addEventListener('change', function(e) {
    if (e.target.value) {
        window.location.href = e.target.value;
    }
});

// Email Preview Functionality
function showPreview() {
    // Get selected days
    const selectedDays = [];
    document.querySelectorAll('input[name="reminder_days_before[]"]:checked').forEach(input => {
        selectedDays.push(parseInt(input.value));
    });

    if (selectedDays.length === 0) {
        alert('Please select at least one reminder day before previewing.');
        return;
    }

    // Get custom message
    const customMessage = document.getElementById('custom_message').value;
    const emailTemplate = document.getElementById('email_template').value;

    // Show modal
    showPreviewModal(selectedDays, customMessage, emailTemplate);
}

function showPreviewModal(days, customMessage, template) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
    modal.id = 'preview-modal';
    
    modal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4 border-b pb-4">
                <h3 class="text-lg font-semibold text-gray-900">Email Preview</h3>
                <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Preview Controls -->
            <div class="mb-4 flex gap-4 items-center">
                <label class="text-sm font-medium text-gray-700">Preview for:</label>
                <select id="preview-days-select" onchange="loadPreview()" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    ${days.sort((a, b) => b - a).map(day => `<option value="${day}">${day} ${day === 1 ? 'day' : 'days'} before</option>`).join('')}
                </select>
                <button onclick="sendTestEmail()" class="ml-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Send Test Email
                </button>
            </div>

            <!-- Loading State -->
            <div id="preview-loading" class="text-center py-8">
                <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-600">Loading preview...</p>
            </div>

            <!-- Preview Content -->
            <div id="preview-content" class="hidden">
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-1">Subject:</p>
                    <p id="preview-subject" class="text-gray-900"></p>
                </div>
                <div class="border rounded-lg overflow-hidden">
                    <iframe id="preview-iframe" class="w-full" style="height: 600px;" frameborder="0"></iframe>
                </div>
            </div>

            <!-- Error State -->
            <div id="preview-error" class="hidden text-center py-8">
                <svg class="h-12 w-12 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p id="preview-error-message" class="mt-2 text-sm text-red-600"></p>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Store preview data
    window.previewData = { days, customMessage, template };
    
    // Load first preview
    loadPreview();
}

function closePreviewModal() {
    const modal = document.getElementById('preview-modal');
    if (modal) {
        modal.remove();
    }
}

function loadPreview() {
    const daysBefore = parseInt(document.getElementById('preview-days-select').value);
    const serviceId = {{ $service->id }};
    
    // Show loading
    document.getElementById('preview-loading').classList.remove('hidden');
    document.getElementById('preview-content').classList.add('hidden');
    document.getElementById('preview-error').classList.add('hidden');
    
    // Make AJAX request
    fetch('{{ route('admin.email-preview.reminder') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            service_id: serviceId,
            days_before: daysBefore,
            custom_message: window.previewData.customMessage,
            template: window.previewData.template
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide loading, show content
            document.getElementById('preview-loading').classList.add('hidden');
            document.getElementById('preview-content').classList.remove('hidden');
            
            // Update subject
            document.getElementById('preview-subject').textContent = data.subject;
            
            // Update iframe
            const iframe = document.getElementById('preview-iframe');
            iframe.srcdoc = data.html;
        } else {
            // Show error
            document.getElementById('preview-loading').classList.add('hidden');
            document.getElementById('preview-error').classList.remove('hidden');
            document.getElementById('preview-error-message').textContent = data.error;
        }
    })
    .catch(error => {
        console.error('Preview error:', error);
        document.getElementById('preview-loading').classList.add('hidden');
        document.getElementById('preview-error').classList.remove('hidden');
        document.getElementById('preview-error-message').textContent = 'Failed to load preview. Please try again.';
    });
}

function sendTestEmail() {
    const email = prompt('Enter email address to send test to:');
    if (!email) return;
    
    const daysBefore = parseInt(document.getElementById('preview-days-select').value);
    const serviceId = {{ $service->id }};
    
    // Disable button
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin h-4 w-4 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...';
    
    fetch('{{ route('admin.email-preview.send-test') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            email: email,
            service_id: serviceId,
            days_before: daysBefore,
            custom_message: window.previewData.customMessage,
            template: window.previewData.template
        })
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.error);
        }
    })
    .catch(error => {
        console.error('Send test error:', error);
        btn.disabled = false;
        btn.innerHTML = originalText;
        alert('Failed to send test email. Please try again.');
    });
}

// Close modal on background click
document.addEventListener('click', function(event) {
    const modal = document.getElementById('preview-modal');
    if (event.target === modal) {
        closePreviewModal();
    }
});
</script>
@endsection