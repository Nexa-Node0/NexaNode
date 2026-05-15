<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AdminStatsWidget;
use App\Filament\Widgets\InventoryStatsWidget;
use App\Filament\Widgets\LowStockProductsWidget;
use App\Filament\Widgets\RecentStockMovementsWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\BootstrapMailSettings;
use Outerweb\FilamentSettings\SettingsPlugin;
use App\Enums\NavigationOptions;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Outerweb\Settings\Facades\Setting;
use Illuminate\Support\Facades\Storage;

class AdminPanelProvider extends BasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
     
       $panel
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->navigationGroups(NavigationOptions::getNavigations())
            ->login()
            ->brandName(Setting::get('media.name'))
            ->brandLogo(Storage::url(Setting::get('media.darkmode_logo')))
            ->brandLogoHeight('80px')
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
                    ->formPanelWidth('40%')
                    ->emptyPanelBackgroundImageOpacity('70%')
                    ->emptyPanelBackgroundColor(['500' => '#0d1418'])
                    ->emptyPanelView('filament.pages.auth.admin-panel')
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

        return $this->applySettings($panel);
    }
}
