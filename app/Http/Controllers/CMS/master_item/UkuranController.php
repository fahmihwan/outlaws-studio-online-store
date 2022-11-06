<?php

namespace App\Http\Controllers\CMS\master_item;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Ukuran::with('kategori:id,nama')->latest()->get();


        return view('cms.pages.master_item.ukuran.index', [
            'kategories' => Kategori::latest()->get(),
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required|numeric'
        ]);

        Ukuran::create($validated);
        return redirect('/admin/master-item/ukuran');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cms.pages.master_item.ukuran.edit', [
            'item' =>  Ukuran::with('kategori')->where('id', $id)->first(),
            'kategories' => Kategori::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required|numeric'
        ]);

        Ukuran::where('id', $id)->update($validated);
        return redirect('/admin/master-item/ukuran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ukuran::destroy($id);
        return redirect()->back();
    }
}
