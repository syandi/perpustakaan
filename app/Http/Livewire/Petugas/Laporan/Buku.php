<?php

namespace App\Http\Livewire\Petugas\Laporan;

use App\Models\Buku as ModelsBuku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman as ModelsPeminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Buku extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $from, $to, $search;
    public $peminjam, $periode, $title;

    protected function rules()
    {
        return [];
    }

    public function peminjam()
    {
      $this->format();

      $this->peminjam = true;
    }

    public function peminjaman()
    {
      $this->format();

      $this->peminjam = false;
    }

    public function periode()
    {
        // $this->format();

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
        $datas = ModelsBuku::with('penerbit:id,nama')
          ->select('judul', 'penerbit_id', DB::raw('COUNT(id) as total'))
          ->groupBy('judul')
          ->groupBy('penerbit_id');

        if ($this->search) {
            $datas = $datas->where('judul', 'like', '%'. $this->search .'%');
        }

        $datas = $datas->paginate(10);
        return view('livewire.petugas.laporan.buku', compact('datas'));
    }

    public function format()
    {
        unset($this->peminjam);
        unset($this->title);
        unset($this->periode);
        unset($this->from);
        unset($this->to);
    }
}
