<?php

namespace App\Providers\Filament;

use App\Enums\NavigationOptions;
use App\Filament\Widgets\AdminStatsWidget;
use App\Filament\Widgets\InventoryStatsWidget;
use App\Filament\Widgets\LowStockProductsWidget;
use App\Filament\Widgets\RecentStockMovementsWidget;
use App\Http\Middleware\BootstrapMailSettings;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Outerweb\FilamentSettings\SettingsPlugin;
use Outerweb\Settings\Facades\Setting;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $brandLogo = Setting::get('general.brand_logo');
        $darkModeLogo = Setting::get('general.dark_mode_brand_logo');
        $favicon = Setting::get('general.favicon');
        $brandName = Setting::get('general.brand_name', config('app.name'));
        $panelBackground = Setting::get('general.admin_empty_panel_background');

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandLogo($brandLogo ? Storage::url($brandLogo) : null)
            ->darkModeBrandLogo(Storage::url($darkModeLogo))
            ->favicon($favicon ? Storage::url($favicon) : null)
            ->brandName($brandName)
            ->brandLogoHeight('80px')
            ->authGuard('web')
            ->navigationGroups(NavigationOptions::getNavigations())
            ->login()
            ->plugins([
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'lg' => 2
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'lg' => 2
                    ]),
                SettingsPlugin::make(),
                AuthUIEnhancerPlugin::make()
                    ->showEmptyPanelOnMobile(false)
                    ->formPanelPosition('right')
                    ->formPanelWidth('50%')
                    ->emptyPanelBackgroundImageOpacity('70%')
                    ->emptyPanelBackgroundColor(['500' => '#0d1418'])
                    ->emptyPanelView('filament.pages.login-left-panel')
            ])

            ->colors([
                'primary' => Color::Blue,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                InventoryStatsWidget::class,
                AccountWidget::class,
                LowStockProductsWidget::class,
                RecentStockMovementsWidget::class,
                AdminStatsWidget::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('10s')
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
                BootstrapMailSettings::class,
                'update_last_seen',
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
