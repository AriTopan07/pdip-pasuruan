<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\DataDiri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/form-tambah-data');
            return $next($request);
        });
    }

    public function data()
    {
        $data = DataDiri::get();

        return view('data.form.index', compact('data'));
    }

    public function view()
    {
        return view('data.form.view');
    }

    public function store(Request $request)
    {
        $pesan = [
            'required' => ':attribute wajib diisi!',
        ];

        $validator = Validator::make($request->all(), [
            'kecamatan' => 'required',
            'desa' => 'required',
            'nama_lengkap' => 'required',
            'foto_ktp' => 'required',
            'foto_diri' => 'required',
        ], $pesan);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $auth = Auth::user()->id;
            $uploadedFiles = [];
            foreach (['foto_ktp', 'foto_diri'] as $fileField) {
                if ($request->hasFile($fileField)) {
                    // Ambil nama lengkap dari request dan buat slug untuk nama file
                    $namaLengkap = Str::slug($request->nama_lengkap); // Mengubah nama menjadi format yang aman untuk URL/filename

                    // Simpan file ke disk 'biznet' dengan nama file yang dihasilkan
                    $file = $request->file($fileField);
                    $fileName = $namaLengkap . '_' . time() . '.' . $file->getClientOriginalExtension(); // Gabungkan nama lengkap dengan timestamp untuk membuat nama file unik
                    $result = Storage::disk('biznet')->putFileAs(
                        '/', 
                        $file, 
                        $fileName,
                        'public'
                    );

                    // Ambil URL file yang telah diunggah
                    $path = Storage::disk('biznet')->url($result); // Pastikan untuk mendapatkan URL file yang benar

                    // Simpan path dari file yang berhasil diunggah
                    $uploadedFiles[$fileField] = $path;
                }
            }

            // foreach (['foto_ktp', 'foto_diri'] as $fileField) {
            //     if ($request->hasFile($fileField)) {
            //         $uploadedFiles[$fileField] = $request->file($fileField)->store('files/data_diri', 'public');
            //     }
            // }

            $data = DataDiri::create([
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'nama_lengkap' => $request->nama_lengkap,
                'foto_ktp' => $uploadedFiles['foto_ktp'] ?? null,
                'foto_diri' => $uploadedFiles['foto_diri'] ?? null,
                'user_id' => $auth,
            ]);

            session()->flash('success', 'Sukses menambahkan data');

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat menambahkan data: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan data: ' . $th->getMessage()
            ]);
        }
    }
}
