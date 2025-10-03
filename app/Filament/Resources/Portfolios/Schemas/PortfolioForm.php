<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')->schema([
                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Set $set) => 
                            $set('slug', Str::slug($state))
                        ),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        
                        TextInput::make('company'),
                        
                        TextInput::make('category'),
                        TextInput::make('link')
                            ->url(),
                        
                        Toggle::make('is_published')
                            ->default(false),
                ])->columns(2),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Tags')
                    ->schema([
                        SpatieTagsInput::make('tags'),
                    ]),

                Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('image')
                            ->image()
                            ->maxFiles(1),
                        
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('gallery')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->maxFiles(10),
                    ]),
            ]);
    }
}
