<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $keluargaUsers = User::where('keluarga_id', $user->keluarga_id)->where('id', '!=', $user->id)->get();

        // $keuangan = keuangan::paginate(5);
        $keuangan = \App\Models\keuangan::where('user_id', auth()->id())->paginate(5);


        return view ('user.dashboard',compact('keuangan','user','keluargaUsers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jumlah_transfer' => 'required|numeric|min:40000',
            'bulan'           => 'required|array',
            'foto_bukti'      => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'waktu_upload'    => 'required',
            'penerima'        => 'required|string|max:255',
        ]);

        $nm = $request->file('foto_bukti');
        $namaFile = time() . rand(100, 999) . "." . $nm->getClientOriginalExtension();
        $nm->move(public_path('upload'), $namaFile);

        $bulan = implode(', ', array_map('ucfirst', $request->bulan));

        \App\Models\keuangan::create([
            'user_id'          => auth()->id(),
            'jumlah_transfer'  => $request->jumlah_transfer,
            'bulan'            => $bulan,
            'foto_bukti'       => $namaFile,
            'waktu_upload'     => $request->waktu_upload,
            'penerima'         => $request->penerima
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan!');

        return redirect()->route('keuangan.index')->with('success', 'Data berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'jumlah_transfer' => 'required|numeric|min:40000',
            'bulan'           => 'required|array',
            'foto_bukti'      => 'image|mimes:jpg,png,jpeg|max:2048',
            'waktu_upload'    => 'required',
            'penerima'        => 'required|string|max:255'
        ]);

        $keuangan = keuangan::findOrFail($id);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload'), $namaFile);
        } else {
            $namaFile = $keuangan->foto_bukti;
        }

        $bulan = implode(', ', array_map('ucfirst', $request->bulan));

        $keuangan->update([
            'user_id'          => $request->user_id,
            'jumlah_transfer'  => $request->jumlah_transfer,
            'bulan'            => $bulan,
            'foto_bukti'       => $namaFile,
            'waktu_upload'     => $request->waktu_upload,
            'penerima'         => $request->penerima
        ]);

        Alert::success('Berhasil', 'Data berhasil diupdate!');

        return redirect()->route('keuangan.index')->with('success', 'Data berhasil diupdate!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari datanya
        $keuangan = keuangan::findOrFail($id);

        // Kalau ada foto yang sudah diupload, hapus file nya juga
        if ($keuangan->foto_bukti) {
            $fotoPath = public_path('upload/' . $keuangan->foto_bukti);
            if (file_exists($fotoPath)) {
                unlink($fotoPath); // hapus file dari folder
            }
        }

        // Hapus datanya dari database
        $keuangan->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus!');

        // Redirect balik dengan pesan sukses
        return redirect()->route('keuangan.index')->with('success', 'Data berhasil dihapus!');
    }
}
