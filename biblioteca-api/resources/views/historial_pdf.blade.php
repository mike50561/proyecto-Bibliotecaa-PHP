<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
  </style>
  <title>Historial de Préstamos</title>
</head>
<body>
  <h2>Historial de Préstamos - {{ $usuario->nombre }}</h2>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Libro</th>
        <th>Fecha Préstamo</th>
        <th>Fecha Devolución</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($historial as $i => $prestamo)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $prestamo->libro->titulo }}</td>
        <td>{{ $prestamo->fecha_prestamo }}</td>
        <td>{{ $prestamo->fecha_devolucion }}</td>
        <td>{{ $prestamo->estado }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
