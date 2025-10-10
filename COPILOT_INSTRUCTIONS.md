# Copilot Instructions: Frontend Website Implementation

## Project Overview
Convert an existing Bootstrap HTML/CSS/JS template (manifest-template) into a Laravel 12 application with identical layout, functionality, and features.

## Project Structure
- Template Source: `/manifest-template/`
- Laravel App: `/web-app/`
- Frontend Routes: `/web-app/routes/frontend.php`
- Views Directory: `/web-app/resources/views/`
- Components Directory: `/web-app/resources/views/components/`

## Technology Stack
- Laravel 12
- Bootstrap 5.3.2
- Alpine.js
- Livewire/Volt
- Font Awesome 6.4.2
- Anime.js
- Custom CSS/JS

## Priority Pages for Implementation
1. Projects Page
2. Book a Call Page
3. Request a Quote Page

## Implementation Guidelines

### 1. General Rules
- Maintain exact visual match with template
- Preserve all animations and interactions
- Keep existing Bootstrap and custom CSS
- Use Laravel blade components
- Implement responsive behavior
- Optimize for performance

### 2. Component Strategy
- Reuse existing components when available
- Create new components only when needed
- Follow established component naming conventions
- Maintain component documentation
- Ensure component reusability

### 3. JavaScript Management
- Move page-specific JS to separate files
- Use Laravel Mix for asset compilation
- Maintain all template functionalities
- Document JS dependencies
- Optimize loading sequence

### 4. Page-Specific Requirements

#### Projects Page
- Grid layout with filtering
- Search functionality
- Infinite scroll
- Category filtering
- Project card animations
- Stats section

#### Book a Call Page
- Calendar integration
- Time slot selection
- Form validation
- Booking confirmation
- Email notifications

#### Request a Quote Page
- Multi-step form
- Service selection cards
- File upload capability
- Progress tracking
- Form validation
- Price calculation

### 5. Quality Standards
- Exact pixel-perfect match with template
- All interactive elements must function
- Responsive on all screen sizes
- Cross-browser compatibility
- Performance optimization
- Proper error handling
- Form validation messages
- Loading states
- Success/Error states

### 6. Code Organization
```plaintext
web-app/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── pages/
│   │   │   ├── projects.blade.php
│   │   │   ├── book-a-call.blade.php
│   │   │   └── request-quote.blade.php
│   │   └── components/
│   │       ├── common/
│   │       ├── projects/
│   │       ├── booking/
│   │       └── quote/
│   ├── js/
│   │   ├── projects.js
│   │   ├── booking.js
│   │   └── quote.js
│   └── css/
│       └── styles.css
```

### 7. Component Creation Steps
1. Study template implementation
2. Check for existing components
3. Identify reusable parts
4. Create new components if needed
5. Document component usage
6. Test in isolation
7. Integrate with page

### 8. Testing Requirements
- Visual comparison with template
- Responsive testing
- Functionality testing
- Form validation
- Error handling
- Loading states
- Success states
- Browser compatibility

### 9. Performance Requirements
- Optimize images
- Minimize JS/CSS
- Lazy loading where appropriate
- Efficient component loading
- Cache management
- Asset versioning

### 10. Documentation
- Component usage examples
- Required props
- Dependencies
- Event handlers
- State management
- Error scenarios
- Customization options

## Implementation Order
1. Projects Page
   - Grid component
   - Filter component
   - Search functionality
   - Infinite scroll
   - Stats section

2. Request a Quote Page
   - Multi-step form
   - Service cards
   - File upload
   - Progress tracking
   - Form validation

3. Book a Call Page
   - Calendar component
   - Time slots
   - Form handling
   - Confirmation flow

## Progress Tracking
- [x] Layout template
- [x] Common components
- [x] Route setup
- [ ] Projects page
- [ ] Request a Quote page
- [ ] Book a Call page

## Final Checklist
- [ ] Visual match with template
- [ ] All functionality working
- [ ] Responsive design
- [ ] Performance optimization
- [ ] Documentation complete
- [ ] Testing complete
- [ ] Cross-browser compatibility
- [ ] Error handling
- [ ] Loading states
- [ ] Success states