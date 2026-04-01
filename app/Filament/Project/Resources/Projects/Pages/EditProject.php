<?php
namespace App\Filament\Project\Resources\Projects\Pages;

use App\Filament\Project\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $baseSlug = Str::slug($data['title']);
        $slug     = $baseSlug;
        $count    = 1;

        // exclude current record from uniqueness check
        while (Project::where('slug', $slug)->where('id', '!=', $this->record->id)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $data['slug'] = $slug;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // redirect to new slug after save
        return $this->getResource()::getUrl('edit', [
            'record' => $this->record,
            'tenant' => $this->record, // current project IS the tenant
        ]);
    }
}
