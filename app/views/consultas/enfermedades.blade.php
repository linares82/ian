@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'consulta.enfermedad', 'class' => 'form', 'method' => 'POST')) }}
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

        <div class="row_2 @if ( $errors->has('cia_f')) has-error @endif">
            {{ Form::label('cia_f', 'Entidad de:') }}
              {{ Form::select('cia_f', $cias_ls, Input::old('cia_f'))  }}
            {{ $errors->first('cia_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('cia_t')) has-error @endif">
            {{ Form::label('cia_t', 'Entidad a:') }}
              {{ Form::select('cia_t', $cias_ls, Input::old('cia_t'))  }}
            {{ $errors->first('cia_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('enfermedad_f')) has-error @endif">
            {{ Form::label('enfermedad_f', 'Enfermedad de:') }}
              {{ Form::select('enfermedad_f', $enfermedades_ls, Input::old('enfermedad_f'))  }}
            {{ $errors->first('enfermedad_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('enfermedad_t')) has-error @endif">
            {{ Form::label('enfermedad_t', 'Enfermedad a:') }}
              {{ Form::select('enfermedad_t', $enfermedades_ls, Input::old('enfermedad_t'))  }}
            {{ $errors->first('enfermedad_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('area_f')) has-error @endif">
            {{ Form::label('area_f', 'Area de:') }}
              {{ Form::select('area_f', $areas_ls, Input::old('area_f'))  }}
            {{ $errors->first('area_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('area_t')) has-error @endif">
            {{ Form::label('area_t', 'Area a:') }}
              {{ Form::select('area_t', $areas_ls, Input::old('area_t'))  }}
            {{ $errors->first('area_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('accion_f')) has-error @endif">
            {{ Form::label('accion_f', 'Acción de:') }}
              {{ Form::select('accion_f', $acciones_ls, Input::old('accion_f'))  }}
            {{ $errors->first('accion_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('accion_t')) has-error @endif">
            {{ Form::label('accion_t', 'Acción a:') }}
              {{ Form::select('accion_t', $acciones_ls, Input::old('accion_t'))  }}
            {{ $errors->first('accion_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('fecha_f')) has-error @endif">
            {{ Form::label('fecha_f', 'Fecha de:') }}
            {{ Form::text('fecha_f', Input::old('fecha_f'), array('placeholder'=>'fecha_f', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('fecha_t')) has-error @endif">
            {{ Form::label('fecha_t', 'Fecha a:') }}
            {{ Form::text('fecha_t', Input::old('fecha_t'), array('placeholder'=>'fecha_t', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha_t', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  
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


