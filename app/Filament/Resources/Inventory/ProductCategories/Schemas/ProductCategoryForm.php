<?php

namespace App\Filament\Resources\Inventory\ProductCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Category Name'),
                Textarea::make('description')
                    ->maxLength(255)
                    ->label('Description'),
            ]);
    }
}
