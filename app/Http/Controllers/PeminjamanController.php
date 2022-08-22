<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Peminjaman::all();
        $list_ruangan = Ruangan::all();
        $level = auth()->user()->level;

        return view('pages.peminjaman.index', [
            'items' => $items,
            'list_ruangan' => $list_ruangan,
            'level' => $level
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = 'Menunggu';
        $data['status_approv1'] = 'Menunggu';
        $data['status_approv2'] = 'Menunggu';

        Peminjaman::create($data);
        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $status)
    {
        $item = Peminjaman::find($id);
        
        if($status == 'tolak'){
            $item->status = 'Ditolak';
            $item->status_approv1 = 'Ditolak';
            $item->status_approv2 = 'Ditolak';
        }

        if($status == 'status'){
            $item->status = 'Diverifikasi';
        }
        if($status == 'status_approv1'){
            $item->status = 'Disetujui';
        }
        if($status == 'status_approv2'){
            $item->status = 'Disetujui';
        }

        $item->save();
        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Peminjaman::find($id)->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil dihapus');
    }
}
