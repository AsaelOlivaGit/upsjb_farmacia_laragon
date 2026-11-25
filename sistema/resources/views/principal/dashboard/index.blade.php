{{-- Vista hija: hereda la plantilla padre --}}
@extends('template.administrador')

{{-- Textos que la plantilla muestra en sus huecos --}}
@section('title', 'DASHBOARD')
@section('name-section', 'DASHBOARD')

@section('description', 'Resumen de estadísticas')
@section('item-breadcrumb', 'Inicio')
@section('route-breadcrumb', route('dashboard.index'))
@section('section-breadcrumb', 'Dashboard')
@section('module-breadcrumb', 'Principal')

{{-- Contenido del dashboard: KPIs y gráficos en próximas sesiones --}}
@section('content')
<p>Contenido del dashboard</p>
@endsection
