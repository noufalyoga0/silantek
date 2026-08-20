<?php

use Illuminate\Support\Facades\Schedule;

// Jalankan pengecekan SLA setiap 1 jam
Schedule::command('silantek:check-sla')->hourly();
