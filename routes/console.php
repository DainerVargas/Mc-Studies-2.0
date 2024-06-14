<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('send:email')->daily();
Schedule::command('app:tiempo')->weeklyOn(5, '5:00');
/* Schedule::command('app:tiempo')->everyFifteenSeconds(); */
/* Schedule::command('send:email')->everyMinute(); */
