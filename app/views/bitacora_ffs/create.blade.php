@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'bitacora_ff.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('ca_fuente_fija_id')) has-error @endif">
            {{ Form::label('ca_fuente_fija_id', 'Fuente Fija:') }}
              {{ Form::select('ca_fuente_fija_id', $fuentes_fijas_ls, Input::old('ca_fuente_fija_id'))  }}
            {{ $errors->first('ca_fuente_fija_id', '<div class="errorMessage">:message</div>') }}
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

        <div class="row_1 @if ( $errors->has('consumo')) has-error @endif">
            {{ Form::label('consumo', 'Consumo:') }}
              {{ Form::text('consumo', Input::old('consumo'), array('placeholder'=>'Consumo')) }}
            {{ $errors->first('consumo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('capacidad_diseno')) has-error @endif">
            {{ Form::label('capacidad_diseno', '% de Capacidad Diseño:') }}
              {{ Form::text('capacidad_diseno', Input::old('capacidad_diseno'), array('placeholder'=>'% de Capacidad Diseño')) }}
            {{ $errors->first('capacidad_diseno', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tp_gases')) has-error @endif">
            {{ Form::label('tp_gases', 'Temperatura Promedio de Gases:') }}
              {{ Form::text('tp_gases', Input::old('tp_gases'), array('placeholder'=>'Temperatura Promedio de Gases')) }}
            {{ $errors->first('tp_gases', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tp_chimenea')) has-error @endif">
            {{ Form::label('tp_chimenea', 'Temperatura Promedio de Chimenea:') }}
              {{ Form::text('tp_chimenea', Input::old('tp_chimenea'), array('placeholder'=>'Temperatura Promedio de Chimenea')) }}
            {{ $errors->first('tp_chimenea', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_ult_manto')) has-error @endif">
            {{ Form::label('fec_ult_manto', 'F. Ult. Manto.:') }}
              {{ Form::text('fec_ult_manto', Input::old('fec_ult_manto'), array('placeholder'=>'Fec_ult_manto', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_ult_manto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('desc_manto')) has-error @endif" style="clear:left">
            {{ Form::label('desc_manto', 'Desc. Ultimo Manto.:') }}
              {{ Form::textArea('desc_manto', Input::old('desc_manto'), array('placeholder'=>'Desc. Ultimo Manto.', 'rows'=>'3')) }}
            {{ $errors->first('desc_manto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('obs')) has-error @endif">
            {{ Form::label('obs', 'Obs.:') }}
              {{ Form::textArea('obs', Input::old('obs'), array('placeholder'=>'Obs.', 'rows'=>'3')) }}
            {{ $errors->first('obs', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('bitacora_ff.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
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

