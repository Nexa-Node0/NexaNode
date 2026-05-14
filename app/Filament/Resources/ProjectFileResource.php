<?php
namespace App\Filament\Resources;

use App\Models\FileStorage;
use Filament\Resources\Resource;

class ProjectFileResource extends Resource
{
    protected static ?string $model = FileStorage::class;

    // 👇 This forces Shield to generate permissions under "ProjectFile" separately
    protected static ?string $permissionPrefixName = 'project_file';

    public static function canAccess(): bool
    {
        return false;
    }

    protected static bool $shouldRegisterNavigation = false;
}
