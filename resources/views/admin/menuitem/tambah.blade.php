@extends('layout.app')
@section('title', 'Tambah Data Menu Item')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 id="token" class="m-0 text-dark">Tambah Menu Item {{ Auth::user()->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Menu</li>
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
        <div class="row"> 
          @if (count($errors) > 0)
              <div class = "alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
              </div>
          @endif
         <div class="col-lg-12">
            <form action="{{route('menu-item.store')}}" method="post">
              @csrf
              @method('POST')
            <div class="form-group">
              <label for="menu">Category</label>
              <select class="form-control" id="menu" name="menu">
                @forelse ($menus as $menu)
                  <option value="{{$menu->id}}">{{strtoupper($menu->name)}}</option>
                @empty
                  <option disabled>Tidak ada data</option>
                @endforelse
              </select>
            </div>
            <div class="form-group">
              <label for="jenis_menu">Jenis Category</label>
              <input type="text" class="form-control" id="jenis_menu" placeholder="Masukkan Jenis Category" name="jenis_menu" required>
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="number" class="form-control" id="price" placeholder="Masukkan price" name="price" min="0" required>
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="0">Aktif</option>
                <option value="1">Tidak Aktif</option>
              </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{route('menu-item.index')}}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('js-source')
<script src="{{ asset('src/main.js') }}"></script>
<script src="{{ asset('assets//plugins/jquery/jquery.min.js') }}"></script>
<script src="">
$(document).ready(function() {
    // var aa = test(10);
    var aa = "Aaa";
    console.log(aa);
})
</script>
@endsection