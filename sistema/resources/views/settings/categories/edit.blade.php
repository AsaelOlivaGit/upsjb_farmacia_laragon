@extends('template.administrador')


@section('title', 'CATEGORIAS')
@section('name-section', 'CATEGORIAS')


@section('description', 'Editar categoría')
@section('item-breadcrumb', 'Inicio')
@section('route-breadcrumb', route('categories.index'))
@section('section-breadcrumb', 'Categorías')
@section('module-breadcrumb', 'Configuraciones')





@section('content')

<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">

  <div class="card-body">

    <form action="{{ route('categories.update', $category) }}" method="POST">

      @csrf
      @method('PUT')

      @include('settings.categories._form')

    </form>

  </div>

</div>



@endsection