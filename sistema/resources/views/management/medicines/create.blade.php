@extends('template.administrador')

@section('title', 'MEDICAMENTOS')
@section('name-section', 'MEDICAMENTOS')

@section('description', 'Nuevo registro de medicamento')
@section('item-breadcrumb', 'Nuevo')
@section('route-breadcrumb', route('medicines.index'))
@section('section-breadcrumb', 'Medicamentos')
@section('module-breadcrumb', 'Gestión')


@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
  <div class="card-body">
    {{-- enctype="multipart/form-data": sin esto el navegador no envía el archivo de la imagen --}}
    <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
      @csrf {{-- token de seguridad; sin él aparece el error 419 --}}
      @include('management.medicines._form') {{-- formulario compartido con edit --}}
    </form>
  </div>
</div>
@endsection
