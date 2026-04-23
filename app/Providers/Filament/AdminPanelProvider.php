<?php

namespace App\Providers\Filament;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Http\Middleware\UserLastSeen;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
<<<<<<< HEAD

=======
use Illuminate\Support\Facades\Storage;
use Outerweb\FilamentSettings\SettingsPlugin;
use Outerweb\Settings\Facades\Setting;
>>>>>>> 310109f0ebe242ce81c079cee55f9e3bf858c50b
class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        $brandLogo = Setting::get('general.brand_logo');
        $favicon = Setting::get('general.favicon');
        $brandName = Setting::get('general.brand_name', config('app.name'));
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
<<<<<<< HEAD
            ->authGuard('web')
=======
            ->brandLogo($brandLogo ? Storage::url($brandLogo) : null)
            ->favicon($favicon ? Storage::url($favicon) : null)
            ->brandName($brandName)
            ->brandLogoHeight('80px')
            ->authGuard('web')
            ->navigationGroups([
                'Dashboard',
                'Filament Shield',
                'HR',
                'Inventory',
                'Location',
                'Blog',
                'Settings'
            ])
>>>>>>> 310109f0ebe242ce81c079cee55f9e3bf858c50b
            ->login()
            ->plugins([FilamentShieldPlugin::make()])
            ->plugin(FilamentShieldPlugin::make())
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                'update_last_seen',
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
