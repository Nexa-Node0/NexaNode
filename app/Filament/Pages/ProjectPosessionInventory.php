<?php
namespace App\Filament\Pages;

use App\Enums\NavigationOptions;
use App\Models\ProductCategory;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Override;
use UnitEnum;

class ProjectPosessionInventory extends Page
{
    public $possessions           = [];
    public ?int $selectedCategory = null; // ✅ filter state
    protected string $view        = 'filament.pages.project-posession-inventory';

    protected static ?string $navigationLabel = 'Possessions';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedBriefcase;

    #[Override]
    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return NavigationOptions::Inventory->getLabel();
    }

    public function mount(): void
    {
        $this->loadPossessions();
    }

    public function updatedSelectedCategory(): void// ✅ auto-fires when select changes
    {
        $this->loadPossessions();
    }

    private function loadPossessions(): void
    {
        $this->possessions = auth()->user()
        ?->possessions()
            ->with('product.brand', 'product.category')
            ->when(
                $this->selectedCategory,
                fn($q) => $q->whereHas('product', fn($q) => $q->where('category_id', $this->selectedCategory))
            )
            ->latest()
            ->get() ?? collect();
    }

    public function getCategoryOptions(): array// ✅ options for the select
    {
        return ProductCategory::query()
            ->pluck('name', 'id')
            ->toArray();
    }
}
