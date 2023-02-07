@extends('customer.layout.app')
@section('title', 'Dashboard')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 id="token" class="m-0 text-dark">Wellcome {{ Auth::user()->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="col-md row ">
                @foreach ($transaksis as $transaksi)
                <div class="card col-md-5 mb-2 mr-2">
                    <div class="card-body">
                        <h4 style="font-size: 20px;">Nomor Transaksi : {{$transaksi->no_transaksi}}</h4>
                        <h4 style="font-size: 20px;">Status : {{$transaksi->status == 0 ? 'Menunggu' : ($transaksi->status == 1 ? 'Diterima' : 'Gagal')}}</h4>
                        <div class="row">
                            <div class="col-md-3">
                                Nama: 
                            </div>
                            <div class="col-md-9">
                                : {{ $user->name }}
                                <input type="hidden" value="{{auth()->user()->id}}" id="user_id" name="user_id">
                            </div>
                            <div class="col-md-3">
                                Nama Sewa
                            </div>
                            <div class="col-md-9">
                                : <span id="item">{{$transaksi->transaksi_details[0]->menuitem->name}}</span>
                            </div>
                            <div class="col-md-3">
                                Harga Sewa
                            </div>
                            <div class="col-md-9">
                                : Rp. <span id="harga">{{number_format($transaksi->price, '2', ',')}}</span>
                            </div>
                            <div class="col-md-3">
                                Tanggal
                            </div>
                            <div class="col-md-9">
                                : <span id="tgl">{{$transaksi->start_time}}</span>
                            </div>
                            <div class="col-md-3">
                                Total Jam
                            </div>
                            <div class="col-md-9">
                                : <span id="total_jam">{{count(json_decode($transaksi->jam))}} jam</span>
                            </div>
                            <div class="col-md-3">
                                Detail Jam
                            </div>
                            @php
                            $jam = json_decode($transaksi->jam);
                            usort($jam, function ($a, $b) {
                              return (float)$a > (float)$b;
                            })
                          @endphp
                            <div class="col-md-9">
                                : <span id="detail_jam">@foreach ($jam as $j)
                                    {{$j}}
                                @endforeach</span>
                            </div>
                            <div class="col-md-3">
                                Total Harga
                                <input type="hidden" value="total_harga" name="total_harga" id="total_harga">
                            </div>
                            <div class="col-md-9">
                                : Rp. <span id="total">{{number_format($transaksi->total_price, '2', ',')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('js-source')
<script src="{{ asset('src/main.js') }}"></script>
<script src="{{ asset('assets//plugins/jquery/jquery.min.js') }}"></script>
@endsection