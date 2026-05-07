<?php
namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\TechStacksEnum;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Tabs::make()
                    ->schema(fn(string $operation) => [
                        Tab::make('Project Information')
                            ->schema([
                                TextInput::make('title')
                                    ->maxLength(255)
                                    ->required(),

                                TextInput::make('code')
                                    ->maxLength(50)
                                    ->minLength(10)
                                    ->required()
                                    ->trim()
                                    ->regex('/^[a-zA-Z0-9]+$/')
                                    ->validationMessages(['regex' => 'The code must only contain letters and numbers without white spaces'])
                                    ->suffixAction(Action::make('generate_code')
                                            ->icon(Heroicon::ArrowPathRoundedSquare)
                                            ->tooltip('Generate unique code')
                                            ->action(function (callable $set) { // <-- logic goes HERE inside ->action()
                                                $string = Str::random(10);
                                                while (Project::whereCode($string)->exists()) {
                                                    $string = Str::random(10);
                                                }
                                                $set('code', $string);
                                            })
                                    )
                                    ->copyable(copyMessage: 'Code Copied', copyMessageDuration: 1000)
                                    ->rules([
                                        fn($get, $record) => function (string $attribute, $value, \Closure $fail) use ($record) {
                                            if (Project::whereCode($value)->where('id', '!=', $record?->id)->exists()) {
                                                $fail('This code is already taken.');
                                            }
                                        },
                                    ]),

                                FileUpload::make('display')
                                    ->image()
                                    ->disk('public')
                                    ->directory('images/projects/display')
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                MarkdownEditor::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Project Settings')
                            ->schema([
                                Select::make('status')
                                    ->required()
                                    ->options([
                                        'completed'   => 'Completed',
                                        'on_progress' => 'On Progress',
                                        'archived'    => 'Archived',
                                        'pending'     => 'Pending',
                                        'cancelled'   => 'Cancelled',
                                        'failed'      => 'Failed',
                                        'draft'       => 'Draft',
                                    ])
                                    ->selectablePlaceholder(false)
                                    ->default('draft'),

                                Select::make('priority')
                                    ->required()
                                    ->options([
                                        'low'      => 'Low',
                                        'medium'   => 'Medium',
                                        'high'     => 'High',
                                        'critical' => 'Critical',
                                    ])
                                    ->selectablePlaceholder(false)
                                    ->default('medium'),

                                DateTimePicker::make('start_date')
                                    ->required()
                                    ->default(now()),
                            ]),

                        Tab::make('Project Billing')
                            ->schema([
                                TextInput::make('budget_amount')
                                    ->required()
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->prefix('₱')->default(10000.00)
                                    ->step(0.01)
                                    ->minValue(10000.00)
                                    ->maxValue(9999999999.99),

                                TextInput::make('actual_cost')
                                    ->required()
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->prefix('₱')->default(10000.00)
                                    ->step(0.01)
                                    ->minValue(10000.00)
                                    ->maxValue(9999999999.99),
                            ]),

                        Tab::make('Approval and Supervisor')
                            ->schema([
                                Toggle::make('requires_approval')
                                    ->required(),

                                Select::make('supervisor_id')
                                    ->relationship(
                                        'supervisor',
                                        'name',
                                    )
                                    ->required()
                                    ->default(fn() => auth()->user()->id)
                                    ->selectablePlaceholder(false),

                                Select::make('approved_status')
                                    ->required()
                                    ->options([
                                        'approved' => 'Approved',
                                        'pending'  => 'Pending',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->default('pending')
                                    ->selectablePlaceholder(false),

                                Select::make('users')
                                    ->label('Task Members')
                                    ->multiple()
                                    ->relationship('users', 'name')
                                    ->options(fn() => User::query()->pluck('name', 'id'))
                                    ->preload()
                                    ->searchable(),
                            ]),

                        //functions that only available in create
                         ...($operation === 'create' ? [
                            Tab::make('Details')
                                ->schema([
                                    Section::make()
                                        ->relationship('details')
                                        ->schema([
                                            Select::make('client_id')
                                                ->label('Client')
                                                ->options(\App\Models\Client::pluck('name', 'id'))
                                                ->searchable()
                                                ->required(),

                                            TagsInput::make('services')
                                                ->suggestions(ProjectDetail::getCommonServices())
                                                ->required(),

                                            TextInput::make('abstract')
                                                ->required(),

                                            Select::make('tags')
                                                ->options(TechStacksEnum::options())
                                                ->multiple()
                                                ->required(),
                                        ]),
                                ]),

                            Tab::make('Summary')
                                ->schema([
                                    Section::make()
                                        ->relationship('summary')
                                        ->schema([
                                            MarkdownEditor::make('description')
                                                ->label('Tell me more about this Project')
                                                ->required(),

                                            MarkdownEditor::make('goals')
                                                ->label('What is the Goal of this Project?')
                                                ->required(),
                                        ]),
                                ]),
                        ] : []),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
