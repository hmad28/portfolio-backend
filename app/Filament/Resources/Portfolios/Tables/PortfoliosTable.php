<?php

namespace App\Filament\Resources\Portfolios\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class PortfoliosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image'),
                
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('company')
                    ->searchable(),
                
                TextColumn::make('category')
                ->badge(),
                
                TextColumn::make('link')
                    ->url(fn ($record) => $record->link)
                    ->openUrlInNewTab()
                    ->label('Website'),

                SpatieTagsColumn::make('tags'),
                
                ToggleColumn::make('is_published'),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
