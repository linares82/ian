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
            <h3> BITACORA DE PLANTAS </h3>
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
                Planta
            </th>
            <th data-options="field:'unidad'" style="border:1px solid #ccc;">
                T. Planta
            </th>
            <th data-options="field:'peligroso'" style="border:1px solid #ccc;">
                Ubicacion
            </th>
            <th data-options="field:'nombre'" style="border:1px solid #ccc;">
                C. Tratamiento
            </th>
            <th data-options="field:'fecha'" style="border:1px solid #ccc;">
                Responsable
            </th>
            <th data-options="field:'lugar_generacion'" style="border:1px solid #ccc;">
                Fecha
            </th>
            <th data-options="field:'cantidad'" style="border:1px solid #ccc;">
                Turno
            </th>
            <th data-options="field:'ubicacion'" style="border:1px solid #ccc;">
                A. Entrada
            </th>
            <th data-options="field:'disposicion'" style="border:1px solid #ccc;">
                A. Salida
            </th>
            <th data-options="field:'transportista'" style="border:1px solid #ccc;">
                Q. Usados
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Q. exitentes
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                T. Operación
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                Motivo Paro
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                V. Lodos
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                D. Lodos
            </th>
            <th data-options="field:'manifiesto'" style="border:1px solid #ccc;">
                F. U. Manto.
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($ps as $p)
        <tr>
            <td style="border:1px solid #ccc;">
                {{ $p->cia->rzon_social }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->planta->planta }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->planta->tipo_planta }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->planta->ubicacion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->planta->c_tratamiento }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->responsable->nombre }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->fecha }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->turno->turno }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->agua_entrada }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->agua_salida }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->q_usados }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->q_existentes }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->tiempo_operacion }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->motivo_paro }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->vol_lodos }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->disp_lodos }}
            </td>
            <td style="border:1px solid #ccc;">
                {{ $p->fec_ult_manto }}
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