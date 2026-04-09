<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AdminStatsWidget;
use App\Filament\Widgets\InventoryStatsWidget;
use App\Filament\Widgets\LowStockProductsWidget;
use App\Filament\Widgets\RecentStockMovementsWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Facades\Filament;
// use App\Http\Middleware\UserLastSeen;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Storage;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandLogo(Storage::url('logos/nexa_node_transparent.png'))
            ->brandLogoHeight('80px')
            ->favicon(Storage::url('logos/nexa_node_darkmode.png'))
            ->brandName('Nexa Node')
            ->authGuard('web')
            ->login()
            ->plugins([FilamentShieldPlugin::make()])
            ->plugin(FilamentShieldPlugin::make())
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->navigationItems([
                NavigationItem::make('projects')
                    ->label('View Projects')
                    ->icon(Heroicon::CalendarDateRange)
                    ->url(fn() =>
                        ($tenant = Filament::getTenant() ?? auth()->user()?->projects()->first())
                            ? route('filament.project.pages.dashboard', ['tenant' => $tenant])
                            : '#'
                        )
                    ->visible(fn()=>auth()->user()->can('Navigation:ViewProjects')),
            ])
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
                'update_last_seen',
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
