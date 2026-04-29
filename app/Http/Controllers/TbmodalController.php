<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TbModal;

class TbmodalController extends Controller
{
    public function index()
    {
        $data = TbModal::latest()->get();
        return view('dashboard.modal', compact('data'));
    }

    public function store(Request $request)
    {
        TbModal::create([
            'simpanan_pokok' => $request->simpanan_pokok ?? 0,
            'simpanan_wajib' => $request->simpanan_wajib ?? 0,
            'simpanan_sementara' => $request->simpanan_sementara ?? 0,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $data = TbModal::findOrFail($id);

        $data->update([
            'simpanan_pokok' => $request->simpanan_pokok,
            'simpanan_wajib' => $request->simpanan_wajib,
            'simpanan_sementara' => $request->simpanan_sementara,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        TbModal::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}