<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Models\Tenant;
use App\Models\Family;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Silber\Bouncer\BouncerFacade as Bouncer;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Tenant Name'),

                TextInput::make('subdomain')
                    ->required()
                    ->maxLength(255)
                    ->regex('/^[a-z0-9]+$/')
                    ->label('Tenant Subdomain')
                    ->disabled(fn ($operation) => $operation === 'edit'),

                TextInput::make('contact_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Contact Name'),

                TextInput::make('contact_email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->label('Contact Email'),

                Forms\Components\Textarea::make('street')
                    ->label('Street'),

                TextInput::make('state')
                    ->required()
                    ->label('State'),

                TextInput::make('city')
                    ->required()
                    ->label('City'),

                TextInput::make('zip')
                    ->required()
                    ->label('Zip'),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                // Name (ID)
                TextColumn::make('name')
                    ->searchable()
                    ->label('Tenant Name'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
