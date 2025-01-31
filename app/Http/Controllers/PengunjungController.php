<?php

namespace App\Http\Controllers;

use App\Models\DataKursus;
use App\Models\DataUlasan;
use App\Models\DataKategori;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Validator;

class PengunjungController extends Controller
{
    // PENGUNJUNG
    public function home()
    {
        // Ambil 3 data yang populer dari tabel DataKursus
        $landingpage = DataKursus::where('popular', 'Popular')
            ->limit(3)
            ->get();

        // Potong deskripsi agar hanya terdiri dari 22 kata
        foreach ($landingpage as $item) {
            $item->deskripsi = \Illuminate\Support\Str::words($item->deskripsi, 22, '...');
        }

        // Kembalikan view dengan data yang sudah diproses
        return view('user.home', compact('landingpage'));
    }





    public function kursus(Request $request)
    {
        $query = DataKursus::query();

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan pencarian nama kursus
        if ($request->filled('search')) {
            $query->where('nama_kursus', 'like', '%' . $request->search . '%');
        }

        // Ambil data kursus secara acak dengan kategori
        $data_kursus = $query->with('kategoris')->inRandomOrder()->paginate(10);

        // Ambil daftar kategori untuk dropdown
        $kategori = DataKategori::all();

        return view('user.kursus', compact('data_kursus', 'kategori'));
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
    public function maps()
    {
        $latilongti = DataKursus::all();
        return view('user.peta', compact('latilongti'));
    }


    public function detail(string $id)
    {
        // Ambil data kursus beserta ulasan dan kategorinya
        $data = DataKursus::with('kategoris', 'ulasan')->find($id);

        if (!$data) {
            abort(404, 'Kursus tidak ditemukan');
        }

        // Ambil data ulasan terkait, urutkan berdasarkan created_at terbaru
        $imageNames = json_decode($data->img_konten, true);
        $ulasan = $data->ulasan()->orderBy('created_at', 'desc')->paginate(3);  // Membatasi hanya 3 ulasan per halaman, urutan terbaru

        // Hitung rata-rata rating
        $averageRating = $ulasan->avg('rating'); // Mengambil rata-rata rating
        $totalRatings = $ulasan->count(); // Menghitung total jumlah ulasan

        // Kirim data ke view
        return view('user.detailKursus', compact('data', 'imageNames', 'ulasan', 'averageRating', 'totalRatings'));
    }






    public function rute(string $id)
    {
        // Ambil kursus berdasarkan ID
        $ruteTerdekat = DataKursus::find($id);

        // Jika data tidak ditemukan, bisa menampilkan halaman error atau redirect


        return view('user.rute', compact('ruteTerdekat'));
    }



    public function gagal()
    {
        return view('gagal.gagal');
    }

    public function storeUlasann(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000',
                'kursus_id' => 'required', // Pastikan kursus_id valid
                'user_id' => 'required'
            ]);

            // Jika validasi gagal, redirect kembali dengan pesan error
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)  // Mengirimkan pesan error ke halaman sebelumnya
                    ->withInput();  // Menyertakan input sebelumnya agar tidak hilang
            }

            // Jika validasi berhasil, simpan data ulasan
            DataUlasan::create([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'kursus_id' => $request->kursus_id,
                'user_id' => $request->user_id, // Ambil ID pengguna yang sedang login
            ]);

            // Berhasil menyimpan, redirect ke halaman detail kursus dengan parameter id
            return redirect()->route('kursus.detail', ['id' => $request->kursus_id])
                ->with('success', 'Ulasan Berhasil Ditambahkan');
        } catch (\Exception $e) {
            // Jika terjadi error dalam proses penyimpanan data
            return redirect()->route('kursus.detail', ['id' => $request->kursus_id])
                ->with('error', 'Data Error: ' . $e->getMessage());
        }
    }
}
