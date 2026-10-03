<?php

use App\Models\ConsultationRequest;
use Illuminate\Support\Facades\Schedule;

// Hapus permintaan konsultasi yang berumur lebih dari 7 hari (UU 27/2022: retensi sesuai tujuan).
Schedule::command('model:prune', ['--model' => [ConsultationRequest::class]])->hourly();

// Bersihkan job gagal yang lebih tua dari 7 hari.
Schedule::command('queue:prune-failed', ['--hours' => 168])->daily();

// Reset data demo tiap malam dijalankan oleh systemd timer, bukan scheduler ini
// (lihat deploy/systemd/company-profile-hukum-demo-reset.timer).
