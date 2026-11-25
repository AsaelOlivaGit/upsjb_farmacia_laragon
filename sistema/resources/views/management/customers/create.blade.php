@extends('template.administrador')

@section('title', 'CLIENTES')
@section('name-section', 'CLIENTES')

@section('description', 'Nuevo registro de cliente')
@section('item-breadcrumb', 'Nuevo')
@section('route-breadcrumb', route('customers.index'))
@section('section-breadcrumb', 'Clientes')
@section('module-breadcrumb', 'Gestión')


@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
  <div class="card-body">
    {{-- POST /customers → CustomerController@store --}}
    <form action="{{ route('customers.store') }}" method="POST">
      @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
      @include('management.customers._form') {{-- formulario compartido con edit --}}
    </form>
  </div>
</div>
@endsection
