<?php

namespace App\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Support\Facades\View;
use Override;

class EnvironmentIndicatorPlugin implements Plugin
{
    use EvaluatesClosures;

    protected bool|\Closure $visible = true;
    protected bool|\Closure $showBadge = true;
    protected string|\Closure|null $color = null;

    public static function make(): static
    {
        return app(static::class);
    }

    #[Override]
    public function getId(): string
    {
        return 'environment-indicator';
    }

    #[Override]
    public function register(Panel $panel): void
    {
        View::addNamespace(
            'filament-environment-indicator',
            resource_path('views/filament/environment-indicator')
        );

        $panel->renderHook('panels::global-search.before', function () {
            if (! $this->evaluate($this->visible)) {
                return '';
            }

            if (! $this->evaluate($this->showBadge)) {
                return '';
            }

            return View::make('filament-environment-indicator::badge', [
                'color' => $this->getColor(),
                'environment' => ucfirst(app()->environment()),
            ]);
        });
    }

    #[Override]
    public function boot(Panel $panel): void
    {
        //
    }
    public function visible(bool|\Closure $visible = true): static
    {
        $this->visible = $visible;
        return $this;
    }

    public function showBadge(bool|\Closure $showBadge = true): static
    {
        $this->showBadge = $showBadge;
        return $this;
    }

    public function color(string|\Closure|null $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->evaluate($this->color) ?? $this->resolveColor();
    }

    public function resolveColor(): string
    {
        return match (strtolower(app()->environment())) {
            'production'  => 'success',
            'local'       => 'warning',
            'development' => 'danger',
            default       => 'gray'
        };
    }
}
