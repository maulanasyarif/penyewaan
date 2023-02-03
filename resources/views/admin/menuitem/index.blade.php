@extends('layout.app')
@section('title', 'Menu Items')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 id="token" class="m-0 text-dark">Menu Items {{ Auth::user()->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Menu Items</li>
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
            <a href="{{route('menu-item.create')}}" class="btn btn-primary mb-3">Tambah Data</a>
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Jenis Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="w-25">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($menuItems as $item)
                  <tr>
                    <th scope="row">{{strtoupper($item->menu->name)}}</th>
                    <td>{{strtoupper($item->name)}}</td>
                    <td>Rp. {{number_format($item->price, 2, ',', '.')}}</td>
                    <td>{{$item->status == 0 ? 'Aktif' : 'Tidak Aktif'}}</td>
                    <td>
                        <div class="row">
                            <a class="btn btn-success" href="{{route('menu-item.edit', $item->id)}}">Edit</a>
                            <button class="btn btn-danger edit-data" data-id="{{$item->id}}">Hapus</button>
                        </div>
                    </td>
                  </tr>
                  @empty
                      <tr class="text-center">
                        <td colspan="3">Tidak ada data!</td>
                      </tr>
                  @endforelse
                </tbody>
              </table>
              <div>
                {{
                    $menuItems->links('pagination::bootstrap-4')
                }}
              </div>
        </div>
        <!-- /.row -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection

@section('js-source')
<script src="{{ asset('src/main.js') }}"></script>
<script src="{{ asset('assets//plugins/jquery/jquery.min.js') }}"></script>
<script>
$(document).ready(function() {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // var aa = test(10);
    $(".edit-data").on("click", function(){
      const confirmDelete = confirm('Yakin delete?');
      let dataId = $(this).attr("data-id");
      if(confirmDelete) {
            $.ajax({
            method: 'DELETE',
            url: '/admin/menu-items/' + dataId,
            data: {id:dataId},
            success: (res) => {
              window.location.reload()
            }
          })
        }
    });
})
</script>
@endsection