<?php

namespace App\Livewire;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Jeffgreco13\FilamentBreezy\Actions\PasswordButtonAction;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;

class DeleteAccount extends MyProfileComponent
{

    protected string $view = 'livewire.delete-account';
    public static $sort = 100;
    public $user;

    public function mount(): void
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                PasswordButtonAction::make('deleteAccount')
                    ->label('Delete My Account')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->modalHeading('Confirm Account Deletion')
                    ->requiresConfirmation()
                    ->action(function () {
                        Auth::logout();
                        $this->user->delete();
                        request()->session()->invalidate();
                        request()->session()->regenerateToken();
                        $this->redirect(route('filament.admin.auth.login'));
                    })
            ]);
    }
}
