<?php
namespace App\Filament\Resources\Inventory;

use App\Enums\NavigationOptions;
use App\Filament\Resources\Inventory\ProductBrands\Pages\ManageProductBrands;
use App\Helper\FilamentBrowsershotHelper;
use App\Helper\FilamentBrowsershotModalHelper;
use App\Models\ProductBrand;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;
use UnitEnum;

class ProductBrandResource extends Resource
{
    protected static ?string $model = ProductBrand::class;

    protected static string|BackedEnum|null $navigationIcon       = Heroicon::RectangleGroup;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return NavigationOptions::Inventory->getLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) =>
                        $set('slug', \Illuminate\Support\Str::slug($state))
                    ),

                TextInput::make('slug')
                    ->hint('Leave blank to auto generate')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disabled(),

                Textarea::make('description')
                    ->columnSpanFull(),

                FileUpload::make('logo')
                    ->disk('public')
                    ->directory('images/brands')
                    ->image()
                    ->imageEditor()
                    ->nullable(),

                TextInput::make('website')
                    ->url()
                    ->suffixAction(
                        Action::make('https')
                            ->icon('heroicon-m-link')
                            ->action(function ($set, $get) {
                                if (! str_starts_with($get('website') ?? '', 'https://')) {
                                    $set('website', 'https://');
                                }
                            })
                    )
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->tooltip(fn($record) => $record->description ?: $record->title),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('visit')
                    ->icon(Heroicon::Link)
                    ->hiddenLabel()
                    ->tooltip('Visit Website')
                    ->visible(fn($record): bool => $record->website !== null)
                    ->url(fn($record) => $record->website)
                    ->size('lg'),
                Action::make('download_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->schema(fn(Schema $schema) => FilamentBrowsershotModalHelper::getModal($schema))
                    ->action(function ($record, array $data) {
                        // dd($data);
                        return (new FilamentBrowsershotHelper([]))
                            ->fromData($data)
                            ->pdf('pdf.invoice', "invoice-{$record->id}.pdf");
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProductBrands::route('/'),
        ];
    }
}
