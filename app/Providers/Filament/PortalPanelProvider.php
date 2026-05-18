<?php

namespace App\Providers\Filament;

use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class PortalPanelProvider extends BasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('portal')
            ->path('portal')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Portal/Resources'), for: 'App\Filament\Portal\Resources')
            ->discoverPages(in: app_path('Filament/Portal/Pages'), for: 'App\Filament\Portal\Pages')
            ->discoverWidgets(in: app_path('Filament/Portal/Widgets'), for: 'App\Filament\Portal\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->login()
            ->plugins([
                AuthUIEnhancerPlugin::make()
                    ->showEmptyPanelOnMobile()
                    ->formPanelPosition('left')
                    ->formPanelWidth('50%')
                    ->emptyPanelBackgroundImageOpacity('70%')
                    ->emptyPanelBackgroundColor(['500' => '#0d1418'])
                    ->emptyPanelView('filament.pages.auth.portal-panel'),
                BreezyCore::make()
                    ->myProfile()
                    ->avatarUploadComponent(fn($fileUpload) => $fileUpload->disableLabel())
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        // return $this->applyBrandSettings($panel);
    }
}
