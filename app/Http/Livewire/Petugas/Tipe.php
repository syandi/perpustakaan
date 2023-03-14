<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Buku;
use App\Models\Tipe as ModelsTipe;
use App\Models\Rak;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Tipe extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $create, $edit, $delete, $nama, $tipe_id, $search;

    protected $rules = [
        'nama' => 'required|min:3|unique:types',
    ];

    public function create()
    {
        $this->format();

        $this->create = true;
    }

    public function store()
    {
        $this->validate();

        ModelsTipe::create([
            'nama' => $this->nama,
        ]);

        session()->flash('sukses', 'Data berhasil ditambahkan');

        $this->format();
    }

    public function edit(ModelsTipe $type)
    {
        $this->format();

        $this->edit = true;
        $this->nama = $type->nama;
        $this->tipe_id = $type->id;
    }

    public function update(ModelsTipe $tipe)
    {
        $this->validate();

        $tipe->update([
            'nama' => $this->nama,
            'slug' => Str::slug($this->nama)
        ]);

        session()->flash('sukses', 'Data berhasil diubah');

        $this->format();
    }

    public function delete($id)
    {
        $this->format();

        $this->delete = true;
        $this->tipe_id = $id;
    }

    public function destroy(ModelsTipe $tipe)
    {
        $tipe->delete();

        session()->flash('sukses', 'Data berhasil dihapus');

        $this->format();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->search) {
            $tipe = ModelsTipe::latest()->where('nama', 'like', '%'. $this->search .'%')->paginate(5);
        } else {
            $tipe = ModelsTipe::latest()->paginate(5);
        }
        
        return view('livewire.petugas.tipe', [
            'tipe' => $tipe
        ]);
    }

    public function format()
    {
        unset($this->tipe_id);
        unset($this->nama);
        unset($this->create);
        unset($this->edit);
        unset($this->delete);
    }
}
