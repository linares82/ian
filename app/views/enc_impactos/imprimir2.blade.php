@extends('layouts.tabs')

@section('contenido_tab')


 <div class="easyui-tabs" style="width:auto;height:auto;">
    <div title="Mostrar" style="padding:10px;"> 
 	
	{{ link_to_route('enc_impacto.index', 'Regresar', '', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }} 
	
	<div id="output" style="padding:30px;width:80%">	
	<table>
	<tr><td> <h3>Matriz de Leopold</h3> </td></tr>
	<tr><td>Cliente: {{{ $enc_impacto->cliente->cliente }}} </td></tr>
	<tr><td>Tipo de Impacto: {{{ $enc_impacto->tipoImpacto->tipo_impacto }}} </td></tr>
	<tr><td>Fecha: {{{ $enc_impacto->fecha }}}</td></tr>
	</table>
	
	
	<table border="1" style="font-size:.5 em;" cellpadding="2" cellspacing="0" align="center">
		<thead>
			<tr>
				<th rowspan="1" colspan="3"> 
					@foreach($efectos as $e)
						{{{ $e->efecto."-".$e->descripcion }}}<br/>
					@endforeach
				</th>
				@foreach($enc_impacto->regImpactos as $ri)
					@foreach($ri->lnCaracteristicas as $lc)
						<th rowspan="1"><div class="rotate"> {{{ $lc->caracteristica->caracteristica }}} </div></th>
					@endforeach
					<?php break; ?>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($enc_impacto->regImpactos as $ri)
			<tr >
				<td width="40">{{{ $ri->factor->factor }}}</td>
				<td width="40">{{{ $ri->rubro->rubro }}}</td>
				<td width="40">{{{ $ri->especifico->especifico }}}</td>
				@foreach($ri->lnCaracteristicas as $lc)
					<td width="20">{{{ $lc->efecto->efecto }}}</td>
				@endforeach

			</tr>
			@endforeach
		</tbody>
	</table>
	<table border="1" style="font-size:.5 em;" cellpadding="2" cellspacing="0" align="center">
		<tr><th> Segmento </th> <th> Total </th> <th> Porcentaje </th></tr>
		@foreach($segmentos as $s)
		<tr><td> {{{ $s->efecto }}} </td> <td> {{{ $s->total }}} </td> <td> {{{ round(($s->total*100)/$total, 2) }}} % </td></tr>
		@endforeach
		<tr><td><b> Total </b></td> <td> {{{ $total }}} </td> <td> {{{ ($total*100)/$total }}} % </td> </tr>
	</table>
</div>>	

</div>
</div>


@stop
@section('js_local')
<style type="text/css">
.rotate {
             filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
         -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
     -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
      -ms-transform: rotate(-90.0deg);  /* IE9+ */
       -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
  -webkit-transform: rotate(-90.0deg);  /* Safari 3.1+, Chrome */
          transform: rotate(-90.0deg);  /* Standard */
          width: 100%;
          height: 100%;
}

@media print {
  body  {
    visibility: hidden;
  }
  #output  {
    visibility: visible;
  }
  #output  {
    position: absolute;
    left: 0;
    top: 0;
  }
}

</style>
@stop