@extends('template.back')
@section('konten')

    @include('sweetalert::alert')

    <div class="card">

        <div class="table-responsive text-nowrap">

            <table class="table">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif


                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h3 class="card-header"><b>Data Keuangan</b></h3>

                    <div class="d-flex justify-content-end gap-2 me-5">

                        <button class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#backDropModal"><i class="bx bx-plus-circle me-1"></i> Tambah Data</button>

                    </div>

                </div>


                <thead>

                    <tr class="text-center">

                        <th>No</th>

                        <th>Jumlah Transfer</th>

                        <th>Bulan</th>

                        <th>Foto Bukti</th>

                        <th>Waktu Upload</th>

                        <th>Penerima</th>

                        <th>Deskripsi</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody class="table-border-bottom-0">

                    @php
                        $no = 1;
                    @endphp

                    @if($keuangan->count() > 0)

                    @foreach($keuangan as $index => $item)

                    <tr class="text-center">

                        <td class="p-3">{{ ($keuangan->currentPage() - 1) * $keuangan->perPage() + $index + 1 }}</td>

                        <td class="p-3">{{$item->jumlah_transfer}}</td>

                        <td class="p-3">{{$item->bulan}}</td>

                        <td class="p-3"><img src="{{asset('upload/'.$item->foto_bukti)}}" width="50%" alt=""></td>

                        <td class="p-3">{{$item->waktu_upload}}</td>

                        <td class="p-3">{{$item->penerima}}</td>

                        <td class="p-3">{{$item->deskripsi}}</td>

                        <td class="p-3">

                            <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="bx bx-edit-alt me-1"></i>Edit</button></a>

                            <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" style="display: inline;" class="form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Yakin mau hapus?')">
                                    <i class="bx bx-trash me-1"></i> Hapus
                                </button>
                            </form>

                        </td>

                    </tr>

                    @endforeach

                    @else
                        <tr class="pt-5">
                            <td colspan="8" class="text-center">
                                <strong>Belum ada data keuangan. Silakan tambah data!</strong>
                            </td>
                        </tr>
                    @endif

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $keuangan->links() }}
        </div>

    </div>


    {{-- MODAL TAMBAH DATA --}}

    <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">

        <div class="modal-dialog">

            <form class="modal-content" action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title" id="backDropModalTitle">Tambah Data</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="row g-2">

                        @foreach ($keuangan as $item)
                            <input type="hidden" name="user_id" value="{{ $item->user->id ?? '' }}">
                        @endforeach


                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Nama Orang Tua</b></label>

                            <input type="text" name="nama_keluarga" id="nama_keluarga" class="form-control" readonly value="{{ $user->keluarga->nama_keluarga }}"/>

                        </div>

                        <div class="col mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Email Orang Tua</b></label>

                            <input type="text" name="email_keluarga" id="email_keluarga" class="form-control" readonly value="{{ $user->keluarga->email_keluarga }}"/>

                        </div>

                    </div>

                    <div class="row g-2 mt-3">

                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Nama Anak</b></label>

                            <input type="text" name="name" id="name" class="form-control" readonly value="{{ $user->name }}"/>

                        </div>

                        <div class="col mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Jumlah Transfer</b></label>

                            <input type="number" value="{{ old('jumlah_transfer') }}" name="jumlah_transfer" id="jumlah_transfer" class="form-control" placeholder="Masukkan jumlah transfer..."/>

                            @error('jumlah_transfer')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Bulan</b></label>

                            <div class="d-flex flex-wrap mb-0">
                                @php
                                    $bulan = ['Januari', 'mebruari', 'maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                @foreach($bulan as $index => $bln)
                                    <div class="form-check me-3 mb-2">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="bulan[]"
                                            id="bulan{{ $index+1 }}"
                                            value="{{ $bln }}"
                                        />
                                        <label class="form-check-label" for="bulan{{ $index+1 }}">{{ ucfirst($bln) }}</label>
                                    </div>
                                @endforeach
                            </div>

                            @error('bulan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror



                        </div>

                    </div>

                    <div class="row g-2 mt-3">

                        <div class="col mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Upload Foto Bukti</b></label>

                            <input type="file" value="{{ old('foto_bukti') }}" name="foto_bukti" id="foto_bukti" class="form-control" placeholder="Masukkan bukti transfer..."/>

                            @error('foto_bukti')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Waktu Upload</b></label>

                            <input type="time" value="{{ old('waktu_upload') }}" name="waktu_upload" id="waktu_upload" class="form-control" placeholder="xxxx@xxx.xx"/>

                            @error('waktu_upload')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="row g-2 mt-3">

                        <div class="col-6 mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Nama Penerima</b></label>

                            <input type="text" value="{{ old('penerima') }}" name="penerima" id="penerima" class="form-control" placeholder="Masukkan nama penerima..."/>

                            @error('penerima')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-6 mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Deskripsi</b></label>

                            <input type="text" value="{{ old('deskripsi') }}" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan deskripsi..."/>

                            @error('deskripsi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> Close </button>

                    <button type="submit" class="btn btn-primary">Simpan</button>

                </div>

            </form>

        </div>

    </div>

    {{-- MODAL EDIT DATA --}}

    @foreach($keuangan as $index => $item)

    <div class="modal fade" id="editModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1">

        <div class="modal-dialog">

            <form class="modal-content" action="{{ route('keuangan.update', $item->id) }}" method="POST" enctype="multipart/form-data">

                @csrf

                @method('PUT')

                <div class="modal-header">

                    <h5 class="modal-title" id="backDropModalTitle">Edit Data</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="row g-2">

                        @foreach ($keuangan as $items)
                            <input type="hidden" name="user_id" value="{{ $items->user->id ?? '' }}">
                        @endforeach


                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Nama Orang Tua</b></label>

                            <input type="text" name="nama_keluarga" id="nama_keluarga" class="form-control" readonly value="{{ $user->keluarga->nama_keluarga }}"/>

                        </div>

                        <div class="col mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Email Orang Tua</b></label>

                            <input type="text" name="email_keluarga" id="email_keluarga" class="form-control" readonly value="{{ $user->keluarga->email_keluarga }}"/>

                        </div>

                    </div>

                    <div class="row g-2 mt-3">

                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Nama Anak</b></label>

                            <input type="text" name="name" id="name" class="form-control" readonly value="{{ $user->name }}"/>

                        </div>

                        <div class="col mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Jumlah Transfer</b></label>

                            <input type="number" value="{{ old('jumlah_transfer', $item->jumlah_transfer) }}" name="jumlah_transfer" id="jumlah_transfer" class="form-control" placeholder="Masukkan jumlah transfer..."/>

                            @error('jumlah_transfer')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Bulan</b></label>

                            <div class="d-flex flex-wrap mb-0">
                                @php
                                    $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    $bulanTerpilih = explode(', ', $item->bulan);
                                @endphp

                                @foreach($daftarBulan as $index => $bln)
                                    <div class="form-check me-3 mb-2">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="bulan[]"
                                            id="bulan{{ $index+1 }}"
                                            value="{{ $bln }}"
                                            {{ in_array($bln, $bulanTerpilih) ? 'checked' : '' }}  {{-- <-- Tambahkan ini --}}
                                        />
                                        <label class="form-check-label" for="bulan{{ $index+1 }}">{{ ucfirst($bln) }}</label>
                                    </div>
                                @endforeach
                            </div>

                            @error('bulan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="row g-2 mt-3">

                        <div class="col mb-0">
                            <label for="dobBackdrop" class="form-label"><b>Upload Foto Bukti</b></label>

                            <input type="file" name="foto_bukti" id="foto_bukti" class="form-control" placeholder="Masukkan bukti transfer..." />

                            @if($item->foto_bukti)
                                <div class="mt-3">
                                    <td class="p-3"><img src="{{asset('upload/'.$item->foto_bukti)}}" width="50%" alt=""></td>
                                </div>
                            @endif

                            @error('foto_bukti')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>


                        <div class="col mb-0">

                            <label for="emailBackdrop" class="form-label"><b>Waktu Upload</b></label>

                            <input type="time" value="{{ old('waktu_upload', $item->waktu_upload) }}" name="waktu_upload" id="waktu_upload" class="form-control" placeholder="xxxx@xxx.xx"/>

                            @error('waktu_upload')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="row g-2 mt-3">

                        <div class="col-6 mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Nama Penerima</b></label>

                            <input type="text" value="{{ old('penerima', $item->penerima) }}" name="penerima" id="penerima" class="form-control" placeholder="Masukkan nama penerima..."/>

                            @error('penerima')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-6 mb-0">

                            <label for="dobBackdrop" class="form-label"><b>Deskripsi</b></label>

                            <input type="text" value="{{ old('deskripsi', $item->deskripsi) }}" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan deskripsi..."/>

                            @error('deskripsi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> Close </button>

                    <button type="submit" class="btn btn-primary">Simpan</button>

                </div>

            </form>

        </div>

    </div>

    @endforeach

    @if(session('open_edit_modal_id'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var editModalId = "{{ session('open_edit_modal_id') }}";
                var modal = new bootstrap.Modal(document.getElementById('editModal' + editModalId));
                modal.show();
            });
        </script>
    @endif


@endsection
