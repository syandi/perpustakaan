 @if ($edit || $copy)
        <div class="modal fade show" id="modal-default" style="display: block; padding-right: 17px;">
            <div class="modal-dialog modal-lg" style="overflow-y: initial !important">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">{{ $edit ? 'Edit Buku' : 'Tambah Buku' }}</h4>
                <span wire:click="format" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <div class="form-group">
                        <label for="kode">Kode Buku</label>
                        <input wire:model="kode" type="text" class="form-control" id="kode">
                        @error('kode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input wire:model="judul" type="text" class="form-control" id="judul">
                        @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="penulis">Penulis</label>
                                <input wire:model="penulis" type="text" class="form-control" id="penulis">
                                @error('penulis') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input wire:model="stok" type="number" class="form-control" id="stok" min="1">
                                @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <label for="sampul">Sampul</label>
                        <input wire:model="sampul" type="file" class="form-control" id="sampul" min="1">
                        @error('sampul') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select wire:model="kategori_id" wire:click="pilihKategori" class="form-control" id="kategori">
                                    <option selected value="">Pilih Kategori</option>
                                    @foreach ($kategori as $item)
                                        @if ($item->id != 1)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <select wire:model="penerbit_id" class="form-control" id="penerbit">
                                    <option selected value="">Pilih Penerbit</option>
                                    @foreach ($penerbit as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                                @error('penerbit_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rak">Rak</label>
                                <select wire:model="rak_id" class="form-control" id="rak">
                                    <option selected value="">Pilih Rak</option>
                                    @foreach ($rak as $item)
                                        <option value="{{$item->id}}">Rak : {{$item->rak}}, Baris : {{$item->baris}}</option>
                                    @endforeach
                                </select>
                                @error('rak_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kondisi">Kondisi</label>
                                <select wire:model="kondisi" class="form-control" id="kondisi">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                                @error('kondisi') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select wire:model="status" class="form-control" id="status">
                                    <option value="1">Tersedia</option>
                                    <option value="0">Dipinjam</option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea wire:model="catatan" type="text" class="form-control" id="catatan"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <span wire:click="format" type="button" class="btn btn-default" data-dismiss="modal">Batal</span>
                @if($edit)
                <span type="button" wire:click="update({{$buku_id}})" class="btn btn-success">Update</span>
                @elseif($copy)
                <span type="button" wire:click="duplicate()" class="btn btn-success">Simpan</span>
                @endif
                </div>
            </div>
            </div>
        </div>
    @endif
