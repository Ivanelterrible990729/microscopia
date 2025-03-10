<?php

// use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

/**
 * Limpieza del Activitylog del sistema.
 */
Schedule::command('activitylog:clean --force')->dailyAt('23:00');
