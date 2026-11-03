{{-- File: resources/views/members/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <div class="form-container">
        <h1>Detail Anggota</h1>
        <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>

        <table>
            <tr>
                <th style="width: 160px; background: #f3f4f6;">Nama</th>
                <td>{{ $member['nama'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">NIM</th>
                <td>{{ $member['nim'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Email</th>
                <td>{{ $member['email'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">No. Telepon</th>
                <td>{{ $member['nomor_telepon'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Alamat</th>
                <td>{{ $member['alamat'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Status</th>
                <td>{{ ucfirst($member['status']) }}</td>
            </tr>
        </table>
    </div>
@endsection
