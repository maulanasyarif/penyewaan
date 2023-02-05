<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $menuItems = MenuItem::with(['menu'])->paginate(15);
        return view('admin.menuitem.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::where('status', 0)->get();
        return view('admin.menuitem.tambah', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required',
            'jenis_menu' => 'required|string',
            'price' => 'required',
        ]);

        $menuItem = new MenuItem;
        $menuItem->menu_id = (int)$request->menu;
        $menuItem->name = strtolower(trim($request->jenis_menu));
        $menuItem->price = (int)$request->price;
        $menuItem->status = (int)$request->status;
        $menuItem->save();

        return redirect()->route('menu-item.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menus = Menu::where('status', 0)->get();
        $menuItem = MenuItem::where('id', $id)->firstOrFail();
        return view('admin.menuitem.edit', compact('menus', 'menuItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'menu' => 'required',
            'jenis_menu' => 'required|string',
            'price' => 'required',
        ]);

        $menuItem = MenuItem::where('id', $id)->firstOrFail();
        $menuItem->menu_id = (int)$request->menu;
        $menuItem->name = strtolower(trim($request->jenis_menu));
        $menuItem->price = (int)$request->price;
        $menuItem->status = (int)$request->status;
        $menuItem->save();

        return redirect()->route('menu-item.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menuItem =  MenuItem::where('id', $id)->firstOrFail();
        $menuItem->delete();
        return response()->json([
            'success' => 'Berhasil delete data!'
        ]);
    }

    public function transaksi(Request $request)
    {
        $id = (int)$request->item_id;
        $data = MenuItem::with(['menu'])
        ->when($id, function($query) use ($id){
            return $query->where('id', $id);
        })
        ->get();

        if($data){
            return response()->json([
                'status' => true,
                'code'  => 200,
                'msg' => 'Success fetch data',
                'data' =>  $data,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'code'  => 404,
                'msg' => 'Data not found'
            ]);
        }
    }
}