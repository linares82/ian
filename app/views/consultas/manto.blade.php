@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'consulta.manto', 'class' => 'form', 'method' => 'POST')) }}
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
        <div class="row_2 @if ( $errors->has('objetivo_f')) has-error @endif">
            {{ Form::label('objetivo_f', 'Objetivo de:') }}
              {{ Form::select('objetivo_f', $objetivos_ls, Input::old('objetivo_f'))  }}
            {{ $errors->first('objetivo_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('objetivo_t')) has-error @endif">
            {{ Form::label('objetivo_t', 'Objetivo a:') }}
              {{ Form::select('objetivo_t', $objetivos_ls, Input::old('objetivo_t'))  }}
            {{ $errors->first('objetivo_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('estatus_f')) has-error @endif">
            {{ Form::label('estatus_f', 'Estatus de:') }}
              {{ Form::select('estatus_f', $estatus_ls, Input::old('estatus_f'))  }}
            {{ $errors->first('estatus_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('estatus_t')) has-error @endif">
            {{ Form::label('estatus_t', 'Estatus a:') }}
              {{ Form::select('estatus_t', $estatus_ls, Input::old('estatus_t'))  }}
            {{ $errors->first('estatus_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_manto_f')) has-error @endif">
            {{ Form::label('tpo_manto_f', 'Tipo Manto. de:') }}
              {{ Form::select('tpo_manto_f', $tpo_mantos_ls, Input::old('tpo_manto_f'))  }}
            {{ $errors->first('tpo_manto_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('tpo_manto_t')) has-error @endif">
            {{ Form::label('tpo_manto_t', 'Tipo Manto a:') }}
              {{ Form::select('tpo_manto_t', $tpo_mantos_ls, Input::old('tpo_manto_t'))  }}
            {{ $errors->first('tpo_manto_t', '<div class="errorMessage">:message</div>') }}
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


