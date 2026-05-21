<?php
namespace App\Filament\Pages\Auth;

use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;
use Override;

class Login extends BaseLogin
{
    use HasCustomLayout;

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
                // GRecaptcha::make('captcha')
                //     ->hiddenLabel()
                //     ->required()
            ]);
    }

    #[Override]
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email'    => $data['email'],
            'password' => $data['password'],
        ];
    }

    #[Override]
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        $user = Filament::auth()->user();

        if (! $user->is_active) {
            Filament::auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            Notification::make()
                ->title('Account Deactivated')
                ->body('Your account has been deactivated. Please contact support.')
                ->danger()
                ->persistent()
                ->send();

            /*
            * Adding error validation label below the email.
            * This making the page expired
            *
            * throw ValidationException::withMessages([
            *    'data.email' => 'Your account has been deactivated. Please contact support.'
            * ]);
            */
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
