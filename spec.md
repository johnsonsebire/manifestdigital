# Laravel Service Ordering & Project Management — Specification

Purpose: Implement a front-end ordering flow for services/packages, back-end order management for staff, and an integrated project-management system that maps orders → projects → team assignments → client collaboration. The system must support order upgrades/changes, flexible pricing, attachments, comments, private team communications, client-visible progress, notifications, and audit/activity logs. Additionally, the system must support product categories and sub-categories for better organization, expanded product types, AI integration for enhanced features (e.g., automated recommendations, intelligent project task generation, or AI-assisted client support), and ensure all products have a unique slug and public URL for detailed viewing and ordering. Not all products need to be listed in the main pricing table; visibility and availability can be controlled per product to accommodate unlisted or internal offerings.

---

High-level concepts

Service / Product: What appears in the pricing table (if visible). Can be a fixed package, subscription, or custom quote. All products include a slug for generating public URLs (e.g., /services/{slug}) where users can read about the product, its features, and other relevant details, and initiate orders. Not all products are intended for the main pricing table; some may be unlisted but accessible via direct URL or internal/admin views.

Category / Sub-Category: Hierarchical organization for products. Categories can have parent-child relationships to support sub-categories, aiding in navigation, filtering, and AI-driven recommendations.

Product Type: Expanded enum to categorize products beyond basic billing (e.g., package, subscription, custom, one_time, ai_enhanced, consulting, add_on). This influences how products are displayed, priced, and integrated with AI features.

Order: Placed by a customer (guest or authenticated). Captures purchased service(s), pricing at time of purchase, status, payment record, and linkage to a Project when the order is confirmed/accepted.

Project: Work item created from an order. Contains tasks, milestones, files, messages, time entries, activity logs, and client-visible progress. AI integration can auto-generate tasks or milestones based on product metadata.

Team / Assignment: Staff users assigned to projects or tasks (individuals or groups).

Private Team Threads: Internal (staff-only) communications attached to a project.

Client Threads: Client ↔ Staff messages visible to the client.

Upgrade / Change Flow: Ability to change an order after placement (upgrade/downgrade/customize), generate change requests, adjust invoices, and preserve history.

Billing / Invoicing: Records of payments, invoices, refunds, and outstanding balances.

AI Integration: Incorporate AI capabilities such as product recommendations during browsing (e.g., based on user history or category), automated task creation in projects (e.g., using AI to break down product features into tasks), intelligent notifications (e.g., predictive alerts for delays), or AI-assisted messaging (e.g., draft suggestions for client responses). Use Laravel-compatible AI services (e.g., integrations with OpenAI or similar via APIs) where appropriate, with configurable settings in metadata.

---

Core Models (with important fields)

> Use snake_case column names by Laravel convention. Add timestamps() to most tables.

1. Category (new for categories and sub-categories)

id, uuid

title (string)

slug (string)

parent_id (nullable, self-referential for sub-categories)

description (text, nullable)

metadata (json) — for AI-driven category features or filters

visible (boolean)

order (integer) — for sorting

Relationships: belongsTo(Category, 'parent_id'), hasMany(Category, 'parent_id' as children), belongsToMany(Service)

2. Service (or Product)

id, uuid

title (string)

slug (string) — unique, used for public URL (e.g., /services/{slug})

short_description (text)

long_description (text, nullable)

type (enum: package, subscription, custom, one_time, ai_enhanced, consulting, add_on) — expanded for more product types

price (decimal 10,2)

currency (string, 3)

billing_interval (nullable: monthly, yearly, one_time)

metadata (json) — for features, limits, other structured spec, including AI-specific configs (e.g., ai_model_version)

available (boolean) — controls if purchasable

visible (boolean) — controls if shown in pricing table or public listings

created_by (user_id)

Relationships: hasMany(ServiceVariant), hasMany(ServicePriceHistory), belongsToMany(Category)

3. ServiceVariant (optional)

id, service_id

name (e.g., Basic, Pro)

price (decimal)

features (json)

4. Order

