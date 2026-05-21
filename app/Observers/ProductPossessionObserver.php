<?php
namespace App\Observers;

use App\Enums\ProductStatusEnum;
use App\Models\ProductPossession;

class ProductPossessionObserver
{
    public function creating(ProductPossession $productPossession): void
    {
        $productPossession->current_owner = $productPossession->original_owner;
        $productPossession->status        = ProductStatusEnum::Active;
        $productPossession->release_date  = now()->toDate();
    }

    public function created(ProductPossession $productPossession): void
    {
        $productPossession->product()->decrement('quantity');
    }

    public function updating(ProductPossession $productPossession): void
    {
        if ($productPossession->isDirty('current_owner')) {
            $productPossession->transferred_date = now()->toDate();
        }

        if ($productPossession->isDirty('status') &&
            $productPossession->status === ProductStatusEnum::Returned
        ) {
            $productPossession->returned_date = now()->toDate();
        }
    }

    public function updated(ProductPossession $productPossession): void
    {
        if ($productPossession->wasChanged('status') &&
            $productPossession->status === ProductStatusEnum::Returned
        ) {
            $productPossession->product()->increment('quantity');
        }
    }
}
