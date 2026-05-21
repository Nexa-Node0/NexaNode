<?php

namespace App\Filament\Resources\Inventory\ProductCategories\Pages;

use App\Filament\Resources\Inventory\ProductCategories\Schemas\ProductCategoryForm;
use App\Filament\Resources\Inventory\ProductCategoryResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Schema;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->schema(fn(Schema $schema) => ProductCategoryForm::configure($schema)),
        ];
    }
}
