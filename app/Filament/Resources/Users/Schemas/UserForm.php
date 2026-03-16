<?php
namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{

    public static function passwordStrengthScore(?string $password): int
    {
        if (! $password) {
            return 0;
        }

        $score = 0;

        if (strlen($password) >= 8) {
            $score++;
        }

        if (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
            $score++;
        }

        if (preg_match('/[0-9]/', $password)) {
            $score++;
        }

        if (preg_match('/[\W]/', $password)) {
            $score++;
        }

        return $score;
    }

    public static function passwordStrengthColor(?string $password): string
    {
        $score = self::passwordStrengthScore($password);

        return match (true) {
            $score >= 4  => 'success',
            $score === 3 => 'gray',
            $score === 2 => 'warning',
            default      => 'danger',
        };
    }

    public static function passwordStrengthLabel(?string $password): string
    {
        $score = self::passwordStrengthScore($password);

        return match (true) {
            $score >= 4  => 'Strong password',
            $score === 3 => 'Good password',
            $score === 2 => 'Weak password',
            default      => 'Very weak password',
        };
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Information')
                    ->schema([
                        TextInput::make('name')
                            ->autocapitalize()
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->autocomplete('new-email')
                            ->required(),
                    ]),

                Section::make('Password')
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->confirmed()
                            ->rule(
                                Password::min(8)
                                    ->mixedCase()
                                    ->numbers()
                                    ->symbols()
                                    ->uncompromised()
                            )
                            ->live()
                            ->hint(fn($state) => self::passwordStrengthLabel($state))
                            ->hintColor(fn($state) => self::passwordStrengthColor($state))
                            ->autocomplete('new-password')
                            ->required(fn($context) => $context === 'create')
                            ->dehydrated(fn($state) => filled($state)),

                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required(),
                    ]),
            ]);
    }
}
