<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::paginate(15);
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required|unique:menus,name|max:255',
        ]);
        $menu =  new Menu;
        $menu->name = trim(strtolower($request->menu));
        $menu->status = (int)$request->status;
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::where('id', $id)->firstOrFail();
        return view('admin.menu.edit', compact('menu'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'menu' => 'required|max:255',
        ]);
        $menu =  Menu::where('id', $id)->firstOrFail();
        $menu->name = trim(strtolower($request->menu));
        $menu->status = (int)$request->status;
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Data berhasil diubah');
    }


    public function destroy($id)
    {
        $menu =  Menu::where('id', $id)->firstOrFail();
        $menu->delete();
        return response()->json([
            'success' => 'Berhasil delete data!'
        ]);
    }
}
