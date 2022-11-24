 @if ($show)
        <div class="modal fade show" id="modal-default" style="display: block; padding-right: 17px;">
            <div class="modal-dialog modal-lg" style="overflow-y: initial !important">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Detail Peminjaman</h4>
                <span wire:click="format" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-borderless">
                          <tbody>
                            <tr>
                                <th style="width: 5%;">NIK</th>
                                <td>:</td>
                                <td>{{$detail->peminjam_id}}</td>
                            </tr>
                            <tr>
                                <th>Nama Siswa</th>
                                <td>:</td>
                                <td>{{$detail->nama_peminjam}}sdsdsd sdsdsd sdsdsd</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <td>:</td>
                                <td>{{$detail->tanggal_pinjam}}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Kembali</th>
                                <td>:</td>
                                <td>{{$detail->tanggal_kembali}}</td>
                            </tr>
                            @if($detail->status == 3)
                            <tr>
                                <th>Tanggal Pengembalian</th>
                                <td>:</td>
                                <td>{{$detail->tanggal_pengembalian}}</td>
                            </tr>
                            @endif
                          </tbody>
                      </table>
                      <h4>Detail Buku</h4>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Lokasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($detail->detail_peminjaman as $key => $detail)
                          <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$detail->nama_buku}}</td>
                            <td>{{$detail->lokasi}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <span wire:click="format" type="button" class="btn btn-default" data-dismiss="modal">Kembali</span>
                </div>
            </div>
            </div>
        </div>
    @endif
