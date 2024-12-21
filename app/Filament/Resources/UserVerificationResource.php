<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserVerificationResource\Pages;
use App\Models\UserVerification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;

class UserVerificationResource extends Resource
{
    protected static ?string $model = UserVerification::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),
                
                TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(20),
                
                Toggle::make('phone_verified')
                    ->default(false),
                
                Forms\Components\Textarea::make('address')
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Toggle::make('address_verified')
                    ->default(false),
                
                Select::make('id_type')
                    ->options([
                        'passport' => 'Passport',
                        'drivers_license' => 'Driver\'s License',
                        'national_id' => 'National ID Card',
                    ]),
                
                FileUpload::make('id_front_path')
                    ->image()
                    ->directory('id-documents')
                    ->visibility('private')
                    ->maxSize(5120),
                
                FileUpload::make('id_back_path')
                    ->image()
                    ->directory('id-documents')
                    ->visibility('private')
                    ->maxSize(5120),
                
                FileUpload::make('selfie_path')
                    ->image()
                    ->directory('selfies')
                    ->visibility('private')
                    ->maxSize(5120),
                
                Toggle::make('biometric_verified')
                    ->default(false),
                
                Select::make('stage')
                    ->options([
                        1 => 'Stage 1',
                        2 => 'Stage 2',
                    ])
                    ->default(1)
                    ->required(),
                
                TextInput::make('max_transactions')
                    ->numeric()
                    ->default(3)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                
                ToggleColumn::make('phone_verified'),
                ToggleColumn::make('address_verified'),
                ToggleColumn::make('biometric_verified'),
                
                TextColumn::make('stage')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        default => 'gray',
                    }),
                
                TextColumn::make('max_transactions'),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stage')
                    ->options([
                        1 => 'Stage 1',
                        2 => 'Stage 2',
                    ]),
                Tables\Filters\TernaryFilter::make('phone_verified'),
                Tables\Filters\TernaryFilter::make('address_verified'),
                Tables\Filters\TernaryFilter::make('biometric_verified'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserVerifications::route('/'),
            'create' => Pages\CreateUserVerification::route('/create'),
            'edit' => Pages\EditUserVerification::route('/{record}/edit'),
            'view' => Pages\ViewUserVerification::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('biometric_verified', false)->count();
    }
} 