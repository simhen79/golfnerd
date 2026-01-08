<?php

namespace App\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login;
use Illuminate\Contracts\Support\Htmlable;

class AdminLogin extends Login
{
    public function getHeading(): string|Htmlable|null
    {
        return __('Admin Login');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('authenticate')
                ->label('Sign in')
                ->submit('authenticate'),
            Action::make('home')
                ->label('Home')
                ->url(route('home'))
                ->color('gray')
                ->outlined(),
        ];
    }
}
