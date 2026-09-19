@extends('layouts.admin')

@section('title', 'Pengaturan Akun')
@section('heading', 'Pengaturan Akun')

@section('content')
    <section class="card formCard">
        <h2 style="font:500 25px Georgia,serif;margin:0 0 8px">Login administrator</h2>
        <p class="hint">Ubah username atau password admin. Masukkan password saat ini untuk mengonfirmasi perubahan.</p>

        @if($errors->any())
            <div class="alert error">Ada data yang belum benar. Periksa kolom yang ditandai.</div>
        @endif

        <form method="POST" action="{{ route('admin.account.update') }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" value="{{ old('username', $admin->username) }}" required>
                @error('username')<div class="errorText">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="current_password">Password saat ini</label>
                <input id="current_password" type="password" name="current_password" autocomplete="current-password" required>
                @error('current_password')<div class="errorText">{{ $message }}</div>@enderror
            </div>

            <div class="separator"></div>

            <div class="field">
                <label for="password">Password baru <span class="muted">(opsional)</span></label>
                <input id="password" type="password" name="password" autocomplete="new-password">
                @error('password')<div class="errorText">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Ulangi password baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
            </div>

            <button class="btn" type="submit">Simpan Perubahan</button>
        </form>
    </section>
@endsection
