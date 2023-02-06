<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
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
        $jam = $request->jam;
        $menu_id = $request->menu_id;
        $tanggal = $request->tanggal;
        $user_id = $request->user_id;
        $harga = $request->harga;
        $note = $request->note;
        $today = date('Y-m-d');
        $no_transaksi = Uuid::uuid1();
        foreach ($jam as $j) {
            $new_time = preg_replace("/(\d{2})\.(\d{2})/", "$1:$2", $j);
            $starttime = $today . ' ' . $new_time . ':00';
            $endtime = strtotime($starttime) + 60 * 60;
            $transaksi = Transaksi::create([
                'user_id' => (int)$user_id,
                'total_price' => (int)$harga,
                'noted' => $note,
                'start_time' => $starttime,
                'end_time' => date('Y-m-d h:i:s', $endtime),
                'status' => 0
            ]);

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'menuitem_id' => $menu_id,
                'no_transaksi' => $no_transaksi
            ]);
        }

        return response()->json([
            'status' => true,
            'code'  => 200,
            'msg' => 'Success insert data',
        ]);
    }
}
