@extends('template.administrador')

@section('title', 'USUARIOS')
@section('name-section', 'USUARIOS')

@section('description', 'Nuevo registro de usuario')
@section('item-breadcrumb', 'Nuevo')
@section('route-breadcrumb', route('users.index'))
@section('section-breadcrumb', 'Usuarios')
@section('module-breadcrumb', 'Configuraciones')


@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
  <div class="card-body">
    {{-- POST /users → UserController@store --}}
    <form action="{{ route('users.store') }}" method="POST">
      @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
      @include('settings.users._form') {{-- formulario compartido con edit --}}
    </form>
  </div>
</div>
@endsection
