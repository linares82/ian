@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'consulta.noConformidad', 'class' => 'form', 'method' => 'POST')) }}
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
        <div class="row_2 @if ( $errors->has('tpo_deteccion_f')) has-error @endif">
            {{ Form::label('tpo_deteccion_f', 'Tipo Detección de:') }}
              {{ Form::select('tpo_deteccion_f', $tpo_detecciones_ls, Input::old('tpo_deteccion_f'))  }}
            {{ $errors->first('tpo_detecion_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_deteccion_t')) has-error @endif">
            {{ Form::label('tpo_deteccion_t', 'Tipo Detección a:') }}
              {{ Form::select('tpo_deteccion_t', $tpo_detecciones_ls, Input::old('tpo_deteccion_t'))  }}
            {{ $errors->first('tpo_deteccion_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_bitacora_f')) has-error @endif">
            {{ Form::label('tpo_bitacora_f', 'T. Bitacora de:') }}
              {{ Form::select('tpo_bitacora_f', $tpo_bitacoras_ls, Input::old('tpo_bitacora_f'))  }}
            {{ $errors->first('tpo_bitacora_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_bitacora_t')) has-error @endif">
            {{ Form::label('tpo_bitacora_t', 'T. Bitacora a:') }}
              {{ Form::select('tpo_bitacora_t', $tpo_bitacoras_ls, Input::old('tpo_bitacora_t'))  }}
            {{ $errors->first('tpo_bitacora_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_inconformidad_f')) has-error @endif">
            {{ Form::label('tpo_inconformidad_f', 'T. Inconformidad de:') }}
              {{ Form::select('tpo_inconformidad_f', $tpo_inconformidades_ls, Input::old('tpo_inconformidad_f'))  }}
            {{ $errors->first('tpo_inconformidad_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_inconformidad_t')) has-error @endif">
            {{ Form::label('tpo_inconformidad_t', 'T. inconformidad a:') }}
              {{ Form::select('tpo_inconformidad_t', $tpo_inconformidades_ls, Input::old('tpo_inconformidad_t'))  }}
            {{ $errors->first('tpo_inconformidad_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('responsable_f')) has-error @endif">
            {{ Form::label('responsable_f', 'Responsable de:') }}
              {{ Form::select('responsable_f', $responsables_ls, Input::old('fuente_f'))  }}
            {{ $errors->first('responsable_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('responsable_t')) has-error @endif">
            {{ Form::label('responsable_t', 'Responsable a:') }}
              {{ Form::select('responsable_t', $responsables_ls, Input::old('fuente_t'))  }}
            {{ $errors->first('responsable_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('estatus_f')) has-error @endif">
            {{ Form::label('estatus_f', 'Estaus de:') }}
              {{ Form::select('estatus_f', $estatus_ls, Input::old('estatus_f'))  }}
            {{ $errors->first('estatus_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('estatus_t')) has-error @endif">
            {{ Form::label('estatus_t', 'Estaus de:') }}
              {{ Form::select('estatus_t', $estatus_ls, Input::old('estatus_t'))  }}
            {{ $errors->first('estatus_t', '<div class="errorMessage">:message</div>') }}
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


