<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('sneat-1.0.0/') }}/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Data Keuangan Keluarga</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat-1.0.0/') }}/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/') }}/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{ asset('sneat-1.0.0/') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('sneat-1.0.0/') }}/assets/js/config.js"></script>
  </head>

  <body>

    @include('sweetalert::alert')

    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">

              <h4 class="mb-2 text-center"><b>Register</b></h4>
              <p class="mb-4 text-center">Silakan register akun terlebih dahulu!</p>

              <form id="formAuthentication" class="mb-3" action="{{ route('bendahara.registrasi') }}" method="POST">

                @csrf

                <div class="mb-3">


                        <div class="mb-4">

                            <a class="text-danger" href="{{ route('bendahara.index') }}">< Kembali ke Beranda </a>

                        </div>

                    @php

                        use App\Models\Keluarga;


                        $keluarga = Keluarga::all();

                    @endphp

                    <div class="mb-3">
                        <label for="keluarga_id" class="form-label">Nama Keluarga</label>
                        <select class="form-control" id="keluarga_id" name="keluarga_id">
                            <option value="">-- Pilih Keluarga --</option>
                            @foreach ($keluarga as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_keluarga }}</option>
                            @endforeach
                        </select>

                        @error('keluarga_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- USERTYPE DEFAULT : USER --}}

                <div class="mb-3">
                    <label for="email" class="form-label">Nama User</label>
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      name="name"
                      placeholder="masukkan nama..."
                      autofocus
                    />

                    @error('name')
                      <small class="form-text text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email User</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="masukkan email..."
                    autofocus
                  />

                  @error('email')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror

                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="masukkan password"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                  </div>

                  @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                  @enderror

                </div>

                <div class="mb-5 form-password-toggle">
                    <div class="d-flex justify-content-between">
                      <label class="form-label" for="password">Konfirmasi Password</label>
                    </div>
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="masukkan password"
                        aria-describedby="password"
                      />
                      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                    </div>

                    @error('password')
                          <small class="form-text text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
                </div>

            </form>

            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('sneat-1.0.0/') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('sneat-1.0.0/') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('sneat-1.0.0/') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('sneat-1.0.0/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('sneat-1.0.0/') }}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('sneat-1.0.0/') }}/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
