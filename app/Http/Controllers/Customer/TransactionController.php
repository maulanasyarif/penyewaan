<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
  public function index()
  {
    return view('customer.transaksi.index');
  }

  public function transaksi(Request $request)
  {
    $id = (int)$request->item_id;
    $today = $request->today;
    $data = MenuItem::with(['menu'])
      ->when($id, function ($query) use ($id) {
        return $query->where('id', $id);
      })
      ->get();

    $booked = TransaksiDetail::with(['transaksi'])
      ->where('menuitem_id', $id)
      ->whereHas('transaksi', function ($q) use ($today) {
        $q->where('status', 1)
          ->whereDate('start_time', $today);
      })->get();
    if ($data) {
      return response()->json([
        'status' => true,
        'code'  => 200,
        'msg' => 'Success fetch data',
        'data' =>  $data,
        'booked' => $booked
      ]);
    } else {
      return response()->json([
        'status' => false,
        'code'  => 404,
        'msg' => 'Data not found'
      ]);
    }
  }

  public function store(Request $request)
  {
    $jam = [];
    $jam = json_decode($request->jam);
    $newJ = collect($jam);
    $menu_id = $request->menu_id;
    $user_id = $request->user_id;
    $price = $request->price;
    $total_price = $request->total_price;
    $note = $request->note;
    $today = date('Y-m-d');
    $no_transaksi = Uuid::uuid1();

    foreach ($newJ->sortBy('desc') as $j) {
      $new_time = preg_replace("/(\d{2})\.(\d{2})/", "$1:$2", $j);
      $starttime = $today . ' ' . $new_time . ':00';
    }

    $transaksi = Transaksi::create([
      'user_id' => (int)$user_id,
      'no_transaksi' => $no_transaksi,
      'jam' => json_encode($jam),
      'price' => (int)$price,
      'total_price' => (int)$total_price,
      'noted' => $note,
      'start_time' => $starttime,
      'end_time' => $today . ' ' . $jam[0] . ':00',
      'status' => 0
    ]);

    TransaksiDetail::create([
      'transaksi_id' => $transaksi->id,
      'menuitem_id' => $menu_id,
    ]);

    return response()->json([
      'status' => true,
      'code'  => 200,
      'msg' => 'Success booking data',
    ]);
  }


  public function booking()
  {
    $auth = Auth::user();
    $transaksi = Transaksi::with(['transaksi_details'])
      ->where('user_id', $auth->id)
      ->whereDate('created_at', date('Y-m-d'))
      ->get();
    // $transaksi_detail = Transaksi::with(['transaksi_details'])
    //   ->where('user_id', $auth->id)
    //   ->whereDate('created_at', date('Y-m-d'))
    //   ->whereHas('transaksi_details', function ($q) {
    //     $q->distinct('no_transaksi');
    //   })
    //   ->get();
    dd($transaksi);
    return view('customer.transaksi.booking', compact('transaksi'));
  }
}
