<?php

namespace App\Filament\Pages;

use App\Models\Livraison;
use Filament\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class LivraisonComplete extends Page implements HasTable
{

    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = "LIVRAISONS";
    protected static string $view = 'filament.pages.livraison-complete';

    public function getTableQuery()
    {
        return Livraison::currentStatus('delivre');
    }

    protected static function getNavigationBadge(): ?string
    {
        return Livraison::currentStatus('delivre')->count();
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('client.name'),
            TextColumn::make('prix')
                ->suffix('FCFA')
                ->label("Coût du colis"),
            TextColumn::make('itineraie.origine.name'),
            TextColumn::make('itineraie.destination.name'),
            BadgeColumn::make('status')->getStateUsing(fn($record)=> $record->status)
        ];
    }
}
