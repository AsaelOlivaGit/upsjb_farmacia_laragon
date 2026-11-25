@extends('template.administrador')



@section('title', 'ROLES')

@section('name-section', 'ROLES')



@section('description', 'Nuevo registro de roles')

@section('item-breadcrumb', 'Inicio')

@section('route-breadcrumb', route('roles.index'))
@section('section-breadcrumb', 'Roles')

@section('module-breadcrumb', 'Configuraciones')





@section('content')

<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">

  <div class="card-body">

    <form action="{{ route('roles.store') }}" method="POST">

      @csrf

      @include('settings.roles._form')

    </form>

  </div>

</div>



@endsection
