@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($bitacora_seguridad, array('class' => 'form', 'method' => 'POST', 'url' => 'bitacora_seguridad/update/'.$bitacora_seguridad->id, 'id'=>'f_bitacora_seguridad')) }}
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

        <div class="row_1 @if ( $errors->has('fecha')) has-error @endif">
            {{ Form::label('fecha', 'Fecha:') }}
              {{ Form::text('fecha', Input::old('fecha'), array('placeholder'=>'Fecha', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tpo_deteccion_id')) has-error @endif">
            {{ Form::label('tpo_deteccion_id', 'T. Deteccion:') }}
              {{ Form::select('tpo_deteccion_id', $tpo_detecciones_ls, Input::old('tpo_deteccion_id'))  }}
            {{ $errors->first('tpo_deteccion_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('area_id')) has-error @endif">
            {{ Form::label('area_id', 'Area:') }}
              {{ Form::select('area_id', $areas_ls, Input::old('area_id'))  }}
            {{ $errors->first('area_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tpo_bitacora_id')) has-error @endif">
            {{ Form::label('tpo_bitacora_id', 'T. Bitacora:') }}
              {{ Form::select('tpo_bitacora_id', $tpo_bitacoras_ls, Input::old('tpo_bitacora_id'))  }}
            {{ $errors->first('tpo_bitacora_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tpo_inconformidad_id')) has-error @endif">
            {{ Form::label('tpo_inconformidad_id', 'T. Inconformidad:') }}
              <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
              {{ Form::select('tpo_inconformidad_id', $tpo_inconformidades_ls, Input::old('tpo_inconformidad_id'))  }}
            {{ $errors->first('tpo_inconformidad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('inconformidad')) has-error @endif">
            {{ Form::label('inconformidad', 'Inconformidad:') }}
              {{ Form::text('inconformidad', Input::old('inconformidad'), array('placeholder'=>'Inconformidad')) }}
            {{ $errors->first('inconformidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('solucion')) has-error @endif">
            {{ Form::label('solucion', 'Solucion:') }}
              {{ Form::text('solucion', Input::old('solucion'), array('placeholder'=>'Solucion')) }}
            {{ $errors->first('solucion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('costo')) has-error @endif">
            {{ Form::label('costo', 'Costo:') }}
              {{ Form::text('costo', Input::old('costo'), array('placeholder'=>'Costo')) }}
            {{ $errors->first('costo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias Aviso:') }}
              {{ Form::input('number', 'dias_aviso', Input::old('dias_aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          

        <div class="row_1 @if ( $errors->has('fec_planeada')) has-error @endif">
            {{ Form::label('fec_planeada', 'F. Planeada:') }}
              {{ Form::text('fec_planeada', Input::old('fec_planeada'), array('placeholder'=>'Fec_planeada', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_planeada', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_solucion')) has-error @endif">
            {{ Form::label('fec_solucion', 'F. Solucion:') }}
              {{ Form::text('fec_solucion', Input::old('fec_solucion'), array('placeholder'=>'Fec_solucion', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_solucion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('grupo_id')) has-error @endif" style="clear:left">
            {{ Form::label('grupo_id', 'Grupo:') }}
              {{ Form::select('grupo_id', $grupos_ls, Input::old('grupo_id'))  }}
            {{ $errors->first('grupo_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('norma_id')) has-error @endif">
            {{ Form::label('norma_id', 'Norma:') }}
            <div class="row_1"><div id='loading2' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
            {{ Form::select('norma_id', $normas_ls, Input::old('norma_id'))  }}
            {{ $errors->first('norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('norma')) has-error @endif">
            {{ Form::label('norma', 'Detalle Norma:') }}
             {{ Form::text('norma', Input::old('norma'), array('placeholder'=>'Detalle Norma')) }} 
            {{ $errors->first('norma', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('bitacora_seguridad.index', 'Cancelar', $bitacora_seguridad->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
<script type="text/javascript">
    cmbTpoInconformidad();
    cmbNormas();
    $(document).ready(function() { 
        $("#tpo_bitacora_id").change(function(event) {
            cmbTpoInconformidad();
            cmbNormas();
        }); 
        $("#grupo_id").change(function(event) {
            cmbNormas();
        }); 
    });

    function cmbTpoInconformidad(){
        var a= $('#f_bitacora_seguridad').serialize();
            $.ajax({
                url: '{{ route("bitacora_seguridad.cmbTpoInconformidades") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(inconformidades){
                    $('select#tpo_inconformidad_id').html('');
                    $('select#tpo_inconformidad_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(inconformidades, function(i) {
                        $('select#tpo_inconformidad_id').append("<option "+inconformidades[i].selectec+" value=\""+inconformidades[i].id+"\">"+inconformidades[i].tpo_inconformidad+"<\/option>");
                    });
                }
            });
    }

    function cmbNormas(){
        var a= $('#f_bitacora_seguridad').serialize();
            $.ajax({
                url: '{{ route("bitacora_seguridad.cmbNormas") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(normas){
                    $('select#norma_id').html('');
                    $('select#norma_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(normas, function(i) {
                        $('select#norma_id').append("<option "+normas[i].selectec+" value=\""+normas[i].id+"\">"+normas[i].norma+"<\/option>");
                    });
                }
            });
    }

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

</script>
@stop
