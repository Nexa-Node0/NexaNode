<?php
namespace App\Filament\Project\Resources\Projects\Pages;

use App\Filament\Project\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $baseSlug = Str::slug($data['title']);
        $slug     = $baseSlug;
        $count    = 1;

        while (Project::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $data['slug'] = $slug;

        // dd($data);
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->users()->syncWithoutDetaching([$this->record->supervisor]);
    }
}
