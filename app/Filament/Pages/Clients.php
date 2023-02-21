<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class Clients extends Page implements HasTable
{

    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.clients';


    public function getTableQuery()
    {
        return User::role('client');
    }

    protected static function getNavigationBadge(): ?string
    {
        return User::role('client')->count();
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('name')->searchable(),
          TextColumn::make('email')
              ->default('Aucun email')->searchable(),
          TextColumn::make('contact')->searchable(),
        ];
    }
}
