<?php
namespace App\Filament\Resources\Employees\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //Profile section, and personal details
                Section::make('Profile')
                    ->schema([
                        Group::make()
                            ->schema([
                                //display picture
                                ImageEntry::make('avatar')
                                    ->disk('public')
                                    ->imageWidth(100)
                                    ->imageHeight(100)
                                    ->circular(),

                                TextEntry::make('is_active')
                                    ->hiddenLabel()
                                    ->badge()
                                    ->color(fn($state) => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn($state) => $state ? 'Online' : 'Offline'),
                            ])
                            ->columnSpan(2),

                        //user Credentials
                        Group::make()
                            ->schema([
                                TextEntry::make('user.name'),
                                TextEntry::make('user.email'),
                                TextEntry::make('phone'),
                            ])
                            ->columnSpan(3),
                    ])
                    ->columns(5),

                Section::make('Information')
                    ->schema([
                        //user's full name
                        Group::make()
                            ->schema([
                                TextEntry::make('firstname')
                                    ->columnSpan(2)
                                    ->weight('bold'),
                                TextEntry::make('lastname')
                                    ->columnSpan(2)
                                    ->weight('bold'),
                                TextEntry::make('extension')
                                    ->visible(fn($get) => $get('extension') !== null),
                            ])
                            ->columns(5),

                        //Gender
                        TextEntry::make('gender')
                            ->formatStateUsing(fn($state) => strtoupper($state))
                            ->columnSpanFull(),
                    ]),

                //Hiring information
                Section::make('Hiring Details')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextEntry::make('type'),

                                TextEntry::make('hire_date')
                                    ->dateTime()
                                    ->placeholder('Not Yet Hired'),
                            ])
                            ->columnSpan(1),

                        Group::make()
                            ->schema([
                                TextEntry::make('salary')
                                    ->numeric(),

                                TextEntry::make('is_supervisor')
                                    ->hiddenLabel()
                                    ->color(fn($state) => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn($state) => $state ? 'Supervisor' : 'Regular Employee')
                                    ->icon(fn($state) => $state ? Heroicon::WrenchScrewdriver : Heroicon::Wrench)
                                    ->badge(),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                // Section::make('Table Action')
                //     ->schema([
                //         TextEntry::make('created_at')
                //             ->dateTime()
                //             ->placeholder('-')
                //             ->columnSpan(1),

                //         TextEntry::make('updated_at')
                //             ->dateTime()
                //             ->placeholder('-')
                //             ->columnSpan(1),
                //     ])
                //     ->columns(2)
                //     ->columnSpanFull(),
            ]);
    }
}
