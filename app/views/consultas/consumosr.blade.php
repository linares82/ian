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
            <h3> BITACORA DE CONSUMOS </h3>
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
                Consumible
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Unidad
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Fecha
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Consumo
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                F. Inicio 
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                F. Fin
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Costo
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($cs as $c)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $c->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->consumible->consumible }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->consumible->unidad }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->fecha }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->consumo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->fec_inicio }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->fec_fin }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $c->costo }}
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