<?php
namespace App\Models;

use App\Models\ArsipSurat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriSurat extends Model
{
    use HasFactory;
    protected $table    = 'kategori_surat';
    protected $fillable = ['nama', 'keterangan'];

    public function arsip()
    {
        return $this->hasMany(ArsipSurat::class, 'kategori_id');
    }

}