id, uuid

customer_id (nullable if guest; else users.id)

customer_email, customer_name (copy snapshot)

orderable_type, orderable_id (polymorphic — service/package or custom quote)

quantity (int)

subtotal (decimal)

discount (decimal)

tax (decimal)

total (decimal)

currency (string)

status (enum) — e.g., pending, initiated, paid, failed, processing, on_hold, cancelled, completed, refunded

payment_status (enum: unpaid, paid, partially_paid, refunded)

payment_method (string)

payment_reference (string) — gateway id

notes (text)

assigned_project_id (nullable)

metadata (json) — store snapshot of purchased items/features, including category and type info

placed_at (timestamp)

Relationships: belongsTo(User,'customer'), hasMany(OrderItem), hasMany(Payment), hasOne(Project)

5. OrderItem

id, order_id

service_id (nullable)

title (snapshot)

unit_price, quantity, line_total

metadata (json) — include product type, category slugs, and AI flags if applicable

6. OrderChangeRequest (for upgrades/changes)

id, order_id

requested_by (user_id)

type (enum: upgrade, downgrade, custom_change)

old_snapshot (json)

new_snapshot (json)

proposed_amount (decimal)

status (enum: pending, approved, rejected, applied)

reviewed_by (user_id)

reviewed_at

7. Payment

id, order_id

amount, currency

method (string)

gateway_response (json)

status (initiated, succeeded, failed, refunded)

reference (string)

paid_at (timestamp)

8. Project

id, uuid

order_id (nullable) — primary source

title (string)

description (text)

client_id (user_id)

status (enum e.g., planning, in_progress, on_hold, complete, archived)

start_date, end_date, deadline

estimated_hours, spent_hours (decimal)

visibility (enum: private, client, public) — controls what client sees

settings (json) — project-level config, including AI automation flags (e.g., auto_task_generation)

Relationships: hasMany(Task), hasMany(Milestone), hasMany(File), hasMany(Message), hasMany(ActivityLog), belongsToMany(User,project_user)

9. Task

id, project_id

title, description

status (todo, in_progress, review, done)

priority (int)

assignee_id (user_id, nullable)

reporter_id (user_id)

due_date, start_date

estimated_hours, spent_hours

order_item_id (nullable) — if task maps to particular order item/feature

metadata (json) — for AI-generated tasks (e.g., ai_source: 'generated_from_product_features')

10. Milestone

id, project_id

title, description, due_date, status (open, completed)

11. ProjectMessage (client-facing)

id, project_id

sender_id (user)

body (text)

is_internal (boolean) — false for client-facing, true for staff-only

attachments via polymorphic File

read_by (json array or pivot table) — track reads by participants

metadata (json) — for AI-assisted drafts (e.g., ai_draft: true)

12. ProjectFile (attachments)

id, model_type, model_id (polymorphic)

uploader_id

path, original_name, mime, size

13. ActivityLog

id, project_id (nullable), user_id, type, meta (json), created_at

Use for audit trails (order status change, task completed, message sent, AI actions like auto-task creation)

14. TimeEntry (optional)

id, task_id, user_id, minutes, notes, started_at, stopped_at

15. ProjectUser pivot

project_id, user_id, role (e.g., manager, developer, designer, viewer), notifications_enabled

16. Notification subsystem

Use Laravel Notifications with channels (mail, database, in-app, SMS/webhook)

Key notifications: Order placed, Payment succeeded/failed, Order approved, Project created, Task assigned, Milestone due, Message received (client/staff), Change request created/approved/rejected. Include AI-triggered notifications (e.g., AI-suggested upgrades based on project progress).

---

Relationships Summary (ER highlights)

User hasMany Order, Project (as client), Task (as assignee/reporter)

Category hasMany Service (via pivot), hasMany Category (children)

Service belongsToMany Category

Order -> hasOne Project (created when accepted)

Project -> hasMany Task, Milestone, Message, File, ActivityLog

Task -> belongsTo Project and belongsTo User (assignee)

---

Order lifecycle & state transitions

