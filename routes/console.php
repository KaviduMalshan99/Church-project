<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

return function (Schedule $schedule) {
    // Schedule the command to run every 12 hours
    $schedule->command('app:birthday-wishes')->dailyAt('05:00'); //runs the birthday wishes command every day at 5:00 AM.
};