<?php
namespace App\Filament\Pages;

use App\Enums\NavigationOptions;
use App\Enums\ProductStatusEnum;
use App\Models\ProductCategory;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Override;
use UnitEnum;

class ProjectPosessionInventory extends Page
{
    public $possessions           = [];
    public ?int $selectedCategory = null;
    public string $activeTab      = 'grid';
    public string $searchedWord   = '';

    protected string $view = 'filament.pages.project-posession-inventory';

    protected static ?string $navigationLabel                         = 'Your Items';
    protected static string|BackedEnum|null $navigationIcon       = Heroicon::Briefcase;
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

    public function updatedSelectedCategory(): void
    {
        $this->loadPossessions();
    }

    public function updatedSearchedWord(): void// ✅ auto-fires on search input
    {
        $this->loadPossessions();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
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
            ->when(
                filled($this->searchedWord), // ✅ search across product name & brand
                fn($q) => $q->whereHas('product', fn($q) => $q
                        ->where('name', 'like', '%' . $this->searchedWord . '%')
                        ->orWhereHas('brand', fn($q) => $q->where('name', 'like', '%' . $this->searchedWord . '%'))
                )
            )
            ->where('status', '!=', ProductStatusEnum::Returned->value)
            ->latest()
            ->get() ?? collect();
    }

    public function getCategoryOptions(): array
    {
        return ProductCategory::query()
            ->pluck('name', 'id')
            ->toArray();
    }
}
