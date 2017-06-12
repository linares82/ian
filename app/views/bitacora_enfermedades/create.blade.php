@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'bitacora_enfermedade.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('area_id')) has-error @endif">
            {{ Form::label('area_id', 'Area:') }}
              {{ Form::select('area_id', $areas_ls, Input::old('area_id'))  }}
            {{ $errors->first('area_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('persona_id')) has-error @endif">
            {{ Form::label('persona_id', 'Persona:') }}
              {{ Form::select('persona_id', $personas_ls, Input::old('persona_id'))  }}
            {{ $errors->first('persona_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('enfermedad_id')) has-error @endif">
            {{ Form::label('enfermedad_id', 'Enfermedad:') }}
              {{ Form::select('enfermedad_id', $enfermedades_ls, Input::old('enfermedad_id'))  }}
            {{ $errors->first('enfermedad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripcion:') }}
              {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('accion_id')) has-error @endif">
            {{ Form::label('accion_id', 'Accion:') }}
              {{ Form::select('accion_id', $acciones_ls, Input::old('accion_id'))  }}
            {{ $errors->first('accion_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('costo_directo')) has-error @endif">
            {{ Form::label('costo_directo', 'Costo Directo:') }}
              {{ Form::text('costo_directo', Input::old('costo_directo'), array('placeholder'=>'Costo Directo')) }}
            {{ $errors->first('costo_directo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('costo_indirecto')) has-error @endif">
            {{ Form::label('costo_indirecto', 'Costo Indirecto:') }}
              {{ Form::text('costo_indirecto', Input::old('costo_indirecto'), array('placeholder'=>'Costo Indirecto')) }}
            {{ $errors->first('costo_indirecto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fecha')) has-error @endif">
            {{ Form::label('fecha', 'Fecha:') }}
              {{ Form::text('fecha', Input::old('fecha'), array('placeholder'=>'Fecha', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('turno_id')) has-error @endif">
            {{ Form::label('turno_id', 'Turno:') }}
              {{ Form::select('turno_id', $turnos_ls, Input::old('turno_id'))  }}
            {{ $errors->first('turno_id', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('bitacora_enfermedade.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
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

</script>
@stop


