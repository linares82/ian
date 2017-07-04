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
<table style="width:100%;height:auto;border:1px solid #ccc;font-size: 0.75em;">
    <tr>
        <td style="width:33%;text-align:right" align="right">
            <img src="{{$img}}" alt="Logo" height=80>
        </td>
        <td style="width:33%;text-align:center" align="center">
            <h3> BITACORA DE ASPECTOS AMBIENTALES </h3>
        </td>
        <td style="width:33%;text-align:left" align="left">
            Fecha de Elaboración: {{$fecha}}
        </td>
    </tr>
</table>

<table id="dg" style="width:100%;height:auto;border-collapse: collapse;font-size: 0.75em;">
    <thead>
        <tr>
            <th data-options="field:'cia_id'" style="border:1px solid #ccc;">
                Entidad
            </th>
            <th data-options="field:'residuo'" style="border:1px solid #ccc;">
                Area
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Proceso
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Actividad
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Descripción
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                Aspecto
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                5 EMES
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Condición
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Impacto
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                A.L.F.
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                A.L.E.
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                O.C.
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Quejas
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Severidad
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                I.P.
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                I.R.
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($ass as $as)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $as->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->area->area }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->proceso->proceso }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->descripcion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->aspecto->aspectos }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->eme->eme }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->condicion->condicion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->impacto->impacto }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->alFederalBnd->bnd }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->alEstatalBnd->bnd }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->objCorporativoBnd->bnd }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->quejasBnd->bnd }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->severidad->descripcion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->frecuencia->duracion_accion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->impPotencial->imp_potencial }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $as->impReal->imp_real }}
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