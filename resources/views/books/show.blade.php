{{-- File: resources/views/books/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    <div class="form-container">
        <h1>Detail Buku</h1>
        <p><a href="{{ route('books.index') }}">&larr; Kembali ke daftar buku</a></p>

        <table>
            <tr>
                <th style="width: 160px; background: #f3f4f6;">Judul</th>
                <td>{{ $book['judul'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Penulis</th>
                <td>{{ $book['penulis'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Penerbit</th>
                <td>{{ $book['penerbit'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Tahun Terbit</th>
                <td>{{ $book['tahun_terbit'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">ISBN</th>
                <td>{{ $book['isbn'] ?? '-' }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Stok</th>
                <td>{{ $book['stok'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Kategori</th>
                <td>{{ $book['kategori'] }}</td>
            </tr>
        </table>
    </div>
@endsection
