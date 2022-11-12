@extends('admin-lte/app')
@section('title', 'Transaksi')
@section('active-transaksi', 'active')

@section('content')
    <livewire:petugas.transaksi></livewire:petugas.transaksi>

    <script>
      function productSelected(product) {
        console.log(product)
        $('#ingredients').append(
          '<div id="'+ product.id +'" class="form-row"><div class="form-group col-xl-7">' +
              '<div><input id="id" type="text" name="product_id" wire:model="product_id" value="' + product.id + '" class="form-control d-none"/>' +
              '<input id="name" type="text" name="product_name" wire:model="product_id" value="' + product.judul + '" class="form-control "/></div>' +
          '</div>');
        $('#exampleModal').modal('hide');
        localStorage.setItem("lastname", "Smith");
      };
    </script>
@endsection
