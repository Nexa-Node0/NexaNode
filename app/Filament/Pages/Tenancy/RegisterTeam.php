<?php
namespace App\Filament\Pages\Tenancy;

use App\Models\Project;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Join Project';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code'),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Project
    {
        $project = Project::whereCode($data['code'])->first();

        if (! $project) {
            Notification::make()
                ->danger()
                ->title('Project Not Found')
                ->body('No project with that code exists. Please try again.')
                ->send();

            $this->halt(); // stops Filament from redirecting to a null tenant
        }

        $user = auth()->user();

        if ($project->users()->whereKey($user)->exists()) {
            Notification::make()
                ->warning()
                ->title('Already a Member')
                ->body('You are already part of this project.')
                ->send();

            $this->halt();
        }

        $project->users()->attach($user);

        Notification::make()
            ->success()
            ->title('Joined Successfully')
            ->body("You have joined \"{$project->title}\".")
            ->send();

        return $project;
    }
}
