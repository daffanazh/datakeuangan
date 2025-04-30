<?php

namespace App\Imports;

use App\Models\keuangan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KeuanganImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::where('name', $row['nama_anak'])->first();

        if (!$user) {
            return null;
        }

        return new keuangan([
            'user_id'         => $user->id,
            'jumlah_transfer' => $row['jumlah_transfer'],
            'bulan'           => $row['bulan'],
            'foto_bukti'      => $row['foto_bukti'],
            'waktu_upload'    => Carbon::parse($row['waktu_upload'])->format('H:i:s'),
            'penerima'        => $row['penerima'],
            'deskripsi'       => $row['deskripsi'],
        ]);
    }
}

