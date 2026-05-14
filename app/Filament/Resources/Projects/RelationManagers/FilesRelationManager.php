<?php
namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('path')
                    ->disk('public')
                    ->directory('projects/files')
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state instanceof TemporaryUploadedFile) {
                            return;
                        }

                        $set('disk', 'public');
                        $set('original_name', $state->getClientOriginalName());
                        $set('mime_type', $state->getMimeType());
                        $set('size', $state->getSize());
                    })
                    ->reactive()
                    ->columnSpanFull(),

                // ── Auto-injected fields (invisible to the user) ──────────────
                Hidden::make('disk')
                    ->default('public'),

                Hidden::make('original_name'),

                Hidden::make('mime_type'),

                Hidden::make('size'),
                // ─────────────────────────────────────────────────────────────

                Select::make('type')
                    ->required()
                    ->options([
                        'attachment' => 'Attachment', // generic downloadable file
                        'slide'      => 'Slide',      // carousel/slideshow image
                        'document'   => 'Document',   // PDF, Word, formal docs
                        'video'      => 'Video',      // video file
                        'audio'      => 'Audio',      // audio file
                        'gallery'    => 'Gallery',    // general gallery image
                        /* 'avatar'     => 'Avatar',     // profile/entity photo //alisin ko muna, di kaylangan eh
                        'cover'      => 'Cover',      // hero/banner image
                        'thumbnail'  => 'Thumbnail',  // small preview image */
                    ])
                    ->default('attachment')
                    ->selectablePlaceholder(false),

                TextInput::make('title')
                    ->required(),

                TextInput::make('description'),

                Select::make('visibility')
                    ->required()
                    ->options([
                        'public'  => 'Public',
                        'private' => 'Private',
                    ])
                    ->default('public')
                    ->selectablePlaceholder(false),

                TextInput::make('order_column')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('File')
                    ->searchable()
                    ->tooltip(fn($record) => $record->original_name),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('mime_type')
                    ->label('MIME')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn($state) => $state
                            ? number_format($state / 1024, 1) . ' KB'
                            : '—'
                    ),
                TextColumn::make('visibility')
                    ->badge()
                    ->color(fn($state) => $state === 'public' ? 'success' : 'warning'),
                TextColumn::make('order_column')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('type')
                    ->multiple()
                    ->options([                   //copy lang
                        'attachment' => 'Attachment', // generic downloadable file
                        'slide'      => 'Slide',      // carousel/slideshow image
                        'document'   => 'Document',   // PDF, Word, formal docs
                        'video'      => 'Video',      // video file
                        'audio'      => 'Audio',      // audio file
                        'gallery'    => 'Gallery',    // general gallery image
                        /* 'avatar'     => 'Avatar',     // profile/entity photo //alisin ko muna, di kaylangan eh
                        'cover'      => 'Cover',      // hero/banner image
                        'thumbnail'  => 'Thumbnail',  // small preview image */
                    ])
                    ->default('attachment')
                    ->selectablePlaceholder(false),

            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([

                // ⬇️ DOWNLOAD
                Action::make('download')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->hiddenLabel()
                    ->tooltip('Download')
                    ->visible(fn($record) =>
                        is_null($record->deleted_at) &&
                        $record->type === 'attachment'
                    )
                    ->action(function ($record) {
                        return Storage::disk($record->disk)->download(
                            $record->path,
                            $record->original_name ?? $record->title
                        );
                    }),

                // 👁 PREVIEW
                Action::make('preview')
                    ->icon('heroicon-m-eye')
                    ->hiddenLabel()
                    ->tooltip('Preview')
                    ->visible(fn($record) => is_null($record->deleted_at))
                    ->modalHeading('Preview File')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn($record) => view('filament.modals.file-preview', [
                        'record' => $record,
                        'url'    => Storage::disk($record->disk)->url($record->path),
                    ])),

                EditAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Delete'),

                ForceDeleteAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Permanent Delete'),
                RestoreAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Restore'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
            });
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
