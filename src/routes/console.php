<?php

// use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

/**
 * Limpieza del Activitylog del sistema.
 */
Artisan::command('activitylog:clean --force')->dailyAt('23:00');
