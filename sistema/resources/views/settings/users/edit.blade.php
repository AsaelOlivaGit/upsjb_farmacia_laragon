@extends('template.administrador')

@section('title', 'USUARIOS')
@section('name-section', 'USUARIOS')

@section('description', 'Editar usuario')
@section('item-breadcrumb', 'Editar')
@section('route-breadcrumb', route('users.index'))
@section('section-breadcrumb', 'Usuarios')
@section('module-breadcrumb', 'Configuraciones')


@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
  <div class="card-body">
    {{-- PUT /users/{user} → UserController@update --}}
    <form action="{{ route('users.update', $user) }}" method="POST">
      @csrf
      @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
      @include('settings.users._form') {{-- mismo formulario, ahora con $user lleno --}}
    </form>
  </div>
</div>
@endsection
