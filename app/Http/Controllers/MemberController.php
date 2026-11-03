<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        [
            'id' => 1,
            'nama' => 'Ahmad Fauzi',
            'nim' => '220101001',
            'email' => 'fauzi@student.univ.ac.id',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Sukolilo No. 10, Surabaya',
            'status' => 'aktif',
        ],
        [
            'id' => 2,
            'nama' => 'Siti Nurhaliza',
            'nim' => '220101002',
            'email' => 'siti@student.univ.ac.id',
            'nomor_telepon' => '082345678901',
            'alamat' => 'Jl. Gebang Wetan No. 5, Surabaya',
            'status' => 'aktif',
        ],
        [
            'id' => 3,
            'nama' => 'Budi Pratama',
            'nim' => '210101015',
            'email' => 'budi@student.univ.ac.id',
            'nomor_telepon' => '083456789012',
            'alamat' => 'Jl. Keputih Timur No. 12, Surabaya',
            'status' => 'nonaktif',
        ],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "MemberController@destroy, id: {$id}";
    }
}
