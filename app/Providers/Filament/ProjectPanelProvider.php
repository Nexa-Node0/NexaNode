<?php

namespace App\Providers\Filament;

use App\Http\Middleware\ProjectPanelMiddleware;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
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
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ProjectPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('project')
            ->path('project')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->navigationItems([
                NavigationItem::make('return')
                    ->label('Return to Admin Panel')
                    ->icon(Heroicon::ArrowRightEndOnRectangle)
                    ->url(fn()=>route('filament.admin.pages.dashboard'))
                    ->visible(fn()=>auth()->user()->can('Navigation:ReturnAdmin')),
            ])
            ->authGuard('web')
            ->discoverResources(in: app_path('Filament/Project/Resources'), for: 'App\Filament\Project\Resources')
            ->discoverPages(in: app_path('Filament/Project/Pages'), for: 'App\Filament\Project\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Project/Widgets'), for: 'App\Filament\Project\Widgets')
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
                ProjectPanelMiddleware::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
