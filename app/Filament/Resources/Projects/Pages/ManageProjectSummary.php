<?php
namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord; // ✅
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;

class ManageProjectSummary extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProjectResource::class;
    protected string $view            = 'filament.resources.projects.pages.manage-project-summary';

    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $summary = $this->record->summary;

        $this->form->fill(
            $summary ? $summary->only(['description', 'goals']) : []
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('description')
                    ->label('Tell me more about this Project')
                    ->required(),
                MarkdownEditor::make('goals')
                    ->label('What is the Goal of this Project?')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $data = array_filter($data, fn($value) => $value !== null);

        $this->record->summary()->updateOrCreate([], $data);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
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
