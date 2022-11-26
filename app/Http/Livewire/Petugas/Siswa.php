<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Buku;
use App\Models\Rak;
use App\Models\Siswa as ModelsSiswa;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Siswa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $create, $edit, $delete, $nis, $nama, $siswa_id, $search;

    protected $rules = [
        'nis' => 'required|integer|unique:siswa',
        'nama' => 'required|min:5',
    ];

    public function create()
    {
        $this->format();

        $this->create = true;
    }

    public function store()
    {
        $this->validate();

        Modelssiswa::create([
            'nis' => $this->nis,
            'nama' => $this->nama,
        ]);

        session()->flash('sukses', 'Data berhasil ditambahkan');

        $this->format();
    }

    public function edit(Modelssiswa $siswa)
    {
        $this->format();

        $this->edit = true;
        $this->nis = $siswa->nis;
        $this->nama = $siswa->nama;
        $this->siswa_id = $siswa->id;
    }

    public function update(Modelssiswa $siswa)
    {
        $this->validate();

        $siswa->update([
            'nis' => $this->nis,
            'nama' => $this->nama,
        ]);

        session()->flash('sukses', 'Data berhasil diubah');

        $this->format();
    }

    public function delete($id)
    {
        $this->format();

        $this->delete = true;
        $this->siswa_id = $id;
    }

    public function destroy(Modelssiswa $siswa)
    {
        $siswa = Buku::where('id', $siswa->id)->get();

        $siswa->delete();

        session()->flash('sukses', 'Data berhasil dihapus');

        $this->format();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $siswa = ModelsSiswa::latest();
        
        if ($this->search) {
            $siswa = $siswa->where('nis', 'like', '%'. $this->search .'%')
              ->orWhere('nama', 'like', '%'. $this->search .'%');
        }

        $siswa = $siswa->paginate(10);
        
        return view('livewire.petugas.siswa', [
            'siswa' => $siswa
        ]);
    }

    public function format()
    {
        unset($this->siswa_id);
        unset($this->nama);
        unset($this->create);
        unset($this->edit);
        unset($this->delete);
    }
}