1. Browsing: Visitor views Service pages (via categories/sub-categories or direct slug URLs) and pricing table (only visible products). AI can provide personalized recommendations based on browsing history or categories.

2. Cart/Initiate: Visitor selects service/variant (from public URL or category navigation), adds to cart, and initiates checkout.

3. Order pending/initiated: Order record created with pending status while payment is processed.

4. Payment succeeded: payment_status = paid, order.status = paid (or processing depending on workflow). Trigger OrderPlaced event.

5. Staff Review (optional): For custom services or manual approval workflows, staff reviews and sets order.status = processing or on_hold or approved.

6. Project creation: When order is approved, a Project is created (or linked) and order.assigned_project_id is set. AI can auto-generate initial tasks/milestones from product metadata. Notify client with project link.

7. Work in progress: Tasks & milestones are created (manually or via AI), assignments made. Activity is logged. Client receives updates.

8. Upgrades/Change: Use OrderChangeRequest. If approved, create new invoice / balance due. Update order and optionally create a new OrderItem or create a replacement_order record to preserve history. AI can suggest upgrades based on project data.

9. Completion: Project marked complete, invoice settled; order.status = completed.

10. Post-completion actions: Support tickets, warranty tasks, or archived project.

---

API & Routes (suggested)

Frontend (public) routes

GET /categories — list categories and sub-categories

GET /categories/{slug} — category detail with filtered products

GET /services — list services (filtered by visible/available, categories, types)

GET /services/{slug} — service detail (public URL for reading features, details, and ordering)

POST /cart — add item to cart (session-backed)

POST /checkout — create order & initiate payment

GET /orders/{uuid} — view order (for authenticated customers with access)

POST /orders/{uuid}/payment/callback — payment gateway webhook

Customer dashboard (authenticated)

GET /dashboard/orders — list their orders

GET /dashboard/projects — list projects

GET /dashboard/projects/{uuid} — project detail (messages, progress, files, AI-suggested actions)

POST /dashboard/projects/{uuid}/messages — client message (with optional AI draft assistance)

GET /dashboard/invoices — invoices/payments

Staff/Admin routes (protected)

GET /admin/orders — filter by status, customer, date

GET /admin/orders/{id}

POST /admin/orders/{id}/approve — approve & create project (with AI task generation option)

POST /admin/orders/{id}/change-request — propose change

POST /admin/projects — create/edit project

POST /admin/projects/{id}/assign — assign user(s)

POST /admin/projects/{id}/tasks — create task (manual or AI-generated)

GET /admin/reports/orders — metrics

GET /admin/categories — manage categories/sub-categories

GET /admin/services — manage services, including unlisted ones

---

Events, Jobs & Notifications

Events: OrderPlaced, PaymentSucceeded, PaymentFailed, OrderApproved, ProjectCreated, TaskAssigned, MessagePosted, ChangeRequestCreated, ChangeRequestApproved. Add AI-specific events like AiTaskGenerated, AiRecommendationSent.

Jobs: SendOrderEmails, GenerateInvoicePDF, SyncPaymentStatusJob (for async gateway checks), SendProjectDigest (daily/weekly updates to client/staff), AiGenerateTasksJob, AiRecommendUpgradesJob.

Notifications: Implement via Notifications (mail + database) and real-time via Pusher / Laravel Websockets for in-app updates. Include AI-triggered notifications.

---

Security & Access Control

Use Policies and Gates for Order, Project, Task, Message, File, Category, Service.

Example: ServicePolicy@view should check visibility; unlisted services accessible only via direct slug if available is true, or admin-only.

ProjectPolicy@view should check project visibility and whether user is the client, assigned staff, or admin.

Files: store on S3 or protected disk; serve via signed URLs or stream through controller with ACL checks.

Validation: strict validation on any price/amount sent from client — never trust client prices; recalc on server. For AI integrations, validate API responses to prevent injection.

---

Data Integrity & Auditing

Snapshot pricing data into Order and OrderItem so historical prices are preserved.

