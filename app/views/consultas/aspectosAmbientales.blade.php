@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'consulta.aspectosAmbientale', 'class' => 'form', 'method' => 'POST')) }}
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
        <div class="row_2 @if ( $errors->has('proceso_f')) has-error @endif">
            {{ Form::label('proceso_f', 'Proceso de:') }}
              {{ Form::select('proceso_f', $procesos_ls, Input::old('proceso_f'))  }}
            {{ $errors->first('proceso_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('proceso_t')) has-error @endif">
            {{ Form::label('proceso_t', 'Proceso a:') }}
              {{ Form::select('proceso_t', $procesos_ls, Input::old('proceso_t'))  }}
            {{ $errors->first('proceso_t', '<div class="errorMessage">:message</div>') }}
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
        <div class="row_2 @if ( $errors->has('imp_real_f')) has-error @endif">
            {{ Form::label('imp_real_f', 'I. Real de:') }}
              {{ Form::select('imp_real_f', $imp_reals_ls, Input::old('imp_real_f'))  }}
            {{ $errors->first('imp_real_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('imp_real_t')) has-error @endif">
            {{ Form::label('imp_real_t', 'I. Real a:') }}
              {{ Form::select('imp_real_t', $imp_reals_ls, Input::old('imp_real_t'))  }}
            {{ $errors->first('imp_real_t', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('imp_potencial_f')) has-error @endif">
            {{ Form::label('imp_potencial_f', 'I. Potencial de:') }}
              {{ Form::select('imp_potencial_f', $imp_potencials_ls, Input::old('imp_potencial_f'))  }}
            {{ $errors->first('imp_potencial_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('imp_potencial_t')) has-error @endif">
            {{ Form::label('imp_potencial_t', 'I. Potencial a:') }}
              {{ Form::select('imp_potencial_t', $imp_potencials_ls, Input::old('imp_potencial_t'))  }}
            {{ $errors->first('imp_potencial_t', '<div class="errorMessage">:message</div>') }}
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


