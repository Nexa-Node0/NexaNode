<?php
namespace App\Filament\Resources\Inventory\Products\Tables;

use App\Models\Product;
use App\Models\ProductPossession;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                'brand.name',
                'category.name',
                'creator.name',
                'low_stock_threshold',
            ])
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                ImageColumn::make('brand.logo')
                    ->disk('public')
                    ->placeholder(fn($record) => $record->brand->name)
                    ->tooltip(fn($record) => $record->brand->name),
                TextColumn::make('quantity')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn(int $state, $record): string => $record->isLowStock() ? 'danger' : 'success'),
                TextColumn::make('low_stock_threshold')
                    ->label('Low Stock Level')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->color(fn($state) => $state == auth()->user()->name ? 'info' : 'success')
                    ->tooltip(fn($state) => $state == auth()->user()->name ? 'You' : $state),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),
            ])
            ->filters([
                //
                SelectFilter::make('brand.name')
                    ->multiple()
                    ->relationship('brand', 'name'),
                SelectFilter::make('category.name')
                    ->multiple()
                    ->relationship('category', 'name'),
                Filter::make('low_stock_threshold')
                    ->schema([
                        TextInput::make('low_stock_threshold')
                            ->label('Low Stock Level')
                            ->numeric(),
                    ])
                    ->query(function ($query, array $data) {

                        return $query->when(
                            filled($data['low_stock_threshold'] ?? null),
                            fn($q) => $q->where('low_stock_threshold', $data['low_stock_threshold'])
                        );

                    }),
            ])
            ->actions([
                //

                Action::make('deploy_products')
                    ->label('Deploy')
                    ->icon('heroicon-o-paper-airplane')
                    ->form(fn(Product $record) => [
                        Repeater::make('members')
                            ->schema([
                                Select::make('original_owner')
                                    ->label('Assign To')
                                    ->options(User::query()->pluck('name', 'id')->toArray())
                                    ->required(),
                                MarkdownEditor::make('notes'),
                            ])
                            ->columns(2)
                            ->minItems(1)
                            ->maxItems(fn() => $record->quantity),
                    ])
                    ->action(function (array $data, Product $record): void {
                        foreach ($data['members'] as $member) {
                            ProductPossession::create([
                                'product_id'     => $record->id,
                                'original_owner' => $member['original_owner'],
                                'notes'          => $member['notes'],
                            ]);

                            Notification::make()
                                ->title('New Product Assigned')
                                ->body($member['notes'] ?? '')
                                ->sendToDatabase(User::find($member['original_owner']));
                        }
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }
}