Keep a ServicePriceHistory if prices change to aid reporting.

Use ActivityLog to store immutable records of status changes, approvals, and AI actions.

---

Payments

Abstract payment gateway behind a PaymentGateway interface/service so multiple providers can be plugged in (e.g., Stripe, PayPal, Paystack). Use webhooks for reliable updates.

Support partial payments, deposits, and installments: store payment_schedule in metadata if needed.

---

Upgrade / Change Implementation Patterns

Pattern A — Change Request Workflow (preferred for manual reviews)

1. Staff or client creates OrderChangeRequest linking to order with proposed new_snapshot and proposed_amount. AI can suggest changes based on usage data.

2. Staff reviews → approves/rejects. If approved, generate invoice for the difference, or create a credit note.

3. When paid, update OrderItem/Order snapshot and push new ActivityLog entry.

Pattern B — Versioned Orders (programmatic upgrades)

Create order_versions — each version stores full snapshot. When upgrade happens, new version is created and previous version remains for audit. AI can automate version comparisons.

---

Project Management UX considerations

Client view: read-only timeline of milestones, file exchange, messages, and a simple progress bar & timesheet summary. Include AI-generated insights (e.g., estimated completion time).

Staff internal view: kanban board, task lists, private threads (not visible to client), assignment controls, time tracking, AI suggestion panels (e.g., "Generate tasks from product features").

Real-time indicators: task updates, new messages, file uploads via websockets.

Notifications: digest preferences at project level; ability to mute certain updates, with AI prioritizing important ones.

---

Background Jobs and Scaling

Queue long-running tasks: invoice generation, large file processing, nightly digests, AI processing jobs (e.g., task generation via external API).

Paginate API responses and use eager loading to avoid N+1.

Use caching for frequently read services/pricing data, categories, and AI configs.

---

Testing

Unit tests for models and policies, including category hierarchies and AI integrations.

Feature tests for the order checkout flow including webhooks, payment callbacks, and category-based browsing.

Integration tests for order→project creation, change request approval flows, and AI task generation.

---

Migration & Seed Suggestions

Seed Category with hierarchical examples (e.g., "Development" as parent, "Web Apps" as sub-category).

Seed Service with current pricing table, including unlisted ones (visible=false), various types, and category assignments.

Add admin/staff user seed.

Create factories for Order, Project, Task, User, Category, Service for tests.

---

Suggested Implementation Roadmap (phased)

1. Phase 1 — Core ordering: Category, Service, Order, OrderItem, Payment models; checkout flow (with category navigation and slug-based URLs); webhook handling; customer dashboard order list.

2. Phase 2 — Staff & approval: Admin order listing, approve/assign, create Project from order.

3. Phase 3 — Project management: Project, Task, Milestone, ProjectMessage, files, activity log. Integrate initial AI for task generation.

4. Phase 4 — Upgrades & invoicing: OrderChangeRequest, invoices, partial payments, versioning. Add AI recommendations.

5. Phase 5 — Polishing: notifications, websockets, reports, testing, hardening, full AI features.

---

Example: Minimal orders migration (suggested)

Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
    $table->string('customer_name')->nullable();
    $table->string('customer_email')->nullable();
    $table->decimal('subtotal', 12, 2);
    $table->decimal('discount', 12, 2)->default(0);
    $table->decimal('tax', 12, 2)->default(0);
    $table->decimal('total', 12, 2);
    $table->string('currency', 3)->default('USD');
    $table->string('status')->default('pending');
    $table->string('payment_status')->default('unpaid');
    $table->json('metadata')->nullable();
    $table->foreignId('assigned_project_id')->nullable()->constrained('projects')->nullOnDelete();
    $table->timestamps();
});

Add similar migrations for categories:

Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->string('title');
    $table->string('slug')->unique();
    $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
    $table->text('description')->nullable();
    $table->json('metadata')->nullable();
    $table->boolean('visible')->default(true);
    $table->integer('order')->default(0);
    $table->timestamps();
});

And pivot for category_service:

Schema::create('category_service', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
