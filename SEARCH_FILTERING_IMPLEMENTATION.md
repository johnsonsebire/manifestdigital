# Search and Filtering Implementation Guide

## Overview
Comprehensive search and filtering has been implemented across all major modules in the Laravel Service Ordering & Project Management System.

## Features Implemented

### 1. Model Scopes (Reusable Query Methods)

#### Order Model (`app/Models/Order.php`)
- `scopeSearch($query, $search)` - Search by UUID, customer name, customer email
- `scopeDateRange($query, $from, $to)` - Filter by created_at date range
- `scopeStatus($query, $status)` - Filter by order status
- `scopePaymentStatus($query, $status)` - Filter by payment status
- `scopeForCustomer($query, $customerId)` - Filter by specific customer

#### Invoice Model (`app/Models/Invoice.php`)
- `scopeSearch($query, $search)` - Search by invoice number, customer name, customer email, order UUID
- `scopeDateRange($query, $from, $to)` - Filter by invoice_date range
- `scopeAmountRange($query, $min, $max)` - Filter by total_amount range
- `scopeForCustomer($query, $customerId)` - Filter by specific customer

#### Project Model (`app/Models/Project.php`)
- `scopeSearch($query, $search)` - Search by title, description, UUID, order UUID, client name, client email
- `scopeDateRange($query, $from, $to)` - Filter by start_date and end_date range
- `scopeStatus($query, $status)` - Filter by project status
- `scopeForClient($query, $clientId)` - Filter by specific client

#### FormSubmission Model (`app/Models/FormSubmission.php`)
- `scopeSearch($query, $search)` - Search in JSON data, user name, user email, form title
- `scopeDateRange($query, $from, $to)` - Filter by submission date range
- `scopeForForm($query, $formId)` - Filter by specific form

### 2. Controller Enhancements

#### OrderController
**Filter Parameters:**
- `search` - Keyword search (UUID, customer name, email)
- `status` - Order status (pending, approved, paid, in_progress, completed, cancelled)
- `payment_status` - Payment status (unpaid, partial, paid)
- `customer_id` - Specific customer filter
- `date_from` - Start date
- `date_to` - End date
- `sort_by` - Sort column (created_at, total, customer_name)
- `sort_order` - Sort direction (asc, desc)

**Statistics:**
- Total orders
- Pending orders
- Approved orders
- Paid orders
- In progress orders
- Completed orders
- Total revenue

#### InvoiceController
**Filter Parameters:**
- `search` - Keyword search (invoice number, customer, order)
- `status` - Invoice status (draft, sent, paid, partial, overdue, cancelled)
- `customer_id` - Specific customer filter
- `date_from` - Start date (invoice_date)
- `date_to` - End date (invoice_date)
- `amount_min` - Minimum total amount
- `amount_max` - Maximum total amount
- `sort_by` - Sort column (invoice_date, total_amount, etc.)
- `sort_order` - Sort direction (asc, desc)

**Statistics:**
- Total invoices
- Draft invoices
- Sent invoices
- Paid invoices
- Overdue invoices
- Total outstanding balance

#### ProjectController
**Filter Parameters:**
- `search` - Keyword search (title, description, UUID, order, client)
- `status` - Project status (pending, planning, in_progress, on_hold, completed)
- `client_id` - Specific client filter
- `team_member` - Filter by assigned team member
- `date_from` - Start date filter
- `date_to` - End date filter
- `sort_by` - Sort column (created_at, title, etc.)
- `sort_order` - Sort direction (asc, desc)

**Statistics:**
- Total projects
- Pending projects
- Planning projects
- In progress projects
- On hold projects
- Completed projects

#### FormSubmissionController
**Filter Parameters:**
- `search` - Keyword search (submission data, user, form)
- `form_id` - Specific form filter
- `date_from` - Start date
- `date_to` - End date
- `sort_by` - Sort column (created_at, etc.)
- `sort_order` - Sort direction (asc, desc)

**Statistics:**
- Total submissions
- Today's submissions
- This week's submissions
- This month's submissions

### 3. Database Indexes for Performance

Created indexes on frequently queried columns:

#### Orders Table
- `customer_id` (single)
- `status` (single)
- `payment_status` (single)
- `created_at` (single)
- `customer_id, status` (composite)

#### Projects Table
- `client_id` (existing)
- `order_id` (existing)
- `status` (existing)
- `start_date` (new)
- `end_date` (new)
- `client_id, status` (composite, new)

#### Form Submissions Table
- `form_id` (existing)
- `user_id` (existing)
- `created_at` (existing)
- `form_id, created_at` (composite, new)

#### Services Table
- `visible, available` (composite, new)

### 4. View Enhancements

