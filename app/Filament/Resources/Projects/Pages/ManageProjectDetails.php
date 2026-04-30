<?php
namespace App\Filament\Resources\Projects\Pages;

use App\Enums\TechStacksEnum;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;

class ManageProjectDetails extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProjectResource::class;
    protected string $view            = 'filament.resources.projects.pages.manage-project-details';

    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $detail = $this->record->details;

        $this->form->fill(
            $detail ? $detail->only(['client_id', 'abstract', 'tags']) : []
        );
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Remove any null or empty values that could cause issues
        $data = array_filter($data, fn($value) => $value !== null);

        $this->record->details()->updateOrCreate(
            [], // match condition — finds existing record linked to this project
            $data
        );

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Client')
                    ->options(\App\Models\Client::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('abstract')
                    ->required(),
                Select::make('tags')
                    ->options(TechStacksEnum::options())
                    ->multiple()
                    ->required(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Details')
                ->submit('save'),
        ];
    }
}
