<?php

namespace App\Filament\Pages;

use App\Models\Itineraie;
use App\Models\Localite;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class ItineraiePage extends Page implements HasTable
{

    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = "Itineraies";
    protected static ?string $title = "Itineraies";
    protected static ?string $navigationGroup = "PARAMETRES";
    protected static string $view = 'filament.pages.itineraie-page';

    public function getTableQuery()
    {
        return Itineraie::query()->with('origine','destination');
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('id'),
          TextColumn::make('origine.name')->searchable(),
          TextColumn::make('destination.name')->searchable(),
          TextColumn::make('prix')->sortable(),
        ];
    }

    public function getTableHeaderActions()
    {
        return [
          CreateAction::make('create')->label("Ajouter")
            ->form([
                Grid::make(3)->schema([
                    Select::make('origine_id')->options(Localite::all()->pluck('name','id'))
                        ->label("Origine")
                        ->relationship('origine','name'),
                    Select::make('destination_id')->options(Localite::all()->pluck('name','id'))
                        ->label("Destination")
                        ->relationship('destination','name'),
                    TextInput::make('prix')->suffix('FCFA')
                ])
            ])
        ];
    }
}
