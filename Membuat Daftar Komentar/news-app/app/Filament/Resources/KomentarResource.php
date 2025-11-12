<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Komentar;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KomentarResource\Pages;
use App\Filament\Resources\KomentarResource\RelationManagers;

class KomentarResource extends Resource
{
    protected static ?string $model = Komentar::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    // Kita tidak perlu form, jadi biarkan saja default
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    // Ini adalah bagian utama yang kita ubah
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom 1: Judul Berita (dari relasi 'news')
                TextColumn::make('news.judul')
                    ->label('Judul Berita')
                    ->sortable() // Sesuai permintaan: bisa di-sort
                    ->searchable() // Tambahan: agar bisa dicari
                    ->limit(50),

                // Kolom 2: Nama Komentator
                TextColumn::make('nama')
                    ->label('Nama Komentator')
                    ->sortable() // Sesuai permintaan: bisa di-sort
                    ->searchable(),

                // Kolom 3: Isi Komentar
                TextColumn::make('isi')
                    ->label('Isi Komentar')
                    ->sortable() // Sesuai permintaan: bisa di-sort
                    ->searchable()
                    ->limit(50), // Kita batasi agar tidak terlalu panjang di tabel
            ])
            ->filters([
                //
            ])
            ->actions([
                // Sesuai permintaan: Hanya aksi Hapus
                Tables\Actions\DeleteAction::make(),

                // Kita hapus/tidak tambahkan EditAction
                // Tables\Actions\EditAction::make(),
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

    // Kita ubah bagian ini agar tidak mendaftarkan halaman Create dan Edit
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomentars::route('/'),
            // 'create' => Pages\CreateKomentar::route('/create'), // <--- Dihapus/diberi komentar
            // 'edit' => Pages\EditKomentar::route('/{record}/edit'), // <--- Dihapus/diberi komentar
        ];
    }
}
