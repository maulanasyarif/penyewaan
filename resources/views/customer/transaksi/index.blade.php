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
        <div class="card">
            <div class="card-body">
                <div class="row" id="option">
                    <div class="col-md-3">
                        <select id="item" name="item_id" style="width: 100%; height: 30px;">
                            <option >-- Choose Category --</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input id="date" type="date" name="tanggal" class="form-control" style="height: 30px;">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <span>Silahkan pilih jam</span> &nbsp; <button class="btn btn-sm btn-success"
                            disabled>Booked</button> &nbsp; <button class="btn btn-sm btn-info">Available</button>
                        &nbsp; <button class="btn btn-sm btn-info" disabled>Selected</button>
                        <div id="jam">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="note" class="block">Catatan</label>
                            <textarea name="note" id="note" cols="6" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <span style="font-size: 20px;">Transaksi</span>
                        <div class="row">
                            <div class="col-md-3">
                                Nama
                            </div>
                            <div class="col-md-9">
                                : {{ Auth::user()->name }}
                                <input type="hidden" value="{{auth()->user()->id}}" id="user_id" name="user_id">
                            </div>
                            <div class="col-md-3">
                                Nama Sewa
                            </div>
                            <div class="col-md-9">
                                : <span id="item"></span>
                            </div>
                            <div class="col-md-3">
                                Harga Sewa
                            </div>
                            <div class="col-md-9">
                                : Rp. <span id="harga"></span>
                            </div>
                            <div class="col-md-3">
                                Tanggal
                            </div>
                            <div class="col-md-9">
                                : <span id="tgl"></span>
                            </div>
                            <div class="col-md-3">
                                Total Jam
                            </div>
                            <div class="col-md-9">
                                : <span id="total_jam"></span>
                            </div>
                            <div class="col-md-3">
                                Detail Jam
                            </div>
                            <div class="col-md-9">
                                : <span id="detail_jam"></span>
                            </div>
                            <div class="col-md-3">
                                Total Harga
                            </div>
                            <div class="col-md-9">
                                : Rp. <span id="total"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button id="btn-submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
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