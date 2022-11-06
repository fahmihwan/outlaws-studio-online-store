<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
            'telp' => 'required|numeric'
        ]);

        $validated['telp'] = '62' . $validated['telp'];
        $validated['user_id'] = auth()->user()->id;
        Alamat::create($validated);
        return redirect()->back();
    }
    public function delete()
    {
        return 'ok';
    }
    public function update()
    {
        return 'ok';
    }
}