All index views now include:
- **Statistics cards** - Quick overview of key metrics
- **Filter form** - Multi-criteria search and filter options
- **Clear filters button** - Reset all filters
- **Query string preservation** - Filters maintained across pagination
- **Responsive design** - Mobile-friendly filter forms

## Usage Examples

### Searching Orders
```php
// In controller
$orders = Order::search($request->search)
    ->status($request->status)
    ->paymentStatus($request->payment_status)
    ->forCustomer($request->customer_id)
    ->dateRange($request->date_from, $request->date_to)
    ->orderBy($sortBy, $sortOrder)
    ->paginate(15)
    ->withQueryString();
```

### Searching Invoices
```php
$invoices = Invoice::search($request->search)
    ->where('status', $request->status)
    ->forCustomer($request->customer_id)
    ->dateRange($request->date_from, $request->date_to)
    ->amountRange($request->amount_min, $request->amount_max)
    ->orderBy($sortBy, $sortOrder)
    ->paginate(15)
    ->withQueryString();
```

### Searching Projects
```php
$projects = Project::search($request->search)
    ->status($request->status)
    ->forClient($request->client_id)
    ->dateRange($request->date_from, $request->date_to)
    ->orderBy($sortBy, $sortOrder)
    ->paginate(15)
    ->withQueryString();
```

## API Endpoints

All search endpoints support GET requests with query parameters:

### Orders
```
GET /admin/orders?search=john&status=paid&customer_id=5&date_from=2025-01-01&date_to=2025-12-31&sort_by=created_at&sort_order=desc
```

### Invoices
```
GET /admin/invoices?search=INV-2025&status=sent&customer_id=5&date_from=2025-01-01&amount_min=100&amount_max=5000
```

### Projects
```
GET /admin/projects?search=website&status=in_progress&client_id=5&team_member=3&date_from=2025-01-01
```

### Form Submissions
```
GET /admin/form-submissions?search=john&form_id=1&date_from=2025-01-01&date_to=2025-12-31
```

## Performance Optimization

1. **Database Indexes**: Added indexes on all frequently queried columns
2. **Eager Loading**: All index queries use `with()` to prevent N+1 problems
3. **Query Scopes**: Reusable scopes prevent query duplication
4. **Pagination**: All results are paginated (15-20 per page)
5. **Query String Preservation**: `withQueryString()` maintains filters across pages

## Best Practices

1. **Always use scopes** instead of inline where clauses for reusability
2. **Check for filled parameters** before applying filters (`$request->filled()`)
3. **Preserve query strings** in pagination for better UX
4. **Provide clear filters** button to reset all parameters
5. **Show statistics** to give context about filtered data
6. **Use composite indexes** for commonly combined filters (e.g., customer_id + status)

## Future Enhancements

1. **Saved Searches**: Allow users to save frequently used filter combinations
2. **Export Filtered Results**: Add export to CSV/Excel for filtered data
3. **Advanced Search**: Add OR conditions, NOT conditions, range operators
4. **Full-Text Search**: Use MySQL full-text search for better text matching
5. **Search History**: Track and suggest recent searches
6. **Bulk Actions**: Allow bulk operations on filtered results

## Migration Files

- `2025_10_17_052234_add_search_indexes_to_tables.php` - Adds performance indexes

## Modified Files

### Models
- `app/Models/Order.php` - Added search and dateRange scopes
- `app/Models/Invoice.php` - Added search, dateRange, amountRange scopes
- `app/Models/Project.php` - Added search and dateRange scopes
- `app/Models/FormSubmission.php` - Added search, dateRange, forForm scopes

### Controllers
- `app/Http/Controllers/Admin/OrderController.php` - Enhanced index with filters
- `app/Http/Controllers/Admin/InvoiceController.php` - Enhanced index with filters
- `app/Http/Controllers/Admin/ProjectController.php` - Enhanced index with filters
- `app/Http/Controllers/Admin/FormSubmissionController.php` - Enhanced index with filters

### Views
- `resources/views/admin/orders/index.blade.php` - Added comprehensive filter form
- `resources/views/admin/form-submissions/index.blade.php` - Added filter form and statistics

## Testing

To test the search functionality:

1. Create test data using seeders or factories
2. Visit the index pages (orders, invoices, projects, form submissions)
3. Use the filter forms to search and filter
4. Verify that:
   - Filters work individually and in combination
   - Pagination maintains filters
   - Clear filters button resets to default view
   - Statistics update correctly
   - URLs are shareable (contain query parameters)

## Support

For questions or issues with search and filtering, refer to:
- Laravel Query Builder documentation
- Laravel Eloquent Scopes documentation
- This implementation guide
