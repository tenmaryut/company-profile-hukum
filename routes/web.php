<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PracticeAreaController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/profil', [PageController::class, 'profile'])->name('profile');
Route::get('/tim', [PageController::class, 'team'])->name('team');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privasi', [PageController::class, 'privacy'])->name('privacy');

Route::get('/bidang-praktik', [PracticeAreaController::class, 'index'])->name('practice-areas.index');
Route::get('/bidang-praktik/{practiceArea:slug}', [PracticeAreaController::class, 'show'])->name('practice-areas.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/kategori/{category:slug}', [ArticleController::class, 'category'])->name('articles.category');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/kontak', [ConsultationRequestController::class, 'create'])->name('contact');
Route::post('/kontak', [ConsultationRequestController::class, 'store'])
    ->middleware('throttle:konsultasi')
    ->name('consultation.store');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
