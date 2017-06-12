@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'consulta.planta', 'class' => 'form', 'method' => 'POST')) }}
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
        <div class="row_2 @if ( $errors->has('planta_f')) has-error @endif">
            {{ Form::label('planta_f', 'Planta de:') }}
              {{ Form::select('planta_f', $plantas_ls, Input::old('planta_f'))  }}
            {{ $errors->first('planta_f', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_2 @if ( $errors->has('planta_t')) has-error @endif">
            {{ Form::label('planta_t', 'Planta a:') }}
              {{ Form::select('planta_t', $plantas_ls, Input::old('planta_t'))  }}
            {{ $errors->first('planta_t', '<div class="errorMessage">:message</div>') }}
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


