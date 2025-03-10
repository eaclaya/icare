<?php
namespace App\Filament\Resources;

use App\Events\NewChatMessage;
use App\Filament\Resources\AffiliateResource\Pages;
use App\Models\Affiliate;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class AffiliateResource extends Resource
{
    protected static ?string $model = Affiliate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Name (stored as the ID)
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Affiliate Name'),

                TextInput::make('subdomain')
                    ->required()
                    ->maxLength(255)
                    ->unique('tenants', 'id')
                    ->regex('/^[a-z0-9]+$/')
                    ->label('Affiliate Subdomain')
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
                TextColumn::make('id')
                    ->searchable()
                    ->label('Affiliate Name'),

                // Domain (from JSON data)
                TextColumn::make('data->domain')
                    ->searchable()
                    ->label('Domain'),

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
            'index' => Pages\ListAffiliates::route('/'),
            'create' => Pages\CreateAffiliate::route('/create'),
            'edit' => Pages\EditAffiliate::route('/{record}/edit'),
        ];
    }
}
