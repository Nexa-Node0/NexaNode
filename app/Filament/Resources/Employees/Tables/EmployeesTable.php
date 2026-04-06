<?php
namespace App\Filament\Resources\Employees\Tables;

// use Faker\Core\Color;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('avatar')
                        ->disk('public')
                        ->circular()
                        ->imageSize(80)
                        ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->fullname) . '&color=7F9CF5&background=EBF4FF'),
                    Stack::make([
                        TextColumn::make('fullname')
                            ->sortable()
                            ->searchable()
                            ->weight(FontWeight::Bold),
                        TextColumn::make('is_active')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Online' : 'Offline')
                            ->color(fn($state) => $state ? 'success' : 'danger'),
                    ])->space(1),
                    Stack::make([
                        TextColumn::make('gender')
                            ->formatStateUsing(fn($state) => strtoupper($state))
                            ->searchable()
                            ->icon('heroicon-o-user'),
                        TextColumn::make('phone')
                            ->searchable()
                            ->icon('heroicon-o-phone')
                            ->copyable()
                            ->copyMessage('Phone number copied!'),
                    ])->visibleFrom('md'),
                ]),

                Panel::make([
                    Split::make([
                        TextColumn::make('hire_date')
                            ->label('Hire Date')
                            ->dateTime('M d, Y')
                            ->placeholder('Not yet hired')
                            ->sortable()
                            ->icon('heroicon-o-calendar'),
                        TextColumn::make('is_supervisor')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Supervisor' : 'Regular Employee')
                            ->color(fn($state) => $state ? 'warning' : 'gray')
                            ->icon(fn($state) => $state ? 'heroicon-o-star' : 'heroicon-o-user'),
                    ]),
                    Split::make([
                        TextColumn::make('type')
                            ->formatStateUsing(fn($state) => strtoupper($state))
                            ->weight(FontWeight::Bold)
                            ->sortable()
                            ->badge()
                            ->color('info'),
                        TextColumn::make('salary')
                            ->money('PHP')
                            ->weight(FontWeight::Bold)
                            ->sortable()
                            ->icon('heroicon-o-banknotes')
                            ->color('success'),
                    ]),
                ])->collapsible(),

                // Panel::make([
                //     Split::make([
                //         TextColumn::make('created_at')
                //             ->label('Created')
                //             ->dateTime('M d, Y h:i A')
                //             ->toggleable(isToggledHiddenByDefault: true),
                //         TextColumn::make('updated_at')
                //             ->label('Updated')
                //             ->dateTime('M d, Y h:i A')
                //             ->toggleable(isToggledHiddenByDefault: true),
                //     ]),
                // ])->hiddenFrom('md'),

            ])
            ->stackedOnMobile()
            // ->columnManagerColumns(2)
            ->filters([
                //
            ])
            ->recordActions([

                ViewAction::make(),

                ActionGroup::make([
                    Action::make('hire')
                        ->icon(Heroicon::UserPlus)
                        ->requiresConfirmation()
                        ->action(function (Employee $employee) {
                            $employee->hire_date = now()->toDateTime();
                            $employee->save();
                        })
                        ->successNotificationTitle('The employee has been hired')
                        ->color('info')
                        ->visible(fn($record) => $record->hire_date === null),
                    EditAction::make(),
                ]),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
