<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Attachment;
use App\Observers\AdminObserver;
use App\Observers\AttachmentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Admin::observe(AdminObserver::class);
        Attachment::observe(AttachmentObserver::class);
    }
}
