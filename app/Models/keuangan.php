<?php

namespace App\Models;

use App\Models\User;
use App\Models\Keluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class keuangan extends Model
{
    /** @use HasFactory<\Database\Factories\KeuanganFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jumlah_transfer',
        'bulan',
        'foto_bukti',
        'waktu_upload',
        'penerima'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
