<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keluarga;
use App\Models\keuangan;
use Illuminate\Http\Request;
use App\Imports\KeuanganImport;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class BendaharaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $keuangan = keuangan::with('user.keluarga');

        if (!empty($search)) {
            $keuangan->where(function($query) use ($search) {
                $query->where('jumlah_transfer', 'like', "%{$search}%")
                    ->orWhere('bulan', 'like', "%{$search}%")
                    ->orWhere('penerima', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhereHas('keluarga', function($qq) use ($search) {
                                $qq->where('nama_keluarga', 'like', "%{$search}%")
                                ->orWhere('email_keluarga', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $keuangan = $keuangan->paginate(10)->withQueryString();

        return view('bendahara.dashboard', compact('keuangan'));
    }

    public function register()
    {
        $keluarga = Keluarga::all();
        return view('auth.register',compact('keluarga'));
    }

    public function registrasi(Request $request)
    {
        $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        User::create([
            'keluarga_id' => $request->keluarga_id,
            'usertype' => 'user',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan!');

        return redirect()->route('bendahara.register')->with('Success', 'Data berhasil ditambahkan!');

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view ('auth.register');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new KeuanganImport, $request->file('import'));

        Alert::success('Berhasil', 'Data berhasil diimpor!');

        return back()->with('success', 'Data keuangan berhasil diimpor!');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
