@section('title', 'Laporan Buku')

<div class="row">
    <div class="col-12">

    @include('admin-lte/flash')

    @include('admin/laporan/peminjaman/periode')

    <!-- <div class="btn-group mb-3">
        <button wire:click="peminjaman" class="btn btn-sm bg-teal mr-2">Peminjaman Buku</button>
        <button wire:click="peminjam" class="btn btn-sm bg-indigo mr-2">Peminjam</button>
    </div> -->

    <div class="card">
        <div class="card-header">
             <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="search" type="search" name="table_search" class="form-control float-right" placeholder="Search">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
            <!-- /.card-header -->
            @if ($datas->isNotEmpty())
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                      <th width="10%">No.</th>
                      <th>Nama Buku</th>
                      <th>Penerbit</th>
                      <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($datas as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->judul}}</td>
                            <td><b>{{$item->penerbit->nama}}</td>
                            <td>{{$item->total}}</td>
                        </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
            @endif
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="row justify-content-center">
        {{$datas->links()}}
    </div>

    @if ($datas->isEmpty())
        <div class="card">
            <div class="card-body">
                <div class="alert alert-warning">
                    Anda tidak memiliki data
                </div>
            </div>
        </div>
    @endif

    </div>
</div>
<!-- /.row -->