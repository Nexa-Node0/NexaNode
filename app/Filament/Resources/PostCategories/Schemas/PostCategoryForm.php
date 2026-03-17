<?php

namespace App\Filament\Resources\PostCategories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;

class PostCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur:true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => 
                                $set('slug', Str::slug($state ?? ''))),
                
                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                
                RichEditor::make('description')
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
                            ]),
                            
                Toggle::make('is_visible')
                    ->label('Visibility')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true)
            ]);
    }
}
