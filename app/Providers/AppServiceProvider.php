<?php

namespace App\Providers;

use App\Models\ProductBrand;
use App\Models\StockMovement;
use App\Observers\ProductBrandObserver;
use App\Observers\StockMovementObserver;
use App\Services\SEOService;
use Illuminate\Support\ServiceProvider;
use App\Traits\HasMailSettings;
use App\Traits\HasCaptchaSettings;
use App\Observers\PositionObserver;
use App\Models\Position;
use App\Models\UserPosition;
use App\Observers\UserPositionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    use HasMailSettings;
    use HasCaptchaSettings;

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        StockMovement::observe(StockMovementObserver::class);
        ProductBrand::observe(ProductBrandObserver::class);
        Position::observe(PositionObserver::class);

        $this->bootstrapMailConfig();
        $this->bootstrapCaptchaConfig();

        // SEO
        $this->app->singleton(SEOService::class);
    }
}
