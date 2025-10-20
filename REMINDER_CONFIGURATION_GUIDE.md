# Reminder Configuration Quick Start Guide

## Overview
The reminder configuration system allows you to set up expiration reminders for subscription services. You can configure default schedules for each service and create customer-specific overrides when needed.

---

## Access the Interface

**URL:** `/admin/reminders`

**Required Permission:** Administrator, Super Admin, or Staff role

---

## Configuration Levels

### 1. Service Defaults (Recommended First Step)
- Applies to **all customers** of a service
- Acts as the baseline configuration
- Falls back to system default [15, 10, 5, 0 days] if not configured

### 2. Customer Overrides (Optional)
- Applies to **one specific customer**
- Overrides the service default for that customer only
- Useful for VIP clients or special arrangements

---

## Quick Setup (3 Steps)

### Step 1: Configure Service Defaults

1. Go to `/admin/reminders`
2. Click **"Bulk Configure"** button
3. In the template section, select your preferred reminder days (e.g., 30, 15, 10, 5, 0)
4. Check the services you want to configure
5. Click **"Apply Template to Selected"**
6. Click **"Save Configurations"**

**Result:** All selected services now have the same reminder schedule.

### Step 2: Fine-Tune Individual Services

1. From the reminders index, find a service
2. Click **"Configure"** next to the service
3. Adjust the reminder days:
   - Check/uncheck common days (30, 15, 10, 7, 5, 3, 1, 0)
   - Add custom days if needed (0-90 range)
4. Optionally add:
   - Custom email template path
   - Personalized message for this service
5. Click **"Save Configuration"**

### Step 3: Add Customer Overrides (If Needed)

1. On the service configuration page, scroll to **"Customer Overrides"** sidebar
2. Select a customer from the dropdown
3. Configure their personalized schedule
4. Add custom message if needed
5. Click **"Save Override"**

**Result:** This customer receives reminders according to their custom schedule instead of the service default.

---

## Common Use Cases

### Use Case 1: Standard Reminders for All Services
**Goal:** Send reminders 15, 10, 5, and 0 days before expiration

**Steps:**
1. Go to `/admin/reminders/bulk`
2. Template: Check 15, 10, 5, 0
3. Select all services
4. Apply template
5. Save

### Use Case 2: VIP Client with More Frequent Reminders
**Goal:** VIP client wants reminders at 30, 20, 10, 5, 3, 1, and 0 days

**Steps:**
1. Go to service configuration page
2. Scroll to "Add Customer Override" dropdown
3. Select VIP client
4. Check: 30, 10, 5, 3, 1, 0
5. Add custom day: 20
6. Add personalized message
7. Save override

### Use Case 3: Disable Reminders for One Customer
**Goal:** Customer requested no reminder emails

**Steps:**
1. Navigate to customer override page
2. Uncheck the "Enable reminders for this customer" checkbox
3. Save

**Alternative:** Delete the override entirely and disable the service default.

### Use Case 4: Test Different Schedules
**Goal:** A/B test reminder timing

**Steps:**
1. **Group A:** Service default (15, 10, 5, 0)
2. **Group B:** Customer overrides (30, 15, 5, 0)
3. Monitor renewal rates after 30 days
4. Apply winning schedule to more customers

---

## Understanding the Dashboard

### Statistics Cards
- **Service Defaults:** How many services have reminder configurations
- **Customer Overrides:** How many customers have personalized settings
- **Coverage:** How many services still need configuration

### Filters
- **Search:** Find by service name or customer name/email
- **Status:** Filter by active or inactive reminders
- **Type:** Show only service defaults or customer overrides

### Tables
- **Service Defaults Table:** Shows all services with their default schedules
- **Customer Overrides Table:** Shows all customer-specific configurations

---

## Toggle Reminders On/Off

### Quick Toggle
- Each reminder has a toggle switch in the table
- Click to enable/disable without changing configuration
- Status updates immediately

### When to Use
- ✅ Temporarily pause reminders for maintenance
- ✅ Disable for seasonal services during off-season
- ✅ Test new schedules without deleting old ones

---

## Day Selection Explained

### Common Days (Pre-set Checkboxes)
- **30 days:** Full month advance notice
- **15 days:** Two weeks notice
- **10 days:** Ten days notice
- **7 days:** One week notice
- **5 days:** Short notice
- **3 days:** Urgent reminder
- **1 day:** Final warning
- **0 days:** Expiration day notification

### Custom Days
- Click **"Add Custom Day"** to add any value between 0-90
- Example: 45 days (1.5 months), 21 days (3 weeks), etc.
- Remove by clicking the trash icon

### Best Practices
- **Minimum:** 2-3 reminders (e.g., 10, 5, 0)
- **Standard:** 4 reminders (15, 10, 5, 0)
- **Comprehensive:** 5+ reminders (30, 15, 10, 5, 1, 0)

---

## Email Template Customization

### Default Template
- Path: `emails.subscriptions.expiration-reminder`
- Located: `/resources/views/emails/subscriptions/expiration-reminder.blade.php`

### Custom Template
1. In the configuration form, enter template path
2. Example: `emails.custom.vip-reminder`
3. Create the template file in `/resources/views/emails/custom/`
4. Use same variables as default template

### Custom Message
- Appears in the email body
- Great for service-specific instructions
- Example: "Remember to renew early for a 5% discount!"

---

## Deleting Configurations

### Delete Service Default
- Click **"Delete"** next to the service
- **Effect:** All customers fall back to system default [15, 10, 5, 0]
- **Warning:** Does not delete customer overrides

### Delete Customer Override
- Click **"Remove"** next to the customer
- **Effect:** Customer falls back to service default
- **Confirmation:** "Remove this override? Customer will use service default."

---

## Troubleshooting

### Problem: Reminders Not Sending
**Solution:**
1. Check if reminder is enabled (toggle switch on)
2. Verify the service has subscriptions with future expiration dates
3. Confirm the scheduled command is running: `php artisan schedule:list`
4. Check logs: `/storage/logs/laravel.log`

### Problem: Customer Not Receiving Reminders
**Solution:**
1. Check if customer has a disabled override
2. Verify customer email is correct
3. Check if service default is enabled
4. Look for customer override that might be inactive

### Problem: Can't Add Custom Day
**Solution:**
1. Ensure value is between 0-90
2. Check if day already exists (duplicates auto-removed)
3. Clear browser cache and try again

### Problem: Bulk Configure Not Working
**Solution:**
1. Ensure at least one service is selected
2. Check template has at least one day selected
3. Review browser console for JavaScript errors
4. Try configuring services individually

---

## Command Line Management

### Send Reminders Manually
```bash
php artisan subscriptions:send-reminders
```

### Dry Run (Preview Without Sending)
```bash
php artisan subscriptions:send-reminders --dry-run
```

### View Scheduled Tasks
```bash
php artisan schedule:list
```

---

## Best Practices

### Configuration
- ✅ Start with bulk configure for consistency
- ✅ Test with a small group before rolling out
- ✅ Document why certain schedules are chosen
- ✅ Review and adjust quarterly based on renewal rates

### Customer Overrides
- ✅ Use sparingly (too many overrides = hard to manage)
- ✅ Document the reason for overrides
- ✅ Review annually to remove unnecessary overrides
- ✅ Use for VIP clients or special contracts

### Maintenance
- ✅ Check dashboard weekly for new services needing configuration
- ✅ Monitor reminder send logs for errors
- ✅ Update email templates based on customer feedback
- ✅ A/B test different schedules to optimize renewal rates

---

## FAQ

**Q: What happens if I configure both service default and customer override?**  
A: Customer override takes precedence. If you delete the override, they fall back to service default.

**Q: Can I send reminders after expiration?**  
A: Yes, use day 0 (expiration day) or negative values aren't supported, but you can configure post-expiration reminders separately.

**Q: How do I stop all reminders for a service?**  
A: Toggle the service default to inactive (off). All customers will stop receiving reminders.

**Q: Can customers opt out of reminders?**  
A: Yes, create a customer override with the toggle set to inactive (off).

**Q: What's the difference between deleting and disabling?**  
A: Disabling keeps the configuration but stops sending. Deleting removes the configuration entirely (falls back to default).

**Q: Can I schedule reminders for specific times of day?**  
A: Not in this UI. The command runs daily as scheduled. Time is controlled by Laravel scheduler.

**Q: How many reminders is too many?**  
A: More than 6-7 reminders may annoy customers. Test to find the sweet spot for your business.

**Q: Can I use different email templates for different reminder days?**  
A: Not directly in this UI. You'd need to modify the `SendExpirationRemindersCommand` to support per-day templates.

---

## Support

For technical issues or questions:
- Check logs: `/storage/logs/laravel.log`
- Review command output: `php artisan subscriptions:send-reminders --dry-run`
- Contact system administrator

---

**Last Updated:** January 2025  
**Version:** 1.0  
**Laravel:** 12.34.0
