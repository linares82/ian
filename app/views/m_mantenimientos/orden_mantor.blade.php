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


<table style="width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:33%;text-align:right" align="right">
            <img src="{{ $img }}" alt="Logo" height=80>
        </td>
        <td style="width:33%;text-align:center" align="center">
            <h3> ORDEN DE MANTENIMIENTO </h3>
        </td>
        <td style="width:33%;text-align:left" align="left">
            Fecha de Elaboración: {{$fecha}}
        </td>
    </tr>
</table>
<table bgcolor="#D8D8D8" style="width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:33%;text-align:right" align="right">
            
        </td>
        <td style="width:33%;text-align:center" align="center">
            Datos de la Orden
        </td>
        <td style="width:33%;text-align:left" align="left">
            
        </td>
    </tr>
</table>
<table id="dg" style="width:100%;height:auto;border-collapse: collapse;font-size: 1em;">
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        No.
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->no_orden }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        
    </td>
    <td style="border:1px solid #ccc;width:28%">
        
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Tipo
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->tpoManto->tpo_manto }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Equipo
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->objetivo->objetivo }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Subequipo
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->subequipo }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
       Marca 
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->marca }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Clase
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->clase }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Fecha de Carga
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->fecha_carga }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Modelo
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->modelo }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Area
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->rArea->area }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Ubicación
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->equipo->ubicacion }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        
    </td>
    <td style="border:1px solid #ccc;width:28%">
        
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Solicitante
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->solicitante->nombre }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Fecha Planeada
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->fec_planeada }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Descripción
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->descripcion }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Lugar
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->lugar }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Ejecutor
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->ejecutor->nombre }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Responsable
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->responsable->nombre }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Recomendaciones
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->recomendaciones }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Materiales
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->materiales }}
    </td>
</tr>
<tr>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Horas Invertidas
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->horas_inv }}
    </td>
    <td style="border:1px solid #ccc;width:4%">
    </td>
    <td style="border:1px solid #ccc;height:auto;width:20%">
        Costo
    </td>
    <td style="border:1px solid #ccc;width:28%">
        {{ $m->costo }}
    </td>
</tr>
       
</table>
<table bgcolor="#D8D8D8" style="width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:20%;text-align:right" align="right">
            
        </td>
        <td style="width:60%;text-align:center" align="center">
            Autorización de Trabajo Potencialmente Peligroso
        </td>
        <td style="width:20%;text-align:left" align="left">
            
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿Requiere TPP?
        </td>
        <td style="width:5%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->Tpp->bnd}}
        </td>
        <td style="height:50px;width:50%;border:1px solid #ccc" rowspan=2>
            
        </td>
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc" colspan=2>
            Riesgos: {{$m->riesgos}}
        </td>
        
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿Hay supervisión por parte de seguridad o responsable de estación?
        </td>
        <td style="width:5%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->supervision->bnd}}
        </td>
        <td style="width:50%;border:1px solid #ccc;text-align:center">
            {{ $m->responsable->nombre }}
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿Conoce el procedimiento de trabajo?
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->conoceProcedimiento->bnd}}    
        </td>
        <td style="height:50px;width:50%;border:1px solid #ccc" rowspan=2>
            
        </td>
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿El personal lleva el equipo de seguridadque indica la presente autorización?
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->llevaEquipo->bnd}}    
        </td>
        
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿Cumplen con los puntos aplicables de la fracción 8.4 y las que la componen de la norma NOM-005-ASEA-2016?
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->cumplePuntos->bnd}}
        </td>
        <td style="width:50%;border:1px solid #ccc;;text-align:center;">
            {{$m->ejecutor->nombre}}
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:40%;border:1px solid #ccc;" colspan=2>
            Estatus: {{$m->estatus->estatus}}
        </td>
        <td style="height:50px;width:50%;border:1px solid #ccc" rowspan=5>
            Accion: {{$m->accion}}
        </td>
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            Eventualidades
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->eventualidades->bnd}}    
        </td>
        
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿Se levanto formato de accidentes?
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->levantarFormato->bnd}}    
        </td>
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            ¿Se registro en bitacora la actividad?
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->registroBitacora->bnd}}    
        </td>
    </tr>
    <tr>
        <td style="width:40%;border:1px solid #ccc;">
            Fecha final
        </td>
        <td style="width:10%;text-align:center;border:1px solid #ccc;" align="center">
            {{$m->fec_final}}    
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="width:100%;border:1px solid #ccc;" colspan=2>
            Resultado: {{$m->resultado}}
        </td>
    </tr>
    <tr>
        <td style="width:100%;border:1px solid #ccc;" colspan=2>
            Observaciones: {{$m->observaciones}}
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;width:100%;height:auto;border:1px solid #ccc;font-size: 1em;">
    <tr>
        <td style="height:60px;width:50%;border:1px solid #ccc;">
            </br>
            </br>
            </br>
        </td>
        <td style="height:60px;width:50%;border:1px solid #ccc;">
            </br>
            </br>
            </br>
        </td>
    </tr>
    <tr>
        <td style="text-align:center;width:50%;border:1px solid #ccc;">
            {{$m->responsable->nombre}}
        </td>
        <td style="text-align:center;width:50%;border:1px solid #ccc;">
            {{$m->ejecutor->nombre}}
        </td>
    </tr>
</table>
@stop
@section('js_local')
    <script type="text/php">
        if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            //$pdf->page_text(50, 760, "Codigo de seguridad: '{{ Hash::make($m->no_orden) }}'", $font, 7, array(0, 0, 0));
            $pdf->page_text(510, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 7, array(0, 0, 0));
            }
    </script>
@stop