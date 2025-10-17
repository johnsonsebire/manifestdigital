# Customer Dashboard - Implementation Guide

## Overview
The Customer Dashboard provides a self-service interface for customers to view and track their orders and projects without requiring admin intervention.

## Architecture

### Routes
All customer routes are prefixed with `/my` and named with the `customer.` prefix:

```
GET /my/orders                  → customer.orders.index
GET /my/orders/{order}          → customer.orders.show
GET /my/projects                → customer.projects.index
GET /my/projects/{project}      → customer.projects.show
```

**Protection**: All routes require authentication, email verification, and Customer role.

### Controllers

#### `App\Http\Controllers\Customer\OrderController`
Handles customer order viewing with proper authorization scoping.

**Methods:**
- `index()` - Lists customer's orders with filters:
  - Search by order number
  - Filter by status (pending, initiated, paid, processing, completed, cancelled)
  - Date range filtering (date_from, date_to)
  - Paginated results (15 per page)
  - Eager loads order items

- `show($order)` - Displays complete order details:
  - Order items with service details, variants, and customizations
  - Payment history with transaction status
  - Activity timeline showing order progress
  - Related project information (if exists)
  - Order summary and totals

**Authorization**: All queries are scoped to `auth()->id()` via `where('customer_id', auth()->id())`

#### `App\Http\Controllers\Customer\ProjectController`
Handles customer project viewing with proper authorization scoping.

**Methods:**
- `index()` - Lists customer's projects:
  - Filter by status (pending, active, on_hold, completed, cancelled)
  - Search by title
  - Shows completion percentage
  - Links to related orders
  - Paginated results (15 per page)

- `show($project)` - Displays comprehensive project details:
  - Project overview with progress metrics
  - Milestones with status tracking
  - Task list with priority and completion status
  - Team member roster
  - Project files with download links
  - Recent messages preview
  - Project timeline (start/end dates)

**Authorization**: Projects are accessed via order relationship: `whereHas('order', fn($q) => $q->where('customer_id', auth()->id()))`

### Views

All views follow the same design pattern:
- Dark mode support
- Responsive layout (mobile-first)
- Flux UI components
- Wire:navigate for SPA-like navigation
- Consistent status badges with color coding

#### 1. `resources/views/customer/orders/index.blade.php`
**Features:**
- Statistics dashboard (Total, Pending, Processing, Completed counts)
- Advanced filtering form (search, status, date range)
- Responsive order table
- Status badges with appropriate colors
- Empty state with helpful messaging
- Pagination

**URL Parameters:**
- `?search=` - Search by order number
- `?status=` - Filter by order status
- `?date_from=` - Filter orders from date
- `?date_to=` - Filter orders to date

#### 2. `resources/views/customer/orders/show.blade.php`
**Features:**
- Order header with number, date, and status
- Detailed order items list with:
  - Service name and category
  - Variant information
  - Customizations breakdown
  - Quantity, price, and subtotal
- Order totals (subtotal, discount, tax, total)
- Payment history with transaction details
- Activity timeline showing order progress
- Related project preview (if exists)
- Order summary sidebar
- Contact support section

#### 3. `resources/views/customer/projects/index.blade.php`
**Features:**
- Statistics dashboard (Total, Active, On Hold, Completed counts)
- Filter by status and search by title
- Project table showing:
  - Title and description excerpt
  - Related order number (clickable)
  - Progress bar with percentage
  - Status badge
  - Start/end dates
- Empty state messaging
- Pagination

#### 4. `resources/views/customer/projects/show.blade.php`
**Features:**
- Project header with title and status
- Progress overview cards (completion %, tasks, milestones, team size)
- Project description
- Milestones section with status tracking
- Tasks list with:
  - Completion checkboxes (visual only)
  - Priority badges
  - Due dates
  - Task descriptions
- Project files with download links
- Team members roster
- Recent messages preview
- Project details sidebar (dates, budget)
- Contact support section

### Navigation

The sidebar navigation (`resources/views/components/layouts/app/sidebar.blade.php`) includes a "My Account" section for customers:

```blade
@if(auth()->user()->hasRole('Customer'))
<flux:navlist.group :heading="__('My Account')" class="grid">
    <flux:navlist.item icon="shopping-bag" :href="route('customer.orders.index')" 
        :current="request()->routeIs('customer.orders.*')" wire:navigate>
        {{ __('My Orders') }}
    </flux:navlist.item>
    <flux:navlist.item icon="briefcase" :href="route('customer.projects.index')" 
        :current="request()->routeIs('customer.projects.*')" wire:navigate>
        {{ __('My Projects') }}
    </flux:navlist.item>
</flux:navlist.group>
@endif
```

## Security & Authorization

### Route Protection
All customer routes use middleware stack:
```php
['web', 'auth', 'verified']
```

### Controller-Level Authorization
**Orders**: Direct database scoping
```php
Order::where('customer_id', auth()->id())
```

**Projects**: Relationship-based scoping
```php
Project::whereHas('order', function($query) {
    $query->where('customer_id', auth()->id());
})
```

### View-Level Security
- No edit/delete actions available to customers
- Read-only access to all data
- Download links for files use Laravel's `Storage::url()`
- All links use `wire:navigate` for SPA navigation

## Data Flow

### Order Viewing Flow
1. Customer logs in and navigates to "My Orders"
2. `OrderController@index` fetches orders where `customer_id` matches auth user
3. Orders are displayed with filters and search
4. Customer clicks "View Details"
5. `OrderController@show` loads order with relationships (items, payments, activities, project)
6. Complete order details are displayed

### Project Viewing Flow
1. Customer navigates to "My Projects"
2. `ProjectController@index` fetches projects via order relationship
3. Projects are displayed with completion status
4. Customer clicks "View Details"
5. `ProjectController@show` loads project with all relationships (tasks, milestones, team, files, messages)
6. Comprehensive project view is displayed

## Status Badges

### Order Statuses
- **Pending**: Yellow badge
- **Initiated**: Blue badge
- **Paid**: Green badge
- **Processing**: Purple badge
- **Completed**: Green badge
- **Cancelled**: Red badge

### Project Statuses
- **Pending**: Yellow badge
- **Active**: Green badge
- **On Hold**: Orange badge
- **Completed**: Blue badge
- **Cancelled**: Red badge

### Task Priorities
- **High**: Red badge
- **Medium**: Yellow badge
- **Low**: Gray badge

### Task/Milestone Statuses
- **Pending**: Gray badge
- **In Progress**: Blue badge
- **Completed**: Green badge (with checkmark)

## UI Components Used

All views leverage the Flux UI component library:
- `<x-layouts.app>` - Main layout wrapper
- `<flux:navlist>` - Sidebar navigation
- Status badges with Tailwind CSS classes
- Responsive grid layouts
- Dark mode color schemes

## Testing Checklist

### Customer Order Views
- [ ] Customer can see only their own orders
- [ ] Search by order number works correctly
- [ ] Status filter works correctly
- [ ] Date range filter works correctly
- [ ] Order details page shows all items
- [ ] Payment information displays correctly
- [ ] Activity timeline shows order history
- [ ] Related project link works (if project exists)
- [ ] Pagination works correctly

### Customer Project Views
- [ ] Customer can see only their own projects
- [ ] Status filter works correctly
- [ ] Search by title works correctly
- [ ] Project progress percentage is accurate
- [ ] Tasks display with correct status
- [ ] Milestones show proper completion status
- [ ] Team members are listed correctly
- [ ] File downloads work
- [ ] Messages preview displays recent messages
- [ ] Pagination works correctly

### Navigation & UI
- [ ] "My Orders" link appears in sidebar for customers
- [ ] "My Projects" link appears in sidebar for customers
- [ ] Active route highlighting works correctly
- [ ] Wire:navigate provides smooth transitions
- [ ] Dark mode displays correctly
- [ ] Responsive layout works on mobile
- [ ] Empty states display helpful messages
- [ ] Contact support links work

### Security
- [ ] Customers cannot access other customers' orders
- [ ] Customers cannot access other customers' projects
- [ ] Unauthorized users are redirected to login
- [ ] Unverified emails are blocked
- [ ] Non-customer roles cannot access customer routes

## Future Enhancements

Potential improvements for the customer dashboard:

1. **Real-time Updates**: Integrate WebSockets for live order/project status updates
2. **Messaging**: Allow customers to send messages to project team
3. **File Uploads**: Enable customers to upload files to projects
4. **Notifications**: Email/SMS notifications for order and project updates
5. **Invoice Downloads**: Generate and download invoices
6. **Order Changes**: Allow customers to request order modifications
7. **Project Feedback**: Enable customers to provide feedback on completed projects
8. **Export Data**: Allow customers to export their order/project history
9. **Favorites**: Let customers save favorite services for quick reordering
10. **Payment Methods**: Manage saved payment methods for faster checkout

## Support

For customer support inquiries, users can contact:
- **Email**: support@manifestghana.com
- **Support Desk**: https://support.manifestghana.com

---

**Implementation Date**: October 17, 2025  
**Laravel Version**: 12.x  
**Status**: ✅ Completed
