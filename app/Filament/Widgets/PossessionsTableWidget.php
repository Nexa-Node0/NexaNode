<?php
// app/Filament/Widgets/PossessionsTableWidget.php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductPossessions\Tables\ProductPossessionsTable;
use App\Models\Product;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PossessionsTableWidget extends BaseWidget
{
    public int $productId;

    protected function getTableQuery(): Builder
    {
        return Product::find($this->productId)
            ->deployedItems()
            ->with('product', 'product.category', 'originalOwner', 'currentOwner')
            ->getQuery();
    }

    public function table(Table $table): Table
    {
        return ProductPossessionsTable::getTableContents($table);
    }
}
