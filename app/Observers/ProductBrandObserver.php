<?php
namespace App\Observers;

use App\Models\ProductBrand;
use Illuminate\Support\Str;

class ProductBrandObserver
{
    public function creating(ProductBrand $brand)
    {
        $brand->slug = $this->generateSlug($brand->name);
    }

    public function updating(ProductBrand $brand)
    {
        if ($brand->isDirty('name')) {
            $brand->slug = $this->generateSlug($brand->name, $brand->id);
        }
    }

    private function generateSlug(?string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name ?? '');
        $slugs    = ProductBrand::query()
            ->where('slug', 'like', $baseSlug . '%')
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->pluck('slug')
            ->toArray();

        if (! in_array($baseSlug, $slugs)) {
            return $baseSlug;
        }

        $counter = 1;

        while (in_array($baseSlug . '-' . $counter, $slugs)) {
            $counter++;
        }

        return $baseSlug . '-' . $counter;
    }
}
