<?php

namespace App\Http\Controllers;

use App\Models\DataKursus;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    // PENGUNJUNG
    public function home()
    {
        $landingpage = DataKursus::inRandomOrder()->limit(3)->get();
        foreach ($landingpage as $item) {
            $item->deskripsi = \Illuminate\Support\Str::words($item->deskripsi, 26, '...');
        }
        return view('user.home', compact('landingpage'));
    }



    public function kursus()
    {
        $data_kursus = DataKursus::limit(6)->get();
        foreach ($data_kursus as $item) {
            $item->deskripsi = \Illuminate\Support\Str::words($item->deskripsi, 26,);
        }
        return view('user.kursus', compact('data_kursus'));
    }

    public function search(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $kursus = DataKursus::where('nama_kursus', 'LIKE', $query . '%')->get(); // Menampilkan hasil yang dimulai dengan input
        } else {
            $kursus = DataKursus::all();
        }

        return response()->json($kursus);
    }


    public function detail(string $id)
    {
        $data = DataKursus::find($id);
        //   dd($data);
        $imageNames = json_decode($data->img_konten, true);
        return view('user.detailKursus', compact(['data', 'imageNames']));
    }



    public function maps()
    {
        $latilongti = DataKursus::all();
        return view('user.peta', compact('latilongti'));
    }
    public function rute()
    {
        return view('user.rute');
    }
}
