<?php
namespace App\Observers;

use App\Enums\ProductStatusEnum;
use App\Models\ProductPossession;
use Filament\Notifications\Notification;

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
        if ($productPossession->isDirty('current_owner')) { // ← likely current_owner_id not current_owner
            $productPossession->transferred_date = now()->toDate();
            if ($productPossession->status == ProductStatusEnum::Returned) {
                $productPossession->status = ProductStatusEnum::Active;
            }
            Notification::make()
                ->title('Item Acquired')
                ->body($productPossession->product->name . ' Has Been Passed to you')
                ->color('success')
                ->sendToDatabase($productPossession->currentOwner); // ← use the relation
        }
        if ($productPossession->isDirty('status') &&
            $productPossession->status === ProductStatusEnum::Returned
        ) {
            $productPossession->returned_date = now()->toDate();
        }
    }

    public function updated(ProductPossession $productPossession): void
    {
        if ($productPossession->wasChanged('status')) {
            if ($productPossession->status === ProductStatusEnum::Returned) {
                $productPossession->product()->increment('quantity'); // returned → back in stock
            } else {
                $productPossession->product()->decrement('quantity'); // re-deployed → out of stock
            }
        }
    }

}
