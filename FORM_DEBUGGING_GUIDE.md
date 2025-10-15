# Form Submission Debugging Guide

## Issue: Form disappears on submit, no success/error messages, 0 submissions recorded

### Debugging Steps:

1. **Check if the form submission route is working**:
   ```bash
   # Test the route exists
   php artisan route:list --path=forms/book-a-call/submit
   ```

2. **Check browser network tab**:
   - Open browser developer tools (F12)
   - Go to Network tab
   - Submit the form
   - Look for the POST request to `/forms/book-a-call/submit`
   - Check the response status (should be 200 or 302)
   - Check if there are any errors

3. **Check Laravel logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```
   Then submit the form and watch for errors

4. **Test form submission manually**:
   ```bash
   curl -X POST http://your-domain.test/forms/book-a-call/submit \
     -H "Content-Type: application/x-www-form-urlencoded" \
     -d "firstName=Test&lastName=User&email=test@example.com&phone=1234567890&meetingType=discovery&preferredDate=2025-10-20&preferredTime=09:00&timezone=GMT&projectDetails=Test"
   ```

5. **Check for JavaScript interference**:
   - Look in the browser console for errors
   - Check if any JavaScript is preventing form submission
   - Try disabling JavaScript and submit

### Common Issues:

1. **CSRF Token Missing**: The form needs `@csrf` directive
   - ✅ Already added in form-section.blade.php

2. **Route Not Registered**: The route might not exist
   - ✅ Route exists: `POST /forms/{slug}/submit`

3. **JavaScript Preventing Submission**:
   - Check browser console for errors
   - Look for `preventDefault()` calls in scripts.js

4. **Validation Errors Not Displayed**:
   - Check if form has proper error display (`@error` directives)
   - ✅ Already added in form-section.blade.php

5. **Session/Flash Messages Not Persisting**:
   - Form might be submitting via AJAX
   - Check if request expects JSON

### Current Status:

**Form Configuration**:
- Form ID: 3
- Slug: `book-a-call`
- Fields: 9
- Active: Yes
- Store Submissions: Yes
- Send Notifications: Yes

**Route Status**:
```
POST forms/{slug}/submit ........... forms.submit › FormSubmissionController@submitForm
```

**Next Steps to Try**:

1. **Add console logging to see if form is submitting**:
   Add this to your form:
   ```html
   <script>
   document.getElementById('bookingForm').addEventListener('submit', function(e) {
       console.log('Form submitting...');
       console.log('Form action:', this.action);
       console.log('Form method:', this.method);
   });
   </script>
   ```

2. **Check if form is actually submitting**:
   - Open browser console
   - Submit form
   - Check if you see the console.log messages
   - Check Network tab for the POST request

3. **Verify the form action URL**:
   The form action should be: `http://your-domain.test/forms/book-a-call/submit`
   
4. **Test with a simple form**:
   Create a minimal test form to isolate the issue:
   ```html
   <form action="{{ route('forms.submit', 'book-a-call') }}" method="POST">
       @csrf
       <input type="text" name="firstName" value="Test" required>
       <input type="text" name="lastName" value="User" required>
       <input type="email" name="email" value="test@test.com" required>
       <input type="tel" name="phone" value="1234567890" required>
       <select name="meetingType" required>
           <option value="discovery">Discovery Call</option>
       </select>
       <input type="date" name="preferredDate" value="2025-10-20" required>
       <select name="preferredTime" required>
           <option value="09:00">09:00 AM</option>
       </select>
       <select name="timezone" required>
           <option value="GMT">GMT</option>
       </select>
       <textarea name="projectDetails">Test project</textarea>
       <button type="submit">Submit</button>
   </form>
   ```

### Logging Added:

I've added logging to the FormSubmissionController to help debug:
- Log when submission attempt starts
- Log when form is found
- Log when form is not active

Check the logs with:
```bash
tail -f storage/logs/laravel.log | grep "Form submission"
```

Then try submitting the form.
