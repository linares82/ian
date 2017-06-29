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


<table style="width:100%;height:auto;border:1px solid #ccc;">
    <tr>
        <td style="width:33%;text-align:right" align="right">
            <img src="{{$img}}" alt="Logo" height=80>
        </td>
        <td style="width:33%;text-align:center" align="center">
            <h3> BITACORA DE    MANTENIMIENTO </h3>
        </td>
        <td style="width:33%;text-align:left" align="left">
            Fecha de Elaboración: {{$fecha}}
        </td>
    </tr>
</table>

<table id="dg" style="width:100%;height:auto;border-collapse: collapse;">
    <thead>
        <tr>
            <th data-options="field:'cia_id'" style="border:1px solid #ccc;">
                Entidad
            </th>
            <th data-options="field:'residuo'" style="border:1px solid #ccc;">
                Area
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Id
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Estatus
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Objetivo
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                H. Inv.
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                F. Planeada
            </th>
            <th data-options="field:'ubicacion'" style="border:1px solid #ccc;">
                Tpo. Manto.
            </th>
            
            <th data-options="field:'disposicion'" style="border:1px solid #ccc;">
                Nombre
            </th>
            <th data-options="field:'transportista'" style="border:1px solid #ccc;">
                F. Real
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Costo
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($ms as $m)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $m->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->equipo->area_id }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->id }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->estatus->estatus }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->objetivo->objetivo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->horas_inv }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->fec_planeada }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->tpoManto->tpo_manto }}
            </td>
            
            <td style="border:1px solid #ccc;">
                {{ $m->responsable->nombre }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->fec_final }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $m->costo }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
@section('js_local')
    
    <script type="text/javascript">
    
    </script>
@stop