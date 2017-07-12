@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($m_mantenimiento, array('class' => 'form', 'method' => 'PUT', 'url' => 'm_mantenimiento/update/'.$m_mantenimiento->id, 'files'=>true, 'id'=>'f_mantenimiento')) }}
     <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Editar" style="padding:10px;"> 

		<div class="row">
                <div class="col-md-10 col-md-offset-2">

                    @if ($errors->any())
                        <div class="errorSumary">
                            Por favor corregir los siguientes errores de captura: 
                            <ul >
                                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                            </ul>
                        </div>
                        
                    @endif

                </div>
            </div>

        <div id="p" class="easyui-panel" title="DATOS INICIALES DEL MANTENIMIENTO" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ( $errors->has('no_orden')) has-error @endif">
            {{ Form::label('no_orden', 'No. Orden:') }}
              {{ Form::text('id', Input::old('id'), array('placeholder'=>'No. Orden', 'readonly'=>'readonly')) }}
            
        </div>
		
		<div class="row_1 @if ( $errors->has('m_tpo_manto_id')) has-error @endif">
            {{ Form::label('m_tpo_manto_id', 'Tipo:') }}
              {{ Form::select('m_tpo_manto_id', $tpo_mantos_ls, Input::old('m_tpo_manto_id'))  }}
            {{ $errors->first('m_tpo_manto_id', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('objetivo_id')) has-error @endif">
            {{ Form::label('objetivo_id', 'Equipo:') }}
              {{ Form::select('objetivo_id', $objetivos_ls, Input::old('objetivo_id'))  }}
            {{ $errors->first('objetivo_id', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('subequipo_id')) has-error @endif" style="clear:left;">
            {{ Form::label('subequipo_id', 'Subequipo:') }}
              {{ Form::select('subequipo_id', $subequipos_ls, Input::old('subequipo_id'))  }}
            {{ $errors->first('subequipo_id', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
		
		<div class="row @if ( $errors->has('subequipo_id')) has-error @endif" style="clear:left;">
		<input type="textarea" id="detalle_s">
		</div>
		
		<div class="row_1 @if ( $errors->has('sollicitante_id')) has-error @endif">
            {{ Form::label('solicitante_id', 'Solicitante:') }}
              {{ Form::select('solicitante_id', $solicitantes_ls, Input::old('solicitante_id'))  }}
            {{ $errors->first('solicitante_id', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('fec_planeada')) has-error @endif" >
            {{ Form::label('fec_planeada', 'F. Planeada:') }}
              {{ Form::text('fec_planeada', Input::old('F. Planeada'), array('placeholder'=>'Fec_planeada', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser')) }}
            {{ $errors->first('fec_planeada', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('aviso_bnd')) has-error @endif" style='clear:left'>
            {{ Form::label('aviso_bnd', 'Aviso:') }}
              {{ Form::select('aviso_bnd', $aviso_bnd_ls, Input::old('aviso_bnd'))  }}
            {{ $errors->first('aviso_bnd', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias Aviso:') }}
              {{ Form::text('dias_aviso', Input::old('dias_aviso'), array('placeholder'=>'Dias Aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('fec_inicio')) has-error @endif" >
            {{ Form::label('fec_inicio', 'F. Inicio:') }}
              {{ Form::text('fec_inicio', Input::old('fec_inicio'), array('placeholder'=>'fec_inicio', 'class'=>'easyui-datetimebox', 'data-options'=>'required:true,showSeconds:false', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_inicio', '<div class="errorMessage">:message</div>') }}
        </div>
		<div class="row_1 @if ( $errors->has('fec_final')) has-error @endif" >
            {{ Form::label('fec_final', 'F. Final:') }}
              {{ Form::text('fec_final', Input::old('fec_final'), array('placeholder'=>'fec_final', 'class'=>'easyui-datetimebox', 'data-options'=>'required:true,showSeconds:false', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_final', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row @if ( $errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripcion:') }}
              {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row @if ( $errors->has('lugar')) has-error @endif">
            {{ Form::label('lugar', 'Lugar:') }}
              {{ Form::text('lugar', Input::old('lugar'), array('placeholder'=>'Lugar')) }}
            {{ $errors->first('lugar', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('ejecutor_id')) has-error @endif">
            {{ Form::label('ejecutor_id', 'Ejecutor:') }}
              {{ Form::select('ejecutor_id', $ejecutores_ls, Input::old('ejecutor_id'))  }}
            {{ $errors->first('ejecutor_id', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row @if ( $errors->has('recomendaciones')) has-error @endif">
            {{ Form::label('recomendaciones', 'Recomendaciones:') }}
              {{ Form::text('recomendaciones', Input::old('recomendaciones'), array('placeholder'=>'Recomendaciones')) }}
            {{ $errors->first('recomendaciones', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row @if ( $errors->has('materiales')) has-error @endif">
            {{ Form::label('materiales', 'Materiales:') }}
              {{ Form::text('materiales', Input::old('materiales'), array('placeholder'=>'Materiales')) }}
            {{ $errors->first('materiales', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('horas_inv')) has-error @endif">
            {{ Form::label('horas_inv', 'Horas Inv.:') }}
              {{ Form::text('horas_inv', Input::old('horas_inv'), array('placeholder'=>'0.00')) }}
            {{ $errors->first('horas_inv', '<div class="errorMessage">:message</div>') }}
        </div>
		
		<div class="row_1 @if ( $errors->has('costo')) has-error @endif">
            {{ Form::label('costo', 'Costo:') }}
              {{ Form::text('costo', Input::old('costo'), array('placeholder'=>'Costo')) }}
            {{ $errors->first('costo', '<div class="errorMessage">:message</div>') }}
        </div>
		<!--
		<div id="p" class="easyui-panel" title="DATOS DE EJECUCION DEL MANTENIMIENTO" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>
		-->
		
		<div id="p" class="easyui-panel" title="" style="width:96%;margin-top:10px;margin-bottom:15px;">
        
			<div class="row_1 @if ( $errors->has('tpp_bnd')) has-error @endif">
				{{ Form::label('tpp_bnd', '¿Rquiere TPP?:') }}
				{{ Form::select('tpp_bnd', $tpp_bnd_ls, Input::old('tpp_bnd'))  }}
				{{ $errors->first('tpp_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
		
		</div>
		
		<div id="seccion_tpp">
		
			<div class="row_1 @if ( $errors->has('riesgos')) has-error @endif" style='clear:left'>
				{{ Form::label('riesgos', 'Riesgos:') }}
				  {{ Form::text('riesgos', Input::old('riesgos'), array('placeholder'=>'riesgos')) }}
				{{ $errors->first('riesgos', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('supervision_bnd')) has-error @endif">
				{{ Form::label('supervision_bnd', '¿Hay supervisión por parte deseguridad o responsable de estación? :') }}
				{{ Form::select('supervision_bnd', $supervision_bnd_ls, Input::old('supervision_bnd'))  }}
				{{ $errors->first('supervision_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('conoce_procedimiento_bnd')) has-error @endif">
				{{ Form::label('conoce_procedimiento_bnd', '¿Conoce el procedimiento de trabajo? :') }}
				{{ Form::select('conoce_procedimiento_bnd', $conoce_procedimiento_bnd_ls, Input::old('conoce_procedimiento_bnd'))  }}
				{{ $errors->first('conoce_procedimiento_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('lleva_equipo_bnd')) has-error @endif" style='clear:left'>
				{{ Form::label('lleva_equipo_bnd', '¿El personal lleva el equipo de seguridad que indica la presente autorizacion? :') }}
				{{ Form::select('lleva_equipo_bnd', $lleva_equipo_bnd_ls, Input::old('lleva_equipo_bnd'))  }}
				{{ $errors->first('lleva_equipo_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('cumple_puntos_bnd')) has-error @endif">
				{{ Form::label('cumple_puntos_bnd', '¿Cumplen con los puntos aplicables de la fracción 8.4,y las que la componen de la norma NOM-005-ASEA-2016? :') }}
				{{ Form::select('cumple_puntos_bnd', $cumple_puntos_bnd_ls, Input::old('cumple_puntos_bnd'))  }}
				{{ $errors->first('cumple_puntos_bnd', '<div class="errorMessage">:message</div>') }}
			</div>

		</div>
			
		<div id="p" class="easyui-panel" title="" style="width:96%;margin-top:10px;margin-bottom:15px;">
        
			<div class="row_1 @if ( $errors->has('estatus_id')) has-error @endif">
				{{ Form::label('estatus_id', 'Estatus:') }}
				  {{ Form::select('estatus_id', $estatus_ls, Input::old('estatus_id'))  }}
				{{ $errors->first('estatus_id', '<div class="errorMessage">:message</div>') }}
			</div>
		
		</div>
		
		<div id="seccion_estatus">
		
			<div class="row_1 @if ( $errors->has('eventualidades_bnd')) has-error @endif" style='clear:left'>
				{{ Form::label('eventualidades_bnd', 'Eventualidades :') }}
				{{ Form::select('eventualidades_bnd', $eventualidades_bnd_ls, Input::old('eventualidades_bnd'))  }}
				{{ $errors->first('eventualidades_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('levantar_formato_bnd')) has-error @endif" >
				{{ Form::label('levantar_formato_bnd', 'Se levanto formato de accidentes:') }}
				{{ Form::select('levantar_formato_bnd', $levantar_formato_bnd_ls, Input::old('levantar_formato_bnd'))  }}
				{{ $errors->first('levantar_formato_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('registro_bitacora_bnd')) has-error @endif" >
				{{ Form::label('registro_bitacora_bnd', 'Se registro en bitácora la actividad:') }}
				{{ Form::select('registro_bitacora_bnd', $registro_bitacora_bnd_ls, Input::old('registro_bitacora_bnd'))  }}
				{{ $errors->first('registro_bitacora_bnd', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row @if ( $errors->has('accion')) has-error @endif" style="clear:left;">
				{{ Form::label('accion', 'Acción:') }}
				  {{ Form::text('accion', Input::old('accion'), array('placeholder'=>'Acción', 'width'=>'100%')) }}
				{{ $errors->first('accion', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row @if ( $errors->has('resultado')) has-error @endif" style="clear:left;">
				{{ Form::label('resultado', 'Resultado:') }}
				  {{ Form::text('resultado', Input::old('resultado'), array('placeholder'=>'Resultado', 'width'=>'100%')) }}
				{{ $errors->first('resultado', '<div class="errorMessage">:message</div>') }}
			</div>
			
			<div class="row_1 @if ( $errors->has('fec_final')) has-error @endif" style='clear:left'>
				{{ Form::label('fec_final', 'F. final:') }}
				  {{ Form::text('fec_final', Input::old('F. final'), array('placeholder'=>'fec_final', 'class'=>'easyui-datetimebox', 'data-options'=>'required:true,showSeconds:false', 'style'=>'width:85%')) }}
				{{ $errors->first('fec_final', '<div class="errorMessage">:message</div>') }}
			</div>
			
		</div>
		
		<div class="row_1 @if ( $errors->has('observaciones')) has-error @endif">
            {{ Form::label('observaciones', 'Observaciones:') }}
              {{ Form::text('observaciones', Input::old('observaciones'), array('placeholder'=>'Observaciones')) }}
            {{ $errors->first('observaciones', '<div class="errorMessage">:message</div>') }}
        </div>        

		<div class="row_buttons">
			  {{ Form::submit('Guardar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('m_mantenimiento.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
		
		<div id="seccion">
			<div class="row_1">
				{{ Form::label('archivo', 'Archivo:') }}
				  {{ Form::file('file1', array('id'=>'file1')) }}
				*El nombre de archivo no debe contener espacios en blanco
			</div>
			<div class="row_1">
				{{ Form::label('documento', 'Documento:') }}
				  {{ Form::text('documento', null, array('placeholder'=>'Documento')) }}
				{{ $errors->first('documento', '<div class="errorMessage">:message</div>') }}
			</div>
		
		</div>
		<br/>
		<div class="datagrid row">
			<table>
				<thead>
					<th>Documento</th>
					<th>Ver</th>
					<th>Eliminar</th>
				</thead>
					
				<tbody>
					@foreach($documentos as $d)
					<tr>
						<td>{{ $d->documento }}</td>
						<td><a href="{{ asset('uploads/'.$cia.'/'.$usuario.'/manto_doc/'.$d->archivo) }}" target='_blank'>{{ $d->archivo }}</a></td>
						<td>{{ link_to_route('manto_doc.destroy', 'Eliminar', $parameters = array('id'=>$d->id), $attributes = array()) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table
		</div>
		
	</div>
</div>

{{ Form::close() }}

@stop

@section('js_local')
<script type="text/javascript">

    function myformatter(date){
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate();
        return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
    }
    function myparser(s){
        if (!s) return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0],10);
        var m = parseInt(ss[1],10);
        var d = parseInt(ss[2],10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
            return new Date(y,m-1,d);
        } else {
            return new Date();
        }
    }

	jQuery(document).ready(function() {
		var st = $("#estatus_id option:selected").val(); 
		if(st==3){
			//$("#row_1 :input").attr("disabled", true);
			$('.row_1').find('input, textarea, select').attr('disabled','disabled');
			$('.row').find('input, textarea, select').attr('disabled','disabled');
		}
		
		$("#riesgos").val('');
		$("#supervision_bnd").val('2');
		$("#conoce_procedimiento_bnd").val('2');
		$("#lleva_equipo_bnd").val('2');
		$("#cumple_puntos_bnd").val('2');
		
		if($("#tpp_bnd option:selected").val()==1){
			$("#seccion_tpp").show();
		}else{
			$("#seccion_tpp").hide();
		}
		if($("#estatus_id option:selected").val()==3){
			$("#seccion_estatus").show();
		}else{
			$("#seccion_estatus").hide();
		}
		
		
		
		
		/*$("#riesgos").hide();
		$("#supervision_bnd").hide();
		$("#conoce_procedimiento_bnd").hide();
		$("#lleva_equipo_bnd").hide();
		$("#cumple_puntos_bnd").hide();
		*/
		$("#supervision_bnd").val('2');
		$("#conoce_procedimiento_bnd").val('2');
		$("#lleva_equipo_bnd").val('2');
		$("#cumple_puntos_bnd").val('2');
		
		$("#eventualidades_bnd").val('2');
		$("#levantar_formato_bnd").val('2');
		$("#registro_bitacora_bnd").val('2');
		
		/*$("#eventualidades_bnd").hide();
		$("#levantar_formato_bnd").hide();
		$("#registro_bitacora_bnd").hide();
		$("#accion").hide();
		$("#resultado").hide();
		$("#fec_final").hide();
		*/
		//conEquipo();
		function conEquipo(){
			var a= $('#f_mantenimiento').serialize();
            $.ajax({
                url: "{{url('/m_mantenimiento/conEquipo')}}",
                type: 'GET',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(ss){
                    $('select#subequipo_id').html('');
                    $('select#subequipo_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(ss, function(i) {
                        $('select#subequipo_id').append("<option "+ss[i].selectec+" value=\""+ss[i].id+"\">"+ss[i].subequipo+"<\/option>");
                    });
                }
            });
			//conSubequipo();
		}
		$("#objetivo_id").change(function(event) {
            conEquipo();
        });
		
		conSubequipo();
		
		function conSubequipo(){
			var id = $("#subequipo_id option:selected").val(); 
            $.ajax({
                url: "{{url('/m_mantenimiento/conSubequipo')}}"+'/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(s){
					
                    $('detalle_s').val('');
					$.each(s, function(i) {
						//alert(s[i].clase);
						$('#detalle_s').val(s[i].clase+", "+s[i].marca+", "+s[i].modelo+", "+s[i].no_serie+", "+s[i].fecha_carga+", "+s[i].area+", "+s[i].ubicacion);
					});
                }
            });
		}
		
		
        $("#subequipo_id").change(function(event) {
            conSubequipo();
        });
		
		$("#tpp_bnd").change(function(event) {
            var r = $("#tpp_bnd option:selected").val(); 
			if (r==2){
				$("#seccion_tpp").hide();
				/*$("#riesgos").hide();
				$("#supervision_bnd").hide();
				$("#conoce_procedimiento_bnd").hide();
				$("#lleva_equipo_bnd").hide();
				$("#cumple_puntos_bnd").hide();*/
				
			} else if(r==1){
				$("#seccion_tpp").show();
				/*$("#riesgos").show();
				$("#supervision_bnd").show();
				$("#conoce_procedimiento_bnd").show();
				$("#lleva_equipo_bnd").show();
				$("#cumple_puntos_bnd").show();*/
			}
        });
		
		$("#estatus_id").change(function(event) {
            var r = $("#estatus_id option:selected").val(); 
			if (r==3){
				$("#seccion_estatus").show();
				/*$("#eventualidades_bnd").show();
				$("#levantar_formato_bnd").show();
				$("#registro_bitacora_bnd").show();
				$("#accion").show();
				$("#resultado").show();
				$("#fec_final").show();*/
				
			} else {
				$("#seccion_estatus").hide();
				/*$("#eventualidades_bnd").hide();
				$("#levantar_formato_bnd").hide();
				$("#registro_bitacora_bnd").hide();
				$("#accion").hide();
				$("#resultado").hide();
				$("#fec_final").hide();*/
			}
        });
        
    });
	
</script>
@stop
