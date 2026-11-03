{{-- File: resources/views/loans/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div style="max-width: 600px;">
        <h1>Detail Peminjaman</h1>
        <p><a href="{{ route('loans.index') }}">&larr; Kembali ke daftar peminjaman</a></p>

        <table>
            <tr>
                <th style="width: 160px; background: #f3f4f6;">Anggota</th>
                <td>{{ $loan['member']['nama'] }} ({{ $loan['member']['nim'] }})</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Petugas</th>
                <td>{{ $loan['user']['name'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Tanggal Pinjam</th>
                <td>{{ $loan['tanggal_pinjam'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Tanggal Kembali</th>
                <td>{{ $loan['tanggal_kembali'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Tanggal Dikembalikan</th>
                <td>{{ $loan['tanggal_dikembalikan'] ?? '-' }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Status</th>
                <td>{{ ucfirst($loan['status']) }}</td>
            </tr>
        </table>

        <h2 style="margin-top: 30px;">Buku yang Dipinjam</h2>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loan['loanItems'] as $item)
                    <tr>
                        <td>{{ $item['book']['judul'] }}</td>
                        <td>{{ $item['book']['penulis'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
