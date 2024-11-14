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
        $user = Auth::user()->id;
        $userName = Auth::user()->name;
        $data['totalData'] = 100;

        $data['dataMasuk'] = DataDiri::count();
        $data['kecamatan'] = 24;
        $data['desa'] = 365;
        $data['total'] = DataDiri::count();
        $data['progresku'] = DB::table('data_diris')->where('user_id', $user)->count();
        $data['progressPercentage'] = ($data['progresku'] / $data['totalData']) * 100;

        $userName = Auth::user()->name;

        $data['byKecamatan'] = DB::table('data_diris')
            ->join('users', 'data_diris.user_id', '=', 'users.id')
            ->select('kecamatan', DB::raw('count(*) as total'))
            ->when($userName !== 'Super Admin', function ($query) use ($userName) {
                return $query->where('data_diris.kecamatan', '=', $userName);
            })
            ->groupBy('kecamatan')
            ->get();


        $data['byDesa'] = DB::table('data_diris')
            ->select('desa', DB::raw('count(*) as total'))
            ->when($userName !== 'Super Admin', function ($query) use ($userName) {
                return $query->where('data_diris.kecamatan', '=', $userName);
            })
            ->groupBy('desa')
            ->get();


        $data['byTps'] = DB::table('data_diris')
            ->join('users', 'data_diris.user_id', '=', 'users.id')
            ->select(
                'data_diris.kecamatan',
                'data_diris.desa',
                'data_diris.user_id',
                'users.name as user_name',
                DB::raw('count(data_diris.id) as total')
            )
            ->when($userName !== 'Super Admin', function ($query) use ($userName) {
                return $query->where('data_diris.kecamatan', '=', $userName);
            })
            ->groupBy('data_diris.kecamatan', 'data_diris.desa', 'data_diris.user_id', 'users.name')
            ->get();

        return view('home', compact('data'));
    }
}
