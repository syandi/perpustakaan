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

    public $create, $show, $belum_dipinjam, $sedang_dipinjam, $selesai_dipinjam, $search;
    public $nik, $nama, $tanggal_pinjam, $tanggal_kembali;
    public $buku = [], $kode_buku;
    public $action_type, $peminjaman_id, $detail;

    public function addProduct() {
      $book = Buku::with('rak')->where('status', true)->where('kode', $this->kode_buku)->first();
      if (! $book) {
        return session()->flash('gagal', 'Kode buku tidak ditemukan');
      }

      $findData = Arr::where($this->buku, function ($value, $key) use ($book) {
          return $value['id'] == $book->id;
      });

      if ($findData) {
        return session()->flash('gagal', 'Buku sudah ada dalam daftar');
      }
      
      $this->buku[] = $book;
      $this->kode_buku = '';
      // session()->flash('sukses', 'Data berhasil ditambahkan.');
    }
    
    public function create()
    {
        $this->create = true;
        // $this->kategori = Kategori::all();
    }

    public function show($id)
    {
        $this->format();

        $this->show = true;
        $this->detail = Peminjaman::with('detail_peminjaman')->where('id', $id)->first();
    }

    public function store()
    {
      $this->validate([
          'nik' => 'required|string',
          'nama' => 'required|string',
          'tanggal_pinjam' => 'required',
          'tanggal_kembali' => 'required',
          'buku' => 'required|array|min:1',
      ]);

      $checkUser = Peminjaman::where('peminjam_id', $this->nik)->where('status', '!=', 3)->first();
      if ($checkUser) {
        return session()->flash('gagal', 'Terdapat peminjaman yang masih aktif untuk NIK ini');
      }

      DB::transaction(function()
      {
        $peminjaman = new Peminjaman();
        $peminjaman->kode_pinjam = Str::random(9);
        $peminjaman->peminjam_id = $this->nik;
        $peminjaman->nama_peminjam = $this->nama;
        $peminjaman->petugas_pinjam = auth()->user()->id;
        $peminjaman->status = 1;
        $peminjaman->denda = 0;
        $peminjaman->tanggal_pinjam = $this->tanggal_pinjam;
        $peminjaman->tanggal_kembali = $this->tanggal_kembali;
        $peminjaman->save();

        foreach ($this->buku as $item) {
            $detail = new DetailPeminjaman();
            $detail->peminjaman_id = $peminjaman->id;
            $detail->buku_id = $item['id'];
            $detail->nama_buku = $item['judul'];
            $detail->lokasi = "Rak : {$item['rak']['rak']}, Baris : {$item['rak']['baris']}";
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

    public function pinjam()
    {
        $peminjaman = Peminjaman::with('detail_peminjaman')->find($this->peminjaman_id);
        if (! $peminjaman) {
          return session()->flash('gagal', 'Peminjaman tidak ditemukan');
        }
        
        DB::transaction(function () use ($peminjaman) {
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
        });
    }

    public function batal(Peminjaman $peminjaman)
    {
      $peminjaman = Peminjaman::with('detail_peminjaman')->find($this->peminjaman_id);
      if (! $peminjaman) {
        return session()->flash('gagal', 'Peminjaman tidak ditemukan');
      }
      
      DB::transaction( function() use ($peminjaman) {
        foreach ($peminjaman->detail_peminjaman as $detail_peminjaman) {
            $detail_peminjaman->buku->update([
                'stok' => $detail_peminjaman->buku->stok + 1,
                'status' => true,
            ]);
        }


        DetailPeminjaman::where('peminjaman_id', $peminjaman->id)->delete();
        $peminjaman->delete();        

        session()->flash('sukses', 'Peminjaman berhasil dibatalkan.');

      });

      $this->format();
    }

    public function selectedId($id, $type) {
      $this->peminjaman_id = $id;
      $this->action_type = $type;
    }

    public function kembali()
    {
        $peminjaman = Peminjaman::with('detail_peminjaman')->find($this->peminjaman_id);
        if (! $peminjaman) {
          return session()->flash('gagal', 'Peminjaman tidak ditemukan');
        }

        DB::transaction(function () use ($peminjaman) {
          $data = [
              'status' => 3,
              'petugas_kembali' => auth()->user()->id,
              'tanggal_pengembalian' => today(),
              'denda' => 0
          ];

          foreach ($peminjaman->detail_peminjaman as $detail_peminjaman) {
              $detail_peminjaman->buku->update([
                  'stok' => $detail_peminjaman->buku->stok + 1,
                  'status' => true,
              ]);
          }

          if (Carbon::create($peminjaman->tanggal_kembali)->lessThan(today())) {
              $denda = Carbon::create($peminjaman->tanggal_kembali)->diffInDays(today());
              $denda *= 1000;
              $data['denda'] = $denda;
          }

          $peminjaman->update($data);
          session()->flash('sukses', 'Buku berhasil dikembalikan.');
        });
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
          $transaksi = $transaksi->where('kode_pinjam', 'like', '%'. $this->search .'%')
                        ->orWhere('peminjam_id', 'like', '%'. $this->search .'%')
                        ->orWhere('nama_peminjam', 'like', '%'. $this->search .'%');
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
        $this->buku = [];
        unset($this->create);
        unset($this->show);
        unset($this->nik);
        unset($this->nama);
        unset($this->tanggal_pinjam);
        unset($this->tanggal_kembali);
        unset($this->kode_buku);
        unset($this->peminjaman_id);
        unset($this->action_type);
    }
}
