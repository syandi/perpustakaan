 @if ($periode)
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="from" class="col-lg-3 text-sm">Tanggal Awal</label>
                    <input wire:model="from" type="date" name="from" class="form-control col-lg-3" required autofocus
                        style="border-radius: 0 !important;">
                </div>
                <div class="form-group">
                    <label for="dateTo" class="col-lg-3 text-sm">Tanggal Akhir</label>
                    <input wire:model="to" type="date" name="to" class="form-control col-lg-3" required
                        style="border-radius: 0 !important;">
                </div>
                <!-- <span wire:click="updatePeriode" class="btn btn-sm btn-success">Simpan</span> -->
            </div>
        </div>
    @endif