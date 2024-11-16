<?php

namespace App\Http\Controllers;

use App\Models\DataDiri;
use App\Models\GoodsReceive;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/home');
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $userName = $user->name;
        $userGroup = DB::table('user_groups')
            ->where('user_id', $user->id)
            ->value('group_id');
        $capai = 100;
        $data['dataMasuk'] = DataDiri::count();
        $data['kecamatan'] = 24;
        $data['desa'] = 365;
        $data['progresku'] = DB::table('data_diris')->where('user_id', $user->id)->count();
        $data['progressPercentage'] = ($data['progresku'] / $capai) * 100;

        $data['byKecamatan'] = $this->getByKecamatan($userName);
        $data['byDesa'] = $this->getByDesa($userName);
        $tpsData = $this->getByTps2($user, $userGroup, $userName);

        // dd($tpsData);

        return view('home', compact('data', 'tpsData'));
    }

    public function getByKecamatan($userName)
    {
        $filePath = public_path('wilayah.json');
        $wilayahData = json_decode(File::get($filePath), true);
        $kecamatanList = collect($wilayahData)->pluck('KECAMATAN')->unique()->sort()->values();

        $dbData = DB::table('data_diris')
            ->join('users', 'data_diris.user_id', '=', 'users.id')
            ->select('kecamatan', DB::raw('count(*) as total'))
            ->when($userName !== 'Super Admin', function ($query) use ($userName) {
                return $query->where('data_diris.kecamatan', '=', $userName);
            })
            ->groupBy('kecamatan')
            ->pluck('total', 'kecamatan');

        // Gabungkan data JSON dan hasil query
        $chartData = $kecamatanList->map(function ($kecamatan) use ($dbData) {
            return [
                'kecamatan' => $kecamatan,
                'total' => $dbData[$kecamatan] ?? 0
            ];
        });

        return $chartData;
    }

    public function getByDesa($userName)
    {
        $data = DB::table('data_diris')
            ->select('desa', DB::raw('count(*) as total'))
            ->when($userName !== 'Super Admin', function ($query) use ($userName) {
                return $query->where('data_diris.kecamatan', '=', $userName);
            })
            ->groupBy('desa')
            ->get();

        return $data;
    }

    public function getByTps2($user, $userGroup, $userName)
    {
        $data = DB::table('data_diris')
            ->join('users', 'data_diris.user_id', '=', 'users.id')
            ->select(
                'data_diris.kecamatan',
                'data_diris.desa',
                'users.name as user_name',
                DB::raw('COUNT(data_diris.id) as total')
            )
            ->when($user->name !== 'Super Admin', function ($query) use ($userName, $userGroup) {
                if ($userGroup == 3) {
                    return $query->where('data_diris.desa', $userName);
                }
                if ($userGroup == 2) {
                    return $query->where('data_diris.kecamatan', $userName);
                }
                return $query;
            })
            ->groupBy('data_diris.kecamatan', 'data_diris.desa', 'users.name')
            ->orderBy('users.name', 'asc')
            ->get()
            ->groupBy('desa');

        return $data;
    }
}
