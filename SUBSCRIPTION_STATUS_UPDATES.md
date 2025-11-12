# Automatic Subscription Status Updates

This document explains how the automatic subscription status update system works and how to use it.

## Overview

The subscription status update system automatically processes subscriptions based on their expiration dates, updating statuses and sending notifications to customers and administrators.

## Command

### Basic Usage

```bash
php artisan subscriptions:update-statuses
```

### Options

- `--dry-run`: Run the command without making any changes to the database. Useful for testing.
- `--grace-period=N`: Set a grace period (in days) before marking subscriptions as expired. Default: 0
- `--notify`: Send email notifications to customers about their expired subscriptions
- `--admin-report`: Send a summary report to administrators after completion

### Examples

**Test run without changes:**
```bash
php artisan subscriptions:update-statuses --dry-run
```

**Update statuses with 7-day grace period:**
```bash
php artisan subscriptions:update-statuses --grace-period=7
```

**Update statuses and send notifications:**
```bash
php artisan subscriptions:update-statuses --notify --admin-report
```

**Full production run:**
```bash
php artisan subscriptions:update-statuses --grace-period=3 --notify --admin-report
```

## What the Command Does

### 1. Process Expired Subscriptions
- Finds subscriptions with status `active` or `pending_renewal` that have passed their expiration date
- Updates status to `expired`
- Disables auto-renewal to prevent accidental charges
- Optionally sends expiration notifications to customers

### 2. Process Trial Expirations
- Finds subscriptions with status `trial` where the trial period has ended
- Converts to `active` if auto-renew is enabled and payment method is valid
- Otherwise marks as `expired`
- Sends notifications to customers

### 3. Process Suspended Subscriptions (with grace period)
- After the grace period expires, moves subscriptions from `expired` to `suspended`
- Only applicable if a grace period is configured
- Does not affect cancelled subscriptions

## Scheduling

The command is automatically scheduled to run daily at 2:00 AM:

```php
Schedule::command('subscriptions:update-statuses --notify --admin-report')
    ->daily()
    ->at('02:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->emailOutputOnFailure(config('mail.admin_email'));
```

### Scheduler Configuration

To enable the Laravel scheduler, add this cron entry to your server:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Notifications

### Customer Notifications

When `--notify` is used, customers receive an email notification containing:
- Subscription details (service name, expiration date)
- Days since expiration
- Grace period information (if applicable)
- Renewal pricing with discounts
- Data retention warnings
- "Renew Now" button linking to renewal page

### Admin Reports

When `--admin-report` is used, administrators receive a summary email containing:
- Execution time
- Total subscriptions processed
- Number expired
- Number suspended
- Notifications sent
- Errors encountered

## Output

The command provides detailed console output:

```
Starting subscription status update...
Grace period: 3 days

Processing expired subscriptions...
  Found 15 expired subscription(s)
[Progress bar shows processing]

Processing trial expirations...
  No expired trials found.

Processing suspended subscriptions (grace period expired)...
  Found 5 subscription(s) to suspend
[Progress bar shows processing]

Summary:
+-----------------------+-------+
| Metric                | Count |
+-----------------------+-------+
| Total Processed       | 20    |
| Expired               | 15    |
| Suspended             | 5     |
| Notifications Sent    | 20    |
| Errors                | 0     |
+-----------------------+-------+

✓ Subscription status update completed successfully!
```

## Error Handling

- All database operations are wrapped in transactions for data integrity
- Errors are logged to `storage/logs/laravel.log`
- Failed subscriptions are counted but don't stop the entire process
- Admin email notifications are sent if the scheduled command fails

## Grace Period Behavior

### Without Grace Period (--grace-period=0)
```
Active → Expired (immediately on expiration date)
```

### With Grace Period (--grace-period=7)
```
Active → Still Active (within 7 days of expiration)
Active → Expired (after 7 days past expiration)
Expired → Suspended (after 14 days past expiration, 2x grace period)
```

## Best Practices

1. **Test First**: Always use `--dry-run` when testing configuration changes
2. **Grace Period**: Use a reasonable grace period (3-7 days) to give customers time to renew
3. **Timing**: Schedule during off-peak hours (early morning) to minimize impact
4. **Monitoring**: Enable `--admin-report` to track subscription health
5. **Notifications**: Use `--notify` in production to keep customers informed

## Troubleshooting

### Command Not Found
If the command doesn't appear in `php artisan list`:
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`
- Ensure the file is in `app/Console/Commands/`

### Notifications Not Sending
- Check mail configuration in `.env`
- Verify queue workers are running: `php artisan queue:work`
- Check `failed_jobs` table for failed notifications

### Scheduler Not Running
- Verify cron job is configured correctly
- Check cron logs: `grep CRON /var/log/syslog`
- Test manually: `php artisan schedule:run`

## Related Commands

- `subscriptions:send-reminders`: Send expiration reminder emails
- `php artisan queue:work`: Process queued notification jobs
- `php artisan schedule:list`: View all scheduled commands

## Database Impact

The command modifies:
- `subscriptions` table: Updates `status` and `auto_renew` fields
- `notifications` table: Adds notification records for customers
- No data is deleted (safe operation)

## Performance Considerations

- Progress bars shown for large batches
- Runs in background when scheduled
- Uses database transactions for safety
- Queues email notifications to avoid blocking
- Implements `withoutOverlapping()` to prevent concurrent runs

## Monitoring

Check the following to monitor subscription health:
1. Analytics Dashboard: `/admin/subscriptions/analytics`
2. Application logs: `storage/logs/laravel.log`
3. Failed jobs: `php artisan queue:failed`
4. Admin email reports (if enabled)
