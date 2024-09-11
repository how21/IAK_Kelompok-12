<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\dataset;


class DatasetController extends Controller
{
    public function dashboard(Request $request)
    {
        // untuk dropdown
        $pokokOptions = dataset::select('pokok')->distinct()->get();
        $tingkatOptions = dataset::select('tingkat')->distinct()->get();
        $ketOptions = dataset::select('ket')->distinct()->get();
        $provinsiOptions = dataset::select('provinsi')->distinct()->get();
    
        // Query dasar untuk Dataset
        $query = dataset::query();
    
        // filter input untuk form
        if ($request->has('pokok') && $request->pokok != '') {
            $query->where('pokok', 'like', '%' . $request->pokok . '%');
        }
        if ($request->has('tingkat') && $request->tingkat != '') {
            $query->where('tingkat', $request->tingkat);
        }
        if ($request->has('ket') && $request->ket != '') {
            $query->where('ket', $request->ket);
        }
        if ($request->has('provinsi') && $request->provinsi != '') {
            $query->where('provinsi', 'like', '%' . $request->provinsi . '%');
        }
        if ($request->has('nilai') && $request->nilai != '') {
            $query->where('nilai', $request->nilai);
        }
    
        // pagination
        $datasets = $query->paginate(20);
    
        // Hitung total nilai untuk setiap pokok
        $jumlahGuru = dataset::where('pokok', 'Guru')->sum('nilai');
        $jumlahSiswa = dataset::where('pokok', 'Siswa')->sum('nilai');
        $jumlahPegawai = dataset::where('pokok', 'Pegawai')->sum('nilai');
        $jumlahSekolah = dataset::where('pokok', 'Sekolah')->sum('nilai');
        $jumlahRuangKelas = dataset::where('pokok', 'Ruang Kelas')->sum('nilai');
    
        // Kembalikan ke view, sambil meneruskan filter melalui request->query()
        return view('dashboard', compact('datasets', 'pokokOptions', 'tingkatOptions', 'ketOptions', 'provinsiOptions', 'jumlahGuru', 'jumlahSiswa', 'jumlahPegawai', 'jumlahSekolah', 'jumlahRuangKelas'))->with($request->query());
    }
    

    public function Piecharts(Request $request)
    {
        $pokok = $request->input('pokok', 'guru');
        $tingkat = $request->input('tingkat', null); // Null untuk semua tingkat
        $provinsi = $request->input('provinsi', null); // Null untuk semua provinsi
    
        $provinsiList = Dataset::distinct('provinsi')->pluck('provinsi');
    
        $query = Dataset::query();
    
        if ($pokok) {
            $query->where('pokok', $pokok);
        }
        
        if ($tingkat) {
            $query->where('tingkat', $tingkat);
        }
        
        if ($provinsi) {
            $query->where('provinsi', $provinsi);
        }
    
        // Ambil data
        $data = $query->get();
    
        // Format data 
        $categories = $data->groupBy('ket')->map(function ($group) {
            return $group->sum('nilai');
        });
    
        // Hitung jumlah berdasarkan kategori
        $total = [
            'guru_laki' => Dataset::where('pokok', 'guru')->where('ket', 'L')->sum('nilai'),
            'siswa_laki' => Dataset::where('pokok', 'siswa')->where('ket', 'L')->sum('nilai'),
            'pegawai_laki' => Dataset::where('pokok', 'pegawai')->where('ket', 'L')->sum('nilai'),
            'sekolah_negeri' => Dataset::where('pokok', 'sekolah')->where('ket', 'N')->sum('nilai'),
            'guru_perempuan' => Dataset::where('pokok', 'guru')->where('ket', 'P')->sum('nilai'),
            'siswa_perempuan' => Dataset::where('pokok', 'siswa')->where('ket', 'P')->sum('nilai'),
            'pegawai_perempuan' => Dataset::where('pokok', 'pegawai')->where('ket', 'P')->sum('nilai'),
            'sekolah_swasta' => Dataset::where('pokok', 'sekolah')->where('ket', 'S')->sum('nilai'),
        ];
    
        // Kirim data ke view
        return view('Piecharts', [
            'categories' => $categories,
            'selectedPokok' => $pokok,
            'selectedTingkat' => $tingkat,
            'selectedProvinsi' => $provinsi,
            'provinsiList' => $provinsiList,
            'total' => $total, 
        ]);
    }
    

    public function columncharts(Request $request) {
        $selectedPokok = $request->input('pokok', 'sekolah');
        $selectedKet = $request->input('ket', 'all'); 
    
        // Ambil data berdasarkan pokok yang dipilih
        if (in_array($selectedPokok, ['guru', 'siswa', 'pegawai'])) {
            $dataQuery = Dataset::select('provinsi', 'tingkat', DB::raw('SUM(nilai) as total_nilai'))
                                ->where('pokok', $selectedPokok);
    
            if ($selectedKet != 'all') {
                $dataQuery->where('ket', $selectedKet);
            } else {
                $dataQuery->whereIn('ket', ['l', 'p']);
            }
    
            $data = $dataQuery->groupBy('provinsi', 'tingkat')->get();
        } else {
            $dataQuery = Dataset::select('provinsi', 'tingkat', DB::raw('SUM(nilai) as total_nilai'))
                                ->where('pokok', $selectedPokok);
    
            if ($selectedPokok == 'sekolah' && $selectedKet != 'all') {
                $dataQuery->where('ket', $selectedKet); 
            }
    
            $data = $dataQuery->groupBy('provinsi', 'tingkat')->get();
        }
    
        // Struktur data untuk chart
        $chartData = [];
        foreach ($data as $row) {
            if (!isset($chartData[$row->provinsi])) {
                $chartData[$row->provinsi] = [];
            }
            $chartData[$row->provinsi][$row->tingkat] = $row->total_nilai;
        }
    
        // Kirim data ke view dengan pokok dan ket terpilih
        return view('columncharts', compact('chartData', 'selectedPokok', 'selectedKet'));
    }
    

    // public function treemaps(Request $request)
    // {
    //     // Ambil nilai pokok yang dipilih, default ke 'guru'
    //     $selectedPokok = $request->input('pokok', 'guru');

    //     // Ambil pilihan tingkat yang dipilih dari user, default 'total' berarti semua tingkatan
    //     $selectedTingkat = $request->input('tingkat', 'total');

    //     // Query dasar untuk mengambil data dari database
    //     $query = Dataset::select('provinsi', DB::raw('SUM(nilai) as total_nilai'))
    //                     ->where('pokok', $selectedPokok);

    //     // Jika tingkat tidak total, filter berdasarkan tingkat yang dipilih (misalnya SD, SMP, SMA)
    //     if ($selectedTingkat !== 'total') {
    //         $query->where('tingkat', $selectedTingkat);
    //     }

    //     // Lakukan group by provinsi
    //     $data = $query->groupBy('provinsi')->get();

    //     // Format data untuk grafik Treemap
    //     $treemapData = $data->map(function ($item) {
    //         return [
    //             'name' => $item->provinsi,      // Nama provinsi sebagai node utama
    //             'value' => $item->total_nilai   // Total nilai untuk provinsi tersebut
    //         ];
    //     })->toArray();

    //     // Kirim data ke view
    //     return view('treemaps', [
    //         'treemapData' => $treemapData,
    //         'selectedPokok' => $selectedPokok,  // Kirim pokok yang dipilih ke view
    //         'selectedTingkat' => $selectedTingkat  // Kirim tingkat yang dipilih ke view
    //     ]);
    // }
}