<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\Departments\Pages\CreateDepartment;
use App\Filament\Resources\HR\Departments\Pages\EditDepartment;
use App\Filament\Resources\HR\Departments\Pages\ListDepartments;
use App\Filament\Resources\HR\Departments\Schemas\DepartmentForm;
use App\Filament\Resources\HR\Departments\Tables\DepartmentsTable;

use App\Models\Department;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Illuminate\Contracts\Support\Htmlable;
use Override;
use UnitEnum;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QueueList;

    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema
    {
        return DepartmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepartmentsTable::configure($table);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return NavigationOptions::HR->getLabel();
    }

    #[Override]
    public static function getNavigationBadgeTooltip(): string|Htmlable|null
    {
        return 'Active departments';
    }

    #[Override]
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active',true)->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }
}
