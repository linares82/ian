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
            <h3> BITACORA DE RESIDUOS </h3>
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
                Residuo
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Cantidad
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Unidad
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Peligroso
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                Lugar de Generación
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Fecha de Ingreso
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Fecha de Salida
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Fase Manejo
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Nombre Transportista
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Autorización Transportista
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                Responsable Tecnico
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Manifiesto
            </th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($rs as $r)
        <tr>
            <td style="border:1px solid #ccc;height:60px">
                {{ $r->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->residuos->residuo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->cantidad }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->residuos->unidad }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->peligrosidad }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->lugar_generacion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->fec_ingreso }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->fec_salida }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->dispocision }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->transportista }}
            </td>
            <td style="border:1px solid #ccc;">
                
            </td>
            <td style="border:1px solid #ccc;">
                {{ $r->responsable->nombre }}
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
    <script type="text/php">
        if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }
    </script>
@stop