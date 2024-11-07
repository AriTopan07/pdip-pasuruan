<?php

namespace App\Http\Repository;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use DB;

class MenuRepository
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function get_all_menu()
    {
        return DB::table('menus')
            ->select('id', 'name_menu', 'url', 'section_id', 'icons', 'order')
            ->where('status', 'active')
            ->orderBy('order', 'ASC')
            ->get();
    }

    public function get_menu($id)
    {
        return DB::table('menus')->where('id', $id)->first();
    }

    public function get_menu_by_section($section)
    {
        return DB::table('menus')->where('section_id', $section)->get();
    }

    public function store($request)
    {
        $menu = DB::table('menus')->where('section_id', $request->section_id)->orderBy('order', 'DESC')->first();
        return DB::table('menus')
            ->insert([
                'parent_id' => $request->parent_id,
                'section_id' => $request->section_id,
                'name_menu' => $request->name_menu,
                'url' => $request->url,
                'icons' => '',
                'order' => ($menu != NULL) ? $menu->order + 1 : 1,
                'status' => 'active'
            ]);
    }

    public function update($request, $id)
    {
        if ($request->status !== NULL) {
            return DB::table('menus')->where('id', $id)->update([
                'name_menu' => $request->name_menu,
                'url' => $request->url,
                'section_id' => $request->section_id,
                'parent_id' => $request->parent_id,
                'status' => 'active'
            ]);
        } else {
            return DB::table('menus')->where('id', $id)->update([
                'name_menu' => $request->name_menu,
                'url' => $request->url,
                'section_id' => $request->section_id,
                'parent_id' => $request->parent_id,
                'status' => 'inactive'
            ]);
        }
    }
}
