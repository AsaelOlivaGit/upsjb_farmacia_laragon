@extends('template.administrador')

@section('title', 'MEDICAMENTOS')
@section('name-section', 'MEDICAMENTOS')

@section('description', 'Editar medicamento')
@section('item-breadcrumb', 'Editar')
@section('route-breadcrumb', route('medicines.index'))
@section('section-breadcrumb', 'Medicamentos')
@section('module-breadcrumb', 'Gestión')


@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
  <div class="card-body">
    {{-- PUT /medicines/{medicine} con archivo: también lleva enctype --}}
    <form action="{{ route('medicines.update', $medicine) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT') {{-- HTML solo envía GET/POST: así Laravel sabe que es update() --}}
      @include('management.medicines._form') {{-- mismo formulario, ahora con $medicine lleno --}}
    </form>
  </div>
</div>
@endsection
