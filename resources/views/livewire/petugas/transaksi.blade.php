<div class="row">
    <div class="col-12">

    @include('admin-lte/flash')

    @include('petugas/transaksi/create')
    @include('petugas/transaksi/show')

    <div class="btn-group mb-3">
        <button wire:click="format" class="btn btn-sm bg-teal mr-2">Semua</button>
        <button wire:click="belumDipinjam" class="btn btn-sm bg-indigo mr-2">Belum Dipinjam</button>
        <button wire:click="sedangDipinjam" class="btn btn-sm bg-olive mr-2">Sedang Dipinjam</button>
        <button wire:click="selesaiDipinjam" class="btn btn-sm bg-fuchsia mr-2">Selesai Dipinjam</button>
    </div>

    <div class="card">
        <div class="card-header">
        <span wire:click="create" class="btn btn-sm btn-primary">Tambah</span>

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
            @if ($transaksi->isNotEmpty())
            <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Pengunjung</th>
                    <th>Buku</th>
                    <th>Lokasi</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <!-- <th>Denda</th> -->
                    <th>Status</th>
                   @if (!$selesai_dipinjam)
                        <th width="15%">Aksi</th>
                   @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($transaksi as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                          <b>{{$item->nis_siswa}}</b><br>
                          {{$item->nama_siswa}}
                        </td>
                        <td>
                            <ul>
                                @foreach ($item->detail_peminjaman as $detail_peminjaman)
                                <li>{{$detail_peminjaman->nama_buku}}</li>
                                @endforeach
                            </ul>
                        </td>
                       <td>
                            <ul>
                                @foreach ($item->detail_peminjaman as $detail_peminjaman)
                                <li>{{$detail_peminjaman->lokasi}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$item->tanggal_pinjam}}</td>
                        <td>{{$item->tanggal_kembali}}</td>
                        <!-- <td>{{$item->denda}}</td> -->
                        <td>
                            @if ($item->status == 0)
                                <span class="badge bg-indigo">Loading</span>
                            @elseif ($item->status == 1)
                                <span class="badge bg-indigo">Belum Dipinjam</span>
                            @elseif ($item->status == 2)
                                <span class="badge bg-olive">Sedang Dipinjam</span>
                            @else
                                <span class="badge bg-fuchsia">Selesai Dipinjam</span>
                            @endif
                        </td>
                       @if (!$selesai_dipinjam)
                            <td>
                                    <button wire:click="show({{$item->id}})" class="btn btn-sm btn-secondary">Detail</button>
                                @if ($item->status == 1)
                                    <button wire:click="selectedId({{$item->id}}, 'pinjam')" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal">Pinjam</button>
                                    <button wire:click="selectedId({{$item->id}}, 'batal')" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">Batal</button>
                                @elseif ($item->status == 2)
                                    <button wire:click="selectedId({{$item->id}}, 'kembali')" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">Kembali</button>
                                @endif
                            </td>
                       @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <!-- modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin akan melanjutkan aksi ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Keluar</button>
                        @if($peminjaman_id && $action_type == 'pinjam')
                        <button type="button" wire:click.prevent="pinjam()" class="btn btn-danger close-modal" data-dismiss="modal">Iya, Pinjamkan</button>
                        @elseif($peminjaman_id && $action_type == 'batal')
                        <button type="button" wire:click.prevent="batal()" class="btn btn-danger close-modal" data-dismiss="modal">Iya, Batalkan</button>
                        @elseif($peminjaman_id && $action_type == 'kembali')
                        <button type="button" wire:click.prevent="kembali()" class="btn btn-danger close-modal" data-dismiss="modal">Iya, Lanjutkan</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
      @endif
    </div>
    <!-- /.card -->

     <div class="row justify-content-center">
        {{$transaksi->links()}}
    </div>

    @if ($transaksi->isEmpty())
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
