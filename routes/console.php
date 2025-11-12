<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Subscription Management Scheduled Tasks
Schedule::command('subscriptions:send-reminders')
    ->daily()
    ->at('09:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->emailOutputOnFailure(config('mail.admin_email'));

Schedule::command('subscriptions:update-statuses --notify --admin-report')
    ->daily()
    ->at('02:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->emailOutputOnFailure(config('mail.admin_email'));
