<?php

namespace App\Filament\Pages;

use App\Models\LivreurVehicule;
use App\Models\User;
use App\Models\Vehicule;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Hash;

class Livreur extends Page implements HasTable
{

    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = "PARAMETRES";
    protected static string $view = 'filament.pages.livreur';


    public function getTableQuery()
    {
        return User::role('livreur');
    }

    protected static function getNavigationBadge(): ?string
    {
        return User::role('livreur')->count();
    }

    public function getTableHeaderActions(): array
    {
        return [
          Action::make('add')->label("Ajouter un livreur")->button()
            ->action(function($data){
                $user = new User($data);
                $user->password = Hash::make('password2livreur');
                $user->assignRole('livreur');
                $user->save();

                Filament::notify('success', "Livreur enregistré");
            })
            ->form([
                Grid::make(2)->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->required(),
                    TextInput::make('phone')
                        ->prefix("+225")
                        ->required(),
                ])
            ])
        ];
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('name')->searchable(),
          TextColumn::make('phone'),
            TextColumn::make('email'),
            TextColumn::make('vehicule')
            ->getStateUsing(fn($record)=> $record->lastAttribution() ? $record->lastAttribution() ->vehicule->matricule : 'Aucun vehicule')
        ];
    }

    public function getTableActions()
    {
        return [
          EditAction::make('modifier')->button()
              ->form([
                  Grid::make(2)->schema([
                      TextInput::make('name')->required(),
                      TextInput::make('email')->required(),
                      TextInput::make('phone')
                          ->prefix("+225")
                          ->required(),
                  ])
              ]),
            Action::make('attribuer')->label("Attribuer")->button()
                ->form([
                    Select::make('vehicule_id')->options(Vehicule::query()
                        ->whereDoesntHave('attribution')
                        ->get()
                        ->pluck('matricule', 'id')
                    )->label("Vehicule")
                ])
                ->action(function($record, $data){
                    $data['livreur_id'] = $record->id;
                    LivreurVehicule::create($data);
                    Filament::notify('success','Vehicule attribué');
                })
        ];
    }
}
