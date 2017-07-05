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
            <h3> BITACORA DE ACCIDENTES </h3>
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
                Fecha
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Accidente
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Responsable
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                C. Indirecto 
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                C. Directo
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Descripcion
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Procedimiento
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Investigación
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($as as $a)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $a->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->area->area }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->fecha }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->accidente->accidente }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->responsable->nombre }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->costo_indirecto }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->costo_directo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->descripcion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->procedimiento }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $a->investigacion }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@stop
@section('js_local')
    <script type="text/php">
        if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }
    </script>
@stop