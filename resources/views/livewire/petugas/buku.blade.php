<div class="row">
    <div class="col-12">

    @include('admin-lte/flash')

    @include('petugas/buku/create')
    @include('petugas/buku/edit')
    @include('petugas/buku/delete')
    @include('petugas/buku/show')

    <div class="card">
        <div class="card-header">
        <span wire:click="create" class="btn btn-sm btn-primary">Tambah</span>

             <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="search" type="text" name="table_search" class="form-control float-right" placeholder="Search">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
            <!-- /.card-header -->
            @if ($buku->isNotEmpty())
            <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th width="10%">Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th width="10%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($buku as $item)
                    <tr>
                        <td>{{$item->kode}}</td>
                        <!-- <td><img src="/storage/{{$item->sampul}}" alt="{{$item->judul}}" width="60" height="80"></td> -->
                        <td>{{$item->judul}}</td>
                        <td>{{$item->penulis}}</td>
                        <td>{{$item->kategori->nama}}</td>
                        <td class="{{$item->status == true ? 'text-success' : ''}}">{{$item->status == true ? 'Tersedia' : 'Dipinjam'}}</td>
                        <td>
                            <div class="dropdown">
                              <a id="dropdownAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                                <i class="fa fa-ellipsis-h text-primary"></i>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownAction">
                                <button wire:click="show({{$item->id}})" class="dropdown-item text-success"><i class="fa fa-eye text-sm"></i> Lihat</button>
                                <button wire:click="edit({{$item->id}})" class="dropdown-item text-primary"><i class="fa fa-pencil-alt text-sm"></i> Edit</button>
                                <button wire:click="edit({{$item->id}}, 'copy')" class="dropdown-item text-warning"><i class="fa fa-copy text-sm"></i> Salin</button> 
                                <button wire:click="delete({{$item ->id}})" class="dropdown-item text-danger"><i class="fa fa-trash text-sm"></i> Hapus</button>
                              </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
         @endif
    </div>
    <!-- /.card -->

    <div class="row justify-content-center">
        {{$buku->links()}}
    </div>

    @if ($buku->isEmpty())
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
