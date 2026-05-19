<?php

namespace App\Filament\Resources\Blog\Posts\Schemas;

use App\Enums\PostStatus;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Set $set, ?string $state) =>
                                $set('slug', Str::slug($state ?? ''))
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->columnSpanFull()
                            ->disabled()
                            ->dehydrated()
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('user_id')
                            ->required()
                            ->label('Register this blog to')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('None (top-level-category)'),

                        Forms\Components\Select::make('post_category_id')
                            ->label('Blog Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('published_date')
                            ->native(false),

                        Forms\Components\TagsInput::make('tags')
                            ->placeholder('New tags')
                            ->splitKeys(['Tab', 'Enter'])
                    ])
                    ->columns(2),

                Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions(
                                [
                                    null,
                                    '16:9',
                                    '4:3',
                                    '1:1'
                                ]
                            )
                            ->disk('public')
                            ->directory('thumbnails'),

                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'overflow-x-auto'])
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'subscript',
                                'superscript',
                                'link',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'table',
                                'undo',
                                'redo',
                            ])
                            ->columnSpan(1),
                        Forms\Components\Select::make('status')
                            ->options(PostStatus::options())
                            ->default(PostStatus::Archived->value)
                    ]),
            ]);
    }
}
