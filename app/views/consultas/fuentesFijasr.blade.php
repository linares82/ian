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
            <h3> BITACORA DE CONSUMO DE FUENSTES FIJAS </h3>
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
                Fuente Fija
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                Marca
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Capacidad Térmica
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                Ubicación
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                T. Combustible
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                Responsable
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Fecha
            </th>
            <th data-options="field:'ubicacion'" style="border:1px solid #ccc;">
                Consumo
            </th>
            <th data-options="field:'disposicion'" style="border:1px solid #ccc;">
                C. Diseño
            </th>
            <th data-options="field:'transportista'" style="border:1px solid #ccc;">
                T. P. Gases
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                T. P. Chimenea
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                F. Ult. Manto.
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Ult. Manto.
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($fs as $f)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $f->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fuenteFija->planta }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fuenteFija->marca }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fuenteFija->c_termica }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fuenteFija->ubicacion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fuenteFija->tipo_combustible }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->nombre }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fec_ult_manto }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->consumo }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->capacidad_diseno }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->tp_gases }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->tp_chimenea }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->fec_ult_manto }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $f->desc_manto }}
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