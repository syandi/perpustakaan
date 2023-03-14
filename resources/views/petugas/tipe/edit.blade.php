  @if ($edit)
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Tipe</label>
                    <input wire:model="nama" type="text" class="form-control" id="nama" name="nama">
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <span wire:click="update({{$tipe_id}})" class="btn btn-sm btn-success">Update</span>
            </div>
        </div>
    @endif