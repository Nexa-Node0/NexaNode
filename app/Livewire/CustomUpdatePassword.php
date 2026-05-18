<?php

namespace App\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;

class CustomUpdatePassword extends MyProfileComponent
{
    protected string $view = 'livewire.custom-update-password';


    public static $sort = 20;

    public array $data = [];
    public $user;

    public function mount(): void
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->revealable()
                    ->password()
                    ->required()
                    ->columnSpanFull()
                    ->currentPassword(),

                TextInput::make('password')
                    ->label('New Password')
                    ->revealable()
                    ->password()
                    ->required()
                    ->rules([Password::defaults()->mixedCase()->numbers()])
                    ->same('password_confirmation'),

                TextInput::make('password_confirmation')
                    ->label('Confirm New Password')
                    ->revealable()
                    ->password()
                    ->required(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $this->user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->form->fill(); // reset the form

        Notification::make()
            ->success()
            ->title('Password updated successfully!')
            ->body('Your password has been changed. Please use it on your next login.')
            ->send();
    }
}
