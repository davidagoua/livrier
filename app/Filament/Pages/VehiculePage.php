<?php

namespace App\Filament\Pages;

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

class VehiculePage extends Page implements HasTable
{

    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = "Vehicules";
    protected static ?string $navigationLabel = "Vehicules";
    protected static string $view = 'filament.pages.vehicule';
    protected static ?string $navigationGroup = "PARAMETRES";

    public function getTableQuery()
    {
        return Vehicule::query();
    }

    protected static function getNavigationBadge(): ?string
    {
        return Vehicule::query()->count();
    }

    public function getTableHeaderActions(): array
    {
        return [
            Action::make('add')->label("Ajouter un vehicule")
                ->button()
                ->action(function($data){
                    Vehicule::create($data);
                    Filament::notify('success', "Vehicule crée");
                })
                ->form([
                    Grid::make(['default'=>2])->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('matricule')->required(),
                    ]),
                ])
        ];
    }

    public function getTableColumns() : array
    {
        return [
          TextColumn::make('name'),
          TextColumn::make('matricule')
        ];
    }

    public function getTableActions(): array
    {
        return [
          EditAction::make(),
          Action::make('Attribuer')
            ->button()
            ->action(function($record, $data){

            })
            ->form([
                Select::make('livreur')->options(User::role('livreur')->get()->pluck('name','id'))
            ])
        ];
    }
}
