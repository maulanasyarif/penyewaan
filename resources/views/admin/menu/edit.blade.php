@extends('layout.app')
@section('title', 'Edit Data Menu')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 id="token" class="m-0 text-dark">Edit Menu {{ Auth::user()->name }}</h1>
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
            <form action="{{route('menu.update', $menu->id)}}" method="post">
              @csrf
              @method('PATCH')
            <div class="form-group">
              <label for="menu">Nama Category</label>
              <input type="text" class="form-control" id="menu" placeholder="Masukkan menu" name="menu" value="{{$menu->name}}" required>
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="0" {{$menu->status == 0 ? 'selected' : null}}>Aktif</option>
                <option value="1" {{$menu->status == 1 ? 'selected' : null}}>Tidak Aktif</option>
              </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{route('menu.index')}}" class="btn btn-secondary">Kembali</a>
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