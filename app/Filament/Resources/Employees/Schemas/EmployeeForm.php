<?php
namespace App\Filament\Resources\Employees\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Relation')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->searchable()
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                                modifyQueryUsing: function ($query, $record) {
                                    $query->whereDoesntHave('employee');

                                    if($record){
                                        $query->orWhere('id',$record->user->id);
                                    }
                                }
                            )
                            ->default(fn($record) => $record?->user->id)
                            ->disabled(fn($operation) => $operation === 'edit')
                            ->preload()
                            ->required(),
                    ])
                    ->columnSpanFull(),

                Section::make('Personal Information')
                    ->icon(Heroicon::CreditCard)
                    ->schema([
                        Section::make('Full Name')
                            ->icon(Heroicon::Clipboard)
                            ->schema([
                                TextInput::make('firstname')
                                    ->maxLength(100)
                                    ->autocapitalize('words')
                                    ->placeholder('John')
                                    ->required()
                                    ->columnSpan(3),
                                TextInput::make('lastname')
                                    ->maxLength(100)
                                    ->placeholder('Doe')
                                    ->required()
                                    ->columnSpan(3),
                                TextInput::make('extension')
                                    ->placeholder('Sr.')
                                    ->maxLength(10),
                            ])
                            ->columns(7),

                        Group::make()
                            ->schema([
                                Select::make('gender')
                                    ->options([
                                        'male'   => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->native(false)
                                    ->noOptionsMessage('Select a Gender')
                                    ->required(),

                                TextInput::make('phone')
                                    ->tel()
                                    ->prefix('09')
                                    ->regex('/^\d{9}$/')
                                    ->minLength(9)
                                    ->maxLength(9)
                                    ->required()
                                    ->placeholder('123456789')
                                    ->dehydrateStateUsing(fn($state) => '09' . $state),
                            ])
                            ->columns(2),

                        Section::make('Display Picture')
                            ->icon(Heroicon::Photo)
                            ->schema([
                                FileUpload::make('avatar')
                                    ->disk('public')
                                    ->directory('employees')
                                    ->image(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Hiring Information')
                    ->icon(Heroicon::DocumentText)
                    ->schema([
                        Group::make()
                            ->schema([
                                Select::make('type')
                                    ->label('Employee Type')
                                // ->def
                                    ->options([
                                        'parttime' => 'Part Time',
                                        'fulltime' => 'Full Time',
                                        'intern'   => 'Intern',
                                    ])
                                    ->default('parttime')
                                    ->noOptionsMessage('Select a Type')
                                    ->native(false)
                                    ->columnSpan(4),

                                Toggle::make('is_supervisor')
                                    ->inline(false)
                                    ->onIcon(Heroicon::Bolt)
                                    ->onColor('success')
                                    ->offIcon(Heroicon::BoltSlash)
                                    ->offColor('danger')
                                    ->required(),

                            ])
                            ->columns(5),

                        Group::make()
                            ->schema([
                                TextInput::make('salary')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('0.00')
                                    ->prefix('₱')
                                    ->columnSpan(3),

                                DatePicker::make('hire_date')
                                    ->dehydrateStateUsing(fn($state) => $state
                                            ? Carbon::parse($state)->setTimeFrom(Carbon::now())
                                            : null
                                    )
                                    ->columnSpan(2),
                            ])
                            ->columns(5),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}
