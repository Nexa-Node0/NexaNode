<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('Product Name'),
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Inventory Details')
                    ->schema([
                        TextInput::make('sku')
                            ->maxLength(8)
                            ->label('SKU')
                            ->hint('Leave blank to auto-generate')
                            ->disabled()
                            ->dehydrated(),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->label('Category')
                            ->searchable()
                            ->preload(),
                        TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->step('0.01')
                            ->minValue(0)
                            ->label('Price'),
                        TextInput::make('low_stock_threshold')
                            ->numeric()
                            ->required()
                            ->integer()
                            ->minValue(0)
                            ->default(5)
                            ->label('Low Stock Threshold'),
                        TextInput::make('quantity')
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false)
                            ->label('Current Quantity')
                            ->hint('Managed through stock movements'),
                    ])->columns(2),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('products')
                            ->visibility('public')
                            ->label('Product Image'),
                    ]),
            ]);
    }
}
