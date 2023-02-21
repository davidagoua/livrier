<?php

namespace App\Filament\Pages;

use App\Models\Livraison;
use App\Models\LivreurVehicule;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class LivraisonAttente extends Page implements HasTable
{

    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = "LIVRAISONS";
    protected static string $view = 'filament.pages.livraison-attente';

    public function getTableQuery()
    {
        return Livraison::currentStatus('attente');
    }

    protected static function getNavigationBadge(): ?string
    {
        return Livraison::currentStatus('attente')->count();
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('created_at'),
            TextColumn::make('client.name'),
            TextColumn::make('prix')
                ->suffix('FCFA')
                ->label("Coût du colis"),
            TextColumn::make('itineraie.origine.name'),
            TextColumn::make('itineraie.destination.name'),
        ];
    }

    public function getTableActions() : array
    {
        return [
          Action::make('livreur')
              ->label('Attribuer un livreur')
              ->button()
                ->form([
                    Select::make('attribution_id')->options(LivreurVehicule::all()->map(function($l){
                        return [
                            'livreur'=>$l->livreur->name.' '. $l->vehicule->matricule.' ('.$l->pendingLivraisons()->count().')',
                            'id'=>$l->id
                        ];
                    })->pluck('livreur','id'))->label("Livreur")
                ])
                ->action(function($record,$data){
                    $record->attribution_id = $data['attribution_id'];
                    $record->setStatus('recupere');
                    $record->save();
                })
        ];
    }
}
