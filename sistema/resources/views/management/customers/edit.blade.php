@extends('template.administrador')

@section('title', 'CLIENTES')
@section('name-section', 'CLIENTES')

@section('description', 'Editar cliente')
@section('item-breadcrumb', 'Editar')
@section('route-breadcrumb', route('customers.index'))
@section('section-breadcrumb', 'Clientes')
@section('module-breadcrumb', 'Gestión')


@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
  <div class="card-body">
    {{-- PUT /customers/{customer} → CustomerController@update --}}
    <form action="{{ route('customers.update', $customer) }}" method="POST">
      @csrf
      @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
      @include('management.customers._form') {{-- mismo formulario, ahora con $customer lleno --}}
    </form>
  </div>
</div>
@endsection
