 @if ($create ?? '')
    <div class="modal fade show" id="modal-default" style="display: block; padding-right: 17px;">
        <div class="modal-dialog" style="overflow-y: initial !important">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Tambah Peminjaman</h4>
            <span wire:click="format" type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input wire:model="nik" type="text" class="form-control" id="nik" min="1">
                    @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="nama">Nama Siswa</label>
                    <input wire:model="nama" type="text" class="form-control" id="nama" min="1">
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input wire:model="tanggal_pinjam" type="date" class="form-control" id="tanggal_pinjam">
                    @error('tanggal_pinjam') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input wire:model="tanggal_kembali" type="date" class="form-control" id="tanggal_kembali">
                    @error('tanggal_kembali') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="items">Buku yang dipinjam</label>
                    @error('buku') <small class="text-danger">{{ $message }}</small> @enderror
                    @foreach ($buku as $item)
                    <p class="form-control">{{ $item['judul'] }}</p>
                    @endforeach
                </div>
                <div class="form-group d-flex">
                    <input wire:model="kode_buku" type="text" class="form-control" id="key" placeholder="Masukkan kode Buku">
                    <button type="button" wire:click="addProduct" class="btn btn-primary ml-2">
                      Cari
                    </button>
                </div>
                <div class="form-group">
                    <div id="ingredients">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            <span wire:click="format" type="button" class="btn btn-default" data-dismiss="modal">Batal</span>
            <span type="button" wire:click="store" class="btn btn-success">Simpan</span>
            </div>
        </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Daftar Buku</h5>
          </div>
          <div class="modal-body">
              <div class="table-responsive">
                  <table class="table">
                      <thead>
                          <tr>
                          <th scope="col">No</th>
                          <th scope="col">Judul</th>
                          <th scope="col">Penulis</th>
                          <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
  </div> -->
@endif