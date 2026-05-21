<?php

namespace App\Observers;

use App\Models\StockMovement;

class StockMovementObserver
{
    public function created(StockMovement $stockMovement): void
    {
        $product = $stockMovement->product;

        if (!$product) {
            return;
        }

        // Calculate quantity change based on movement type
        $quantityChange = $stockMovement->type === 'in'
            ? $stockMovement->quantity
            : -$stockMovement->quantity;

        // Update product quantity
        $product->increment('quantity', $quantityChange);
    }

    public function updated(StockMovement $stockMovement): void
    {
        // Check if type or quantity actually changed
        if (!$stockMovement->wasChanged(['type', 'quantity'])) {
            return;
        }

        $product = $stockMovement->product;

        if (!$product) {
            return;
        }

        // Get original values
        $originalType = $stockMovement->getOriginal('type');
        $originalQuantity = $stockMovement->getOriginal('quantity');

        // Calculate the old change
        $oldQuantityChange = $originalType === 'in'
            ? $originalQuantity
            : -$originalQuantity;

        // Reverse the old change
        $product->decrement('quantity', $oldQuantityChange);

        // Calculate the new change
        $newQuantityChange = $stockMovement->type === 'in'
            ? $stockMovement->quantity
            : -$stockMovement->quantity;

        // Apply the new change
        $product->increment('quantity', $newQuantityChange);
    }

    public function deleted(StockMovement $stockMovement): void
    {
        $product = $stockMovement->product;

        if (!$product) {
            return;
        }

        // Reverse the original quantity change
        $quantityChange = $stockMovement->type === 'in'
            ? $stockMovement->quantity
            : -$stockMovement->quantity;

        $product->decrement('quantity', $quantityChange);
    }


    public function restored(StockMovement $stockMovement): void
    {
        $product = $stockMovement->product;

        if (!$product) {
            return;
        }

        // Re-apply the quantity change
        $quantityChange = $stockMovement->type === 'in'
            ? $stockMovement->quantity
            : -$stockMovement->quantity;

        $product->increment('quantity', $quantityChange);
    }
}
