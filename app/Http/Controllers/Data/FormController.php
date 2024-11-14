<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\DataDiri;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data()
    {
        Session::put('menu_active', '/view/data');
        $user = auth()->user();
        $userGroup = UserGroup::where('user_id', $user->id)->first();
        if (!$userGroup) {
            return response()->json(['error' => 'User group tidak ditemukan'], 404);
        }
        $groupId = $userGroup->group_id;
        $query = DataDiri::query();

        switch ($groupId) {
            case 1:
                $data = $query->paginate(50);
                break;
            case 2:
                $data = $query->where('kecamatan', $user->name)->paginate(50);
                break;
            case 3:
                $data = $query->where('desa', $user->name)->paginate(50);
                break;
            case 4:
                $data = $query->where('user_id', $user->id)->paginate(50);
                break;
            default:
                return response()->json(['error' => 'Grup tidak valid'], 400);
        }
        $message = $data->isEmpty() ? 'Data tidak ditemukan' : null;

        return view('data.form.index', compact('data', 'message'));
    }

    public function view()
    {
        Session::put('menu_active', '/form-tambah-data');
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

                    // Ambil file dari request
                    $file = $request->file($fileField);
                    $fileName = $namaLengkap . '_' . time() . '.' . $file->getClientOriginalExtension(); // Gabungkan nama lengkap dengan timestamp untuk membuat nama file unik

                    // Simpan file ke disk 'biznet'
                    $result = Storage::disk('biznet')->putFileAs(
                        '/',
                        $file,
                        $fileName,
                        'public'
                    );

                    if (!$result) {
                        // Lempar exception jika penyimpanan gagal
                        throw new \Exception("Gagal mengunggah file {$fileField} ke storage.");
                    }

                    // Ambil URL file yang telah diunggah
                    $path = Storage::disk('biznet')->url($fileName);

                    // Simpan path dari file yang berhasil diunggah
                    $uploadedFiles[$fileField] = $path;
                }
            }

            $data = DataDiri::create([
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'nik' => $request->nik,
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
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
