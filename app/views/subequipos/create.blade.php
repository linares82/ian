@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'subequipo.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('equipo')) has-error @endif">
            {{ Form::label('equipo', 'Equipo:') }}
              {{ Form::select('equipo_id', $equipos_ls, Input::old('equipo_id'))  }}
            {{ $errors->first('equipo_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('subequipo')) has-error @endif">
            {{ Form::label('subequipo', 'Subequipo:') }}
              {{ Form::text('subequipo', Input::old('subequipo'), array('placeholder'=>'Subequipo')) }}
            {{ $errors->first('subequipo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('clase')) has-error @endif">
            {{ Form::label('clase', 'Clase:') }}
              {{ Form::text('clase', Input::old('clase'), array('placeholder'=>'Clase')) }}
            {{ $errors->first('clase', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('marca')) has-error @endif">
            {{ Form::label('marca', 'Marca:') }}
              {{ Form::text('marca', Input::old('marca'), array('placeholder'=>'Marca')) }}
            {{ $errors->first('marca', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('modelo')) has-error @endif">
            {{ Form::label('modelo', 'Modelo:') }}
              {{ Form::text('modelo', Input::old('modelo'), array('placeholder'=>'Modelo')) }}
            {{ $errors->first('modelo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('no_serie')) has-error @endif">
            {{ Form::label('no_serie', 'No Serie:') }}
              {{ Form::text('no_serie', Input::old('no_serie'), array('placeholder'=>'No Serie')) }}
            {{ $errors->first('no_serie', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fecha_carga')) has-error @endif">
            {{ Form::label('fecha_carga', 'Fecha Carga:') }}
              {{ Form::text('fecha_carga', Input::old('Fecha Carga'), array('placeholder'=>'Fec_planeada', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha_carga', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('area_id')) has-error @endif">
            {{ Form::label('area_id', 'Area:') }}
              {{ Form::select('area_id', $areas_ls, Input::old('area_id'))  }}
            {{ $errors->first('area_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('ubicacion')) has-error @endif">
            {{ Form::label('ubicacion', 'Ubicacion:') }}
              {{ Form::text('ubicacion', Input::old('ubicacion'), array('placeholder'=>'Ubicacion')) }}
            {{ $errors->first('ubicacion', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('subequipo.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
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


