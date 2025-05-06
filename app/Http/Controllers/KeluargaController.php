<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $keluarga = Keluarga::query();

        if (!empty($search)) {
            $keluarga->where(function($query) use ($search) {
                $query->where('nama_keluarga', 'like', "%{$search}%")
                      ->orWhere('email_keluarga', 'like', "%{$search}%");
            });
        }

        $keluarga = $keluarga->paginate(5)->withQueryString();

        return view ('keluarga.index', compact('keluarga'));
    }

    public function index2(Request $request)
    {

        $user = User::where('usertype', '!=', 'bendahara')->paginate(10);
        return view ('keluarga.index2', compact('user'));

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
            "nama_keluarga" => "required",
            "email_keluarga" => "required"
        ]);

        Keluarga::create([
            "nama_keluarga" => $request->nama_keluarga,
            "email_keluarga" => $request->email_keluarga
        ]);

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan!');

        return redirect()->route('keluarga.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        $keluarga = Keluarga::findOrFail($id);

        $request->validate([
            "nama_keluarga" => "required",
            "email_keluarga" => "required"
        ]);

        $keluarga->update([
            "nama_keluarga" => $request->nama_keluarga,
            "email_keluarga" => $request->email_keluarga
        ]);

        Alert::success('Sukses!', 'Data Berhasil Diupdate!');

        return redirect()->route('keluarga.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $keluarga->delete();

        Alert::success('Sukses!', 'Data Berhasil Dihapus!');

        return redirect()->route('keluarga.index');
    }
}
