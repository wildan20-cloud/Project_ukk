<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Authenticated;
use App\Models\ActivityLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Memasang listener untuk mencatat log saat user masuk/register
        Event::listen(
            Authenticated::class,
            function ($event) {
                ActivityLog::create([
                    'user_id'  => $event->user->id,
                    'role'     => $event->user->role ?? 'peminjam', 
                    'activity' => 'Melakukan Login ke sistem',
                ]);
            }
        );
    }
}