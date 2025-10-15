<x-layouts.app :title="__('Create Form')">
    <div class="p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Create New Form</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Create a new form for your website</p>
        </header>
        
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            <form action="{{ route('admin.forms.store') }}" method="POST">
                @csrf
                
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Form Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Internal name for identifying the form</p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Form Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Public title displayed on the form</p>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="slug" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                Slug 
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">(leave empty to auto-generate)</span>
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="submit_button_text" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Submit Button Text</label>
                            <input type="text" name="submit_button_text" id="submit_button_text" value="{{ old('submit_button_text', 'Submit') }}" 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('submit_button_text')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="success_message" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Success Message</label>
                            <textarea name="success_message" id="success_message" rows="2"
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">{{ old('success_message', 'Thank you for your submission!') }}</textarea>
                            @error('success_message')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="success_page_url" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Success Page URL (Optional)</label>
                            <input type="url" name="success_page_url" id="success_page_url" value="{{ old('success_page_url') }}"
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                placeholder="https://example.com/thank-you">
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">If provided, users will be redirected to this page after successful submission instead of showing the success message on the same page.</p>
                            @error('success_page_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="hidden" name="store_submissions" value="0">
                                <input type="checkbox" name="store_submissions" id="store_submissions" value="1" {{ old('store_submissions', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 border-zinc-300 rounded focus:ring-primary-500">
                                <label for="store_submissions" class="ml-3 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Store Submissions
                                </label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="hidden" name="send_notifications" value="0">
                                <input type="checkbox" name="send_notifications" id="send_notifications" value="1" {{ old('send_notifications') ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 border-zinc-300 rounded focus:ring-primary-500">
                                <label for="send_notifications" class="ml-3 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Send Notifications
                                </label>
                            </div>
                            
                            <div id="notification_email_container" class="ml-7 {{ old('send_notifications') ? '' : 'hidden' }}">
                                <label for="notification_email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Notification Email</label>
                                <input type="email" name="notification_email" id="notification_email" value="{{ old('notification_email') }}"
                                    class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                @error('notification_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 border-zinc-300 rounded focus:ring-primary-500">
                                <label for="is_active" class="ml-3 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Active
                                </label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="hidden" name="requires_login" value="0">
                                <input type="checkbox" name="requires_login" id="requires_login" value="1" {{ old('requires_login') ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 border-zinc-300 rounded focus:ring-primary-500">
                                <label for="requires_login" class="ml-3 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Requires Login
                                </label>
                            </div>
                            
                            <div>
                                <label for="recaptcha_status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">reCAPTCHA</label>
                                <select name="recaptcha_status" id="recaptcha_status"
                                    class="mt-1 block w-full py-2 px-3 border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    <option value="disabled" {{ old('recaptcha_status') == 'disabled' ? 'selected' : '' }}>Disabled</option>
                                    <option value="v2" {{ old('recaptcha_status') == 'v2' ? 'selected' : '' }}>reCAPTCHA v2</option>
                                    <option value="v3" {{ old('recaptcha_status') == 'v3' ? 'selected' : '' }}>reCAPTCHA v3</option>
                                </select>
                                @error('recaptcha_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-700 flex justify-end">
                    <div class="flex">
                        <a href="{{ route('admin.forms.index') }}" class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 shadow-sm text-sm font-medium rounded-md text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 me-3">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Create Form
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendNotifications = document.getElementById('send_notifications');
            const notificationEmailContainer = document.getElementById('notification_email_container');
            
            sendNotifications.addEventListener('change', function() {
                notificationEmailContainer.classList.toggle('hidden', !this.checked);
            });
        });
    </script>
</x-layouts.app>