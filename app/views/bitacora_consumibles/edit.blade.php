@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($bitacora_consumible, array('class' => 'form', 'method' => 'PUT', 'url' => 'bitacora_consumible/update/'.$bitacora_consumible->id)) }}
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

        <div class="row_1 @if ( $errors->has('consumible_id')) has-error @endif">
            {{ Form::label('consumible_id', 'Consumible:') }}
              {{ Form::select('consumible_id', $consumibles_ls, Input::old('consumible_id'))  }}
            {{ $errors->first('consumible_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('consumo')) has-error @endif">
            {{ Form::label('consumo', 'Consumo:') }}
              {{ Form::text('consumo', Input::old('consumo'), array('placeholder'=>'Consumo')) }}
            {{ $errors->first('consumo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fecha')) has-error @endif">
            {{ Form::label('fecha', 'Fecha Lectura:') }}
              {{ Form::text('fecha', Input::old('fecha'), array('placeholder'=>'Fecha', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('costo')) has-error @endif" style="clear:left">
            {{ Form::label('costo', 'Costo:') }}
              {{ Form::text('costo', Input::old('costo'), array('placeholder'=>'Costo')) }}
            {{ $errors->first('costo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_inicio')) has-error @endif">
            {{ Form::label('fec_inicio', 'Periodo De:') }}
              {{ Form::text('fec_inicio', Input::old('fec_inicio'), array('placeholder'=>' De:', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_inicio', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_fin')) has-error @endif">
            {{ Form::label('fec_fin', 'Periodo A:') }}
              {{ Form::text('fec_fin', Input::old('fec_fin'), array('placeholder'=>'A:', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_fin', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('factor_indicador')) has-error @endif" style='clear:left'>
            {{ Form::label('factor_indicador', 'F. Ambiental:') }}
              {{ Form::text('factor_indicador', Input::old('factor_indicador'), array('placeholder'=>'No. Personas')) }}
            {{ $errors->first('factor_indicador', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('bitacora_consumible.index', 'Cancelar', $bitacora_consumible->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
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


