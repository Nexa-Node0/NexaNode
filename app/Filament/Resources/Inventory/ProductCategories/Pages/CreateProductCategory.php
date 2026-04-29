<?php

namespace App\Filament\Resources\Inventory\ProductCategories\Pages;

use App\Filament\Resources\Inventory\ProductCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductCategory extends CreateRecord
{
    protected static string $resource = ProductCategoryResource::class;
}
