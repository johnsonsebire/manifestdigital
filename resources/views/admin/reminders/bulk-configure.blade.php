@extends('admin.layouts.app')

@section('title', 'Bulk Reminder Configuration')

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
                <h1 class="text-3xl font-bold text-gray-900">Bulk Reminder Configuration</h1>
                <p class="mt-1 text-sm text-gray-600">Configure reminder schedules for multiple services at once</p>
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

    @if($services->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <p class="mt-2 text-gray-500">No subscription services found</p>
    </div>
    @else
    <form action="{{ route('admin.reminders.bulk.store') }}" method="POST">
        @csrf

        <!-- Quick Actions -->
        <div class="mb-6 bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Quick Actions</h3>
                    <p class="mt-1 text-xs text-gray-500">Apply settings to multiple services at once</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="selectAll()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Select All
                    </button>
                    <button type="button" onclick="deselectAll()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Deselect All
                    </button>
                    <button type="button" onclick="applyTemplate()" class="px-3 py-2 border border-indigo-300 rounded-lg text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                        Apply Template to Selected
                    </button>
                </div>
            </div>
        </div>

        <!-- Template Configuration -->
        <div class="mb-6 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Template Configuration</h3>
                <p class="mt-1 text-sm text-gray-600">Define a template schedule to apply to selected services</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3" id="template-days">
                    @php $templateDays = [30, 15, 10, 7, 5, 3, 1, 0]; @endphp
                    @foreach($templateDays as $day)
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer template-day">
                        <input type="checkbox" value="{{ $day }}" {{ in_array($day, [15, 10, 5, 0]) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm font-medium text-gray-900">{{ $day }}d</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Services List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Services ({{ $services->count() }})</h3>
                <p class="mt-1 text-sm text-gray-600">Configure reminder schedules for each service</p>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($services as $service)
                @php
                    $existing = $service->expirationReminders->first();
                    $defaultDays = $existing?->reminder_days_before ?? [15, 10, 5, 0];
                @endphp
                <div class="p-6 hover:bg-gray-50 service-row" data-service-id="{{ $service->id }}">
                    <div class="flex items-start">
                        <!-- Checkbox -->
                        <div class="flex items-center h-5 mt-1">
                            <input type="checkbox" name="services[{{ $loop->index }}][enabled]" value="1" class="service-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ $existing ? 'checked' : '' }}>
                            <input type="hidden" name="services[{{ $loop->index }}][service_id]" value="{{ $service->id }}">
                        </div>

                        <!-- Service Info -->
                        <div class="ml-4 flex-1">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $service->title }}</h4>
                                    @if($service->description)
                                    <p class="mt-1 text-xs text-gray-500">{{ Str::limit($service->description, 100) }}</p>
                                    @endif
                                </div>
                                
                                @if($existing)
                                <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Configured
                                </span>
                                @else
                                <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Not Configured
                                </span>
                                @endif
                            </div>

                            <!-- Reminder Days -->
                            <div class="mt-4 grid grid-cols-4 md:grid-cols-8 gap-2 days-container">
                                @foreach([30, 15, 10, 7, 5, 3, 1, 0] as $day)
                                <label class="flex items-center p-2 border border-gray-300 rounded cursor-pointer hover:bg-gray-50 {{ in_array($day, $defaultDays) ? 'bg-indigo-50 border-indigo-500' : '' }}">
                                    <input type="checkbox" name="services[{{ $loop->parent->index }}][days][]" value="{{ $day }}" {{ in_array($day, $defaultDays) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 text-xs">
                                    <span class="ml-1 text-xs font-medium text-gray-900">{{ $day }}d</span>
                                </label>
                                @endforeach
                            </div>

                            @if($existing)
                            <div class="mt-3 flex items-center gap-4">
                                <a href="{{ route('admin.reminders.configure-service', $service) }}" class="text-xs text-indigo-600 hover:text-indigo-900">
                                    Advanced Configuration
                                </a>
                                @if($existing->custom_message)
                                <span class="text-xs text-gray-500 italic">Has custom message</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.reminders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Configurations
            </button>
        </div>
    </form>
    @endif
</div>

<script>
function selectAll() {
    document.querySelectorAll('.service-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAll() {
    document.querySelectorAll('.service-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function applyTemplate() {
    // Get selected days from template
    const templateDays = [];
    document.querySelectorAll('#template-days input[type="checkbox"]:checked').forEach(input => {
        templateDays.push(input.value);
    });

    if (templateDays.length === 0) {
        alert('Please select at least one day in the template.');
        return;
    }

    // Apply to all selected services
    document.querySelectorAll('.service-row').forEach(row => {
        const checkbox = row.querySelector('.service-checkbox');
        if (checkbox && checkbox.checked) {
            // Uncheck all days first
            row.querySelectorAll('.days-container input[type="checkbox"]').forEach(input => {
                input.checked = false;
                input.closest('label').classList.remove('bg-indigo-50', 'border-indigo-500');
            });

            // Check template days
            templateDays.forEach(day => {
                const dayInput = row.querySelector(`.days-container input[value="${day}"]`);
                if (dayInput) {
                    dayInput.checked = true;
                    dayInput.closest('label').classList.add('bg-indigo-50', 'border-indigo-500');
                }
            });
        }
    });

    // Show success message
    const message = document.createElement('div');
    message.className = 'fixed top-4 right-4 bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg z-50';
    message.innerHTML = `
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm font-medium text-green-800">Template applied to selected services</p>
        </div>
    `;
    document.body.appendChild(message);
    setTimeout(() => message.remove(), 3000);
}

// Update label styling when checkboxes change
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.days-container input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                this.closest('label').classList.add('bg-indigo-50', 'border-indigo-500');
            } else {
                this.closest('label').classList.remove('bg-indigo-50', 'border-indigo-500');
            }
        });
    });

    document.querySelectorAll('#template-days input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                this.closest('label').classList.add('bg-indigo-50', 'border-indigo-500');
            } else {
                this.closest('label').classList.remove('bg-indigo-50', 'border-indigo-500');
            }
        });
    });
});
</script>
@endsection
