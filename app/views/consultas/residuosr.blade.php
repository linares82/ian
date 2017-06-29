@extends('layouts.tabs')

@section('contenido_tab')
<style>
@media print {
   table, th, td
    {
        border-collapse:collapse;
        border: 1px solid black;
        width:100%;
        text-align:right;
    }
}
</style>

<div id="printeArea">
<table style="width:100%;height:auto;border:1px solid #ccc;">
    <tr>
        <td style="width:33%;text-align:right" align="right">
            <img src="{{$img}}" alt="Logo" height=80>
        </td>
        <td style="width:33%;text-align:center" align="center">
            <h3> BITACORA DE RESIDUOS </h3>
        </td>
        <td style="width:33%;text-align:left" align="left">
            Fecha de Elaboración: {{$fecha}}
        </td>
    </tr>
</table>

<table id="dg" style="width:auto;height:auto;border-collapse: collapse;">
    <thead>
        <tr>
            <th data-options="field:'cia_id'" style="border:1px solid #ccc;">
                Entidad
            </th>
            <th data-options="field:'residuo'" style="border:1px solid #ccc;">
                Residuo
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Unidad
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Peligroso
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Nombre
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                Fecha 
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                Lugar de Generación
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Cantidad
            </th>
            <th data-options="field:'ubicacion'" style="border:1px solid #ccc;">
                Ubicación
            </th>
            <th data-options="field:'disposicion'" style="border:1px solid #ccc;">
                Disposición
            </th>
            <th data-options="field:'transportista'" style="border:1px solid #ccc;">
                Transportista
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Manifiesto
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($rs as $r)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $r->cia_id }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->residuos->residuo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->residuos->unidad }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->residuos->Bnd->bnd }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->responsable->nombre }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->fecha }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->lugar_generacion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->cantidad }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->ubicacion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->disposicion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->transportista }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->manifiesto }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@stop
@section('js_local')
    
    <script type="text/javascript">
    
    </script>
@stop