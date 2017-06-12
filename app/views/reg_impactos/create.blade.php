@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'reg_impacto.store', 'class' => 'form')) }}
    <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Crear" style="padding:10px;">  

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

        <div class="row_1 @if ($errors->has('factor_id')) has-error @endif">
            {{ Form::label('factor_id', 'Factor:') }}
            {{ Form::select('factor_id', $factor_ls, Input::old('factor_id'))  }}
            {{ $errors->first('factor_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>

        <div class="row_1 @if ($errors->has('factor_id')) has-error @endif">
            {{ Form::label('rubro_id', 'Rubro:') }}
            {{ Form::select('rubro_id', $rubro_ls, Input::old('rubro_id'))  }}
            {{ $errors->first('rubro_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1"><div id='loading2' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>

        <div class="row_1 @if ($errors->has('especifico_id')) has-error @endif">
            {{ Form::label('especifico_id', 'Especifico:') }}
            {{ Form::select('especifico_id', $especifico_ls, Input::old('especifico_id'))  }}
            {{ $errors->first('especifico_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('caracteristica_id')) has-error @endif">
            {{ Form::label('caracteristica_id', 'Caracteristica:') }}
            {{ Form::select('caracteristica_id', $caracteristica_ls, Input::old('caracteristica_id'))  }}
            {{ $errors->first('caracteristica_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" style="width:96%;margin-top:5px;margin-bottom:10px;">
        </div>

        <div class="row_1 @if ($errors->has('efecto')) has-error @endif">
            {{ Form::label('efecto_id', 'Efecto:') }}
            {{ Form::select('efecto_id', $efecto_ls, Input::old('efecto_id'))  }}
            {{ $errors->first('efecto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1"><div id='loading3' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>

        <div class="row_2cols @if ($errors->has('desc_efecto')) has-error @endif">
            {{ Form::label('desc_efecto', 'Desc. Efecto:') }}
              {{ Form::textArea('desc_efecto', Input::old('desc_efecto'), array('placeholder'=>'Desc. Efecto', 'rows'=>'1')) }}
            {{ $errors->first('desc_efecto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" style="width:96%;margin-top:5px;margin-bottom:10px;">
        </div>

        <div class="row_2 @if ($errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripción:') }}
            {{ Form::textArea('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion', 'rows'=>'2')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('resarcion')) has-error @endif">
            {{ Form::label('resarcion', 'Medida de Resarción:') }}
              {{ Form::textArea('resarcion', Input::old('resarcion'), array('placeholder'=>'Resarcion', 'rows'=>'2')) }}
            {{ $errors->first('resarcion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ($errors->has('emision_efecto_id')) has-error @endif">
            {{ Form::label('emision_efecto_id', 'Emision del Efecto:') }}
            {{ Form::select('emision_efecto_id', $emision_efecto_ls, Input::old('emision_efecto_id'))  }}
            {{ $errors->first('emision_efecto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('duracion_accion_id')) has-error @endif">
            {{ Form::label('duracion_accion_id', 'Duracion de la Acción:') }}
            {{ Form::select('duracion_accion_id', $duracion_accion_ls, Input::old('duracion_accion_id'))  }}
            {{ $errors->first('duracion_accion_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('continuidad_efecto_id')) has-error @endif">
            {{ Form::label('continuidad_efecto_id', 'Continuidad del Efecto:') }}
            {{ Form::select('continuidad_efecto_id', $continuidad_efecto_ls, Input::old('continuidad_efecto_id'))  }}
            {{ $errors->first('continuidad_efecto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('reversibilidad_id')) has-error @endif">
            {{ Form::label('reversibilidad_id', 'Reversibilidad:') }}
            {{ Form::select('reversibilidad_id', $reversibilidad_ls, Input::old('reversibilidad_id'))  }}
            {{ $errors->first('reversibilidad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('probabilidad_id')) has-error @endif">
            {{ Form::label('probabilidad_id', 'Probabilidad:') }}
            {{ Form::select('probabilidad_id', $probabilidad_ls, Input::old('probabilidad_id'))  }}
            {{ $errors->first('probabilidad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('mitigacion_id')) has-error @endif">
            {{ Form::label('mitigacion_id', 'Suceptibilidad de mitigacion:') }}
            {{ Form::select('mitigacion_id', $mitigacion_ls, Input::old('mitigacion_id'))  }}
            {{ $errors->first('mitigacion_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('intensidad_impacto_id')) has-error @endif">
            {{ Form::label('intensidad_impacto_id', 'Intensidad de impacto:') }}
            {{ Form::select('intensidad_impacto_id', $intensidad_impacto_ls, Input::old('intensidad_impacto_id'))  }}
            {{ $errors->first('intensidad_impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('reg_impacto.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')

<script "type/javascript">
    jQuery(document).ready(function() {
        $("#factor_id").change(function(event) {
            var id = $("#factor_id option:selected").val(); 
            $.ajax({
                url: 'cmbRubro/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(rubro){
                    $('select#rubro_id').html('');
                    $('select#rubro_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(rubro, function(i) {
                        $('select#rubro_id').append("<option value=\""+rubro[i].id+"\">"+rubro[i].rubro+"<\/option>");
                    });
                }
            });
        });
        
        $("#rubro_id").change(function(event) {
            var id = $("#rubro_id option:selected").val(); 
            $.ajax({
                url: 'cmbEspecifico/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(especifico){
                    $('select#especifico_id').html('');
                    $('select#especifico_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(especifico, function(i) {
                        $('select#especifico_id').append("<option value=\""+especifico[i].id+"\">"+especifico[i].especifico+"<\/option>");
                    });
                }
            });
        });

        $("#efecto_id").change(function(event) {
            var id = $("#efecto_id option:selected").val(); 
            $.ajax({
                url: 'descEfecto/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading3").show();},
                complete : function(){$("#loading3").hide();},
                success: function(especifico){
                    $('textarea#desc_efecto').html('');
                    $('textarea#desc_efecto').html(especifico.descripcion);
                }
            });
        });
    });
</script>

@stop


