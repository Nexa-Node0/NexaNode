<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use Filament\Schemas\Schema;
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
                GRecaptcha::make('captcha')
                    ->hiddenLabel()
                    ->required()
            ]);
    }

    #[Override]
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email'     => $data['email'],
            'password'  => $data['password']
        ];
    }
}
