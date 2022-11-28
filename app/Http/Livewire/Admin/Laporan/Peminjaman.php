<?php

namespace App\Http\Livewire\Admin\Laporan;

use App\Models\DetailPeminjaman;
use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rules\Password;

class Peminjaman extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $from, $to, $search;
    public $periode, $title;

    protected function rules()
    {
        return [];
    }

    public function periode()
    {
        $this->format();

        $this->periode = true;
    }

    public function updatePeriode()
    {
        $this->format();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {        
        $this->from = $this->from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->to = $this->to ?? Carbon::now()->format('Y-m-d');

        $this->title = "Laporan Peminjaman " . tanggal_indonesia($this->from) . ' s/d '. tanggal_indonesia($this->to);

        $datas = DetailPeminjaman::select('buku_id', 'nama_buku', DB::raw('count(id) as total'))
                ->groupBy('buku_id')->groupBy('nama_buku');

        if (strtotime($this->from) <= strtotime($this->to)) {
            $datas = $datas->whereBetween('created_at', ["$this->from 00:00:00", "$this->to 23:59:59"]);
        }

        if ($this->search) {
            $datas = $datas->where('nama_buku', 'like', '%'. $this->search .'%');
        }

        $datas = $datas->paginate(10);

        return view('livewire.admin.laporan.peminjaman', compact('datas'));
    }

    public function format()
    {
        unset($this->title);
        unset($this->periode);
        unset($this->from);
        unset($this->to);
    }
}
