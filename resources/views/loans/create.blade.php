{{-- File: resources/views/loans/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <div class="form-container">
        <h1>Tambah Peminjaman</h1>
        <p><a href="{{ route('loans.index') }}">&larr; Kembali ke daftar peminjaman</a></p>

        <form action="{{ route('loans.store') }}" method="POST">
            @csrf

            <label for="member_id">Anggota</label>
            <select name="member_id" id="member_id">
                <option value="">-- Pilih Anggota --</option>
                @foreach ($members as $member)
                    <option value="{{ $member['id'] }}" @selected(old('member_id') == $member['id'])>
                        {{ $member['nama'] }} ({{ $member['nim'] }})
                    </option>
                @endforeach
            </select>
            @error('member_id')
                <div class="error">{{ $message }}</div>
            @enderror

            <p><em>Petugas pencatat: {{ auth()->user()->name }} (otomatis dari akun yang login).</em></p>

            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
            @error('tanggal_pinjam')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="tanggal_kembali">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}">
            @error('tanggal_kembali')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Buku yang Dipinjam</label>
            <div style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; margin-top: 4px; max-height: 200px; overflow-y: auto;">
                @forelse ($books as $book)
                    <label style="display: block; font-weight: normal; margin-top: 4px;">
                        <input type="checkbox" name="book_ids[]" value="{{ $book['id'] }}" style="width: auto;"
                            @checked(in_array($book['id'], old('book_ids', [])))>
                        {{ $book['judul'] }} (stok: {{ $book['stok'] }})
                    </label>
                @empty
                    <p>Belum ada data buku.</p>
                @endforelse
            </div>
            @error('book_ids')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn" style="margin-top: 20px;">Simpan</button>
        </form>
    </div>
@endsection
