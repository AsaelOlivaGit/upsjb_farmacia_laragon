<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de ventas</title>
  {{-- DomPDF no carga bootstrap.css: los estilos van aquí mismo y con CSS sencillo --}}
  <style>
    @page { margin: 30px 35px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #323232; } /* DejaVu muestra bien tildes y ñ */
    .header { border-bottom: 3px solid #ff0a41; padding-bottom: 8px; margin-bottom: 12px; }
    .brand { font-size: 18px; font-weight: bold; color: #ff0a41; }
    .muted { color: #6c757d; }
    .text-end { text-align: right; }
    table { width: 100%; border-collapse: collapse; }
    .summary td { width: 25%; padding: 8px; border: 1px solid #dee2e6; background: #f8f9fa; }
    .summary strong { font-size: 12px; }
    .detail { margin-top: 12px; }
    .detail th { background: #323232; color: #fff; padding: 6px 5px; text-align: left; font-size: 9px; text-transform: uppercase; }
    .detail td { padding: 5px; border-bottom: 1px solid #dee2e6; }
    .detail tfoot th { background: #fff; color: #323232; border-top: 2px solid #323232; }
  </style>
</head>
<body>

  {{-- Encabezado --}}
  <table class="header">
    <tr>
      <td>
        <div class="brand">FARM SJB</div>
        <div class="muted">Farmacia San Juan Bautista · Sistema de Venta de Medicamentos</div>
      </td>
      <td class="text-end muted">
        Generado el {{ now()->format('d/m/Y H:i') }}<br>
        por {{ auth()->user()->name }}
      </td>
    </tr>
  </table>

  <h3 style="margin: 0 0 6px 0">Reporte de ventas</h3>
  <p class="muted" style="margin: 0 0 10px 0">
    Del {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}
    · Cliente: {{ $filters['customer'] ?? 'Todos' }}
    · Vendedor: {{ $filters['user'] ?? 'Todos' }}
    · Categoría: {{ $filters['category'] ?? 'Todas' }}
  </p>

  {{-- Resumen --}}
  <table class="summary">
    <tr>
      <td>N.° de ventas<br><strong>{{ $summary['count'] }}</strong></td>
      <td>Total vendido<br><strong>S/ {{ number_format($summary['total'], 2) }}</strong></td>
      <td>IGV<br><strong>S/ {{ number_format($summary['igv'], 2) }}</strong></td>
      <td>Venta promedio<br><strong>S/ {{ number_format($summary['average'], 2) }}</strong></td>
    </tr>
  </table>

  {{-- Detalle --}}
  <table class="detail">
    <thead>
      <tr><th>N.°</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th><th class="text-end">IGV</th><th class="text-end">Total</th></tr>
    </thead>
    <tbody>
      @forelse ($sales as $sale)
        <tr>
          <td>{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $sale->date->format('d/m/Y H:i') }}</td>
          <td>{{ $sale->customer->name }}</td>
          <td>{{ $sale->user->name }}</td>
          <td class="text-end">S/ {{ number_format($sale->igv, 2) }}</td>
          <td class="text-end">S/ {{ number_format($sale->total, 2) }}</td>
        </tr>
      @empty
        <tr><td colspan="6" class="muted" style="text-align:center">No hay ventas con esos filtros.</td></tr>
      @endforelse
    </tbody>
    @if ($sales->isNotEmpty())
      <tfoot>
        <tr>
          <th colspan="4" class="text-end">Totales</th>
          <th class="text-end">S/ {{ number_format($summary['igv'], 2) }}</th>
          <th class="text-end">S/ {{ number_format($summary['total'], 2) }}</th>
        </tr>
      </tfoot>
    @endif
  </table>

</body>
</html>
