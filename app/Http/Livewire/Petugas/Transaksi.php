<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Transaksi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $create, $belum_dipinjam, $sedang_dipinjam, $selesai_dipinjam, $search;
    public $books, $data;
    public $nik, $tanggal_pinjam, $tanggal_kembali;
    public $product = [], $product_id;

    public function addProduct() {
      $findData = Arr::where($this->product, function ($value, $key) {
          return $value['id'] == $this->product_id;
      });

      if ($findData) {
        return session()->flash('gagal', 'Buku sudah ada dalam daftar');
      }
      
      $book = Buku::where('id', $this->product_id)->first();

      if ($book) {
        $this->product[] = $book;
        $this->product_id = '';
      }
    }
    
    public function create()
    {
        $this->create = true;
        $this->books = Buku::where('status', true)->get();
        // $this->kategori = Kategori::all();
    }

    public function store()
    {
      $this->validate([
          'nik' => 'required|string',
          'tanggal_pinjam' => 'required',
          'tanggal_kembali' => 'required',
          'product' => 'required|array|min:1',
      ]);

      $checkUser = Peminjaman::where('peminjam_id', $this->nik)->first();
      if ($checkUser) {
        return session()->flash('gagal', 'Terdapat peminjaman yang masih aktif untuk NIK ini');
      }

      DB::transaction(function()
      {
        $peminjaman = new Peminjaman();
        $peminjaman->kode_pinjam = Str::random(9);
        $peminjaman->peminjam_id = $this->nik;
        $peminjaman->petugas_pinjam = auth()->user()->id;
        $peminjaman->status = 1;
        $peminjaman->denda = 0;
        $peminjaman->tanggal_pinjam = $this->tanggal_pinjam;
        $peminjaman->tanggal_kembali = $this->tanggal_kembali;
        $peminjaman->save();

        foreach ($this->product as $item) {
            $detail = new DetailPeminjaman();
            $detail->peminjaman_id = $peminjaman->id;
            $detail->buku_id = $item['id'];
            $detail->save();
        }
      });

      session()->flash('sukses', 'Data berhasil ditambahkan.');

      $this->format();
    }

    public function belumDipinjam()
    {
        $this->format();
        $this->belum_dipinjam = true;
    }

    public function sedangDipinjam()
    {
        $this->format();
        $this->sedang_dipinjam = true;
    }

    public function selesaiDipinjam()
    {
        $this->format();
        $this->selesai_dipinjam = true;
    }

    public function pinjam(Peminjaman $peminjaman)
    {
        foreach ($peminjaman->detail_peminjaman as $detail_peminjaman) {
            $detail_peminjaman->buku->update([
                'stok' => $detail_peminjaman->buku->stok -1,
                'status' => false,
            ]);
        }

        $peminjaman->update([
            'petugas_pinjam' => auth()->user()->id,
            'status' => 2,
        ]);

        session()->flash('sukses', 'Buku berhasil dipinjam.');
    }

    public function batal(Peminjaman $peminjaman)
    {
      foreach ($peminjaman->detail_peminjaman as $detail_peminjaman) {
          $detail_peminjaman->buku->update([
              'stok' => $detail_peminjaman->buku->stok + 1,
              'status' => true,
          ]);
      }

      $peminjaman->update(['status' => 0]);
      session()->flash('sukses', 'Peminjaman berhasil dibatalkan.');
    }

    public function kembali(Peminjaman $peminjaman)
    {
        $data = [
            'status' => 3,
            'petugas_kembali' => auth()->user()->id,
            'tanggal_pengembalian' => today(),
            'denda' => 0
        ];

        foreach ($peminjaman->detail_peminjaman as $detail_peminjaman) {
            $detail_peminjaman->buku->update([
                'stok' => $detail_peminjaman->buku->stok + 1
            ]);
        }

        if (Carbon::create($peminjaman->tanggal_kembali)->lessThan(today())) {
            $denda = Carbon::create($peminjaman->tanggal_kembali)->diffInDays(today());
            $denda *= 1000;
            $data['denda'] = $denda;
        }

        $peminjaman->update($data);
        session()->flash('sukses', 'Buku berhasil dikembalikan.');
    }

    public function render()
    {
        $transaksi = Peminjaman::latest();

        if ($this->belum_dipinjam) {
          $transaksi = $transaksi->where('status', 1);
        }
        elseif ($this->sedang_dipinjam) {
          $transaksi = $transaksi->where('status', 2);
        }
        elseif ($this->selesai_dipinjam) {
          $transaksi = $transaksi->where('status', 3);
        }
        else {
          $transaksi = $transaksi->where('status', '!=', 0);
        }

        if ($this->search) {
          $transaksi = $transaksi->where('kode_pinjam', 'like', '%'. $this->search .'%');
        }

        $transaksi = $transaksi->paginate(10);

        return view('livewire.petugas.transaksi', [
            'transaksi' => $transaksi
        ]);
    }

    public function format()
    {
        $this->sedang_dipinjam = false;
        $this->belum_dipinjam = false;
        $this->selesai_dipinjam = false;
        unset($this->create);
    }
}
