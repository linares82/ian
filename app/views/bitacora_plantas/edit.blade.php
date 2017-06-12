@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($bitacora_planta, array('class' => 'form', 'method' => 'PUT', 'url' => 'bitacora_planta/update/'.$bitacora_planta->id)) }}
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

        <div class="row_1 @if ( $errors->has('planta_id')) has-error @endif">
            {{ Form::label('planta_id', 'Planta:') }}
              {{ Form::select('planta_id', $plantas_ls, Input::old('planta_id'))  }}
            {{ $errors->first('planta_id', '<div class="errorMessage">:message</div>') }}
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

        <div class="row_1 @if ( $errors->has('agua_entrada')) has-error @endif">
            {{ Form::label('agua_entrada', 'Agua Entrada:') }}
              {{ Form::text('agua_entrada', Input::old('agua_entrada'), array('placeholder'=>'Agua Entrada')) }}
            {{ $errors->first('agua_entrada', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('agua_salida')) has-error @endif">
            {{ Form::label('agua_salida', 'Agua Salida:') }}
              {{ Form::text('agua_salida', Input::old('agua_salida'), array('placeholder'=>'Agua Salida')) }}
            {{ $errors->first('agua_salida', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('q_usados')) has-error @endif">
            {{ Form::label('q_usados', 'Quimicos Usados:') }}
              {{ Form::text('q_usados', Input::old('q_usados'), array('placeholder'=>'Quimicos Usados')) }}
            {{ $errors->first('q_usados', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('q_existentes')) has-error @endif">
            {{ Form::label('q_existentes', 'Quimicos Existentes:') }}
              {{ Form::text('q_existentes', Input::old('q_existentes'), array('placeholder'=>'Quimicos Existentes')) }}
            {{ $errors->first('q_existentes', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('tiempo_operacion')) has-error @endif">
            {{ Form::label('tiempo_operacion', 'Tiempo de Operacion:') }}
              {{ Form::text('tiempo_operacion', Input::old('tiempo_operacion'), array('placeholder'=>'Tiempo de Operacion')) }}
            {{ $errors->first('tiempo_operacion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('motivo_paro')) has-error @endif">
            {{ Form::label('motivo_paro', 'Motivo de Paro:') }}
              {{ Form::text('motivo_paro', Input::old('motivo_paro'), array('placeholder'=>'Motivo de Paro')) }}
            {{ $errors->first('motivo_paro', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('vol_lodos')) has-error @endif">
            {{ Form::label('vol_lodos', 'Vol. Lodos en el Mes:') }}
              {{ Form::text('vol_lodos', Input::old('vol_lodos'), array('placeholder'=>'Vol. Lodos en el Mes')) }}
            {{ $errors->first('vol_lodos', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('disp_lodos')) has-error @endif">
            {{ Form::label('disp_lodos', 'Disp. de Lodos:') }}
            {{ Form::text('disp_lodos', Input::old('disp_lodos'), array('placeholder'=>'Disp. de Lodos')) }}
            {{ $errors->first('disp_lodos', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_ult_manto')) has-error @endif">
            {{ Form::label('fec_ult_manto', 'F. Ultimo Manto.:') }}
            {{ Form::text('fec_ult_manto', Input::old('fec_ult_manto'), array('placeholder'=>'F. ultimo Manto.', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_ult_manto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('desc_manto')) has-error @endif" style="clear:left">
            {{ Form::label('desc_manto', 'Desc. Ultimo Manto.:') }}
            {{ Form::textArea('desc_manto', Input::old('desc_manto'), array('placeholder'=>'Desc. Ultimo Manto.', 'rows'=>'3')) }}
            {{ $errors->first('desc_manto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('obs')) has-error @endif">
            {{ Form::label('obs', 'Obs.:') }}
              {{ Form::textArea('obs', Input::old('obs'), array('placeholder'=>'Obs.', 'rows'=>3)) }}
            {{ $errors->first('obs', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('bitacora_planta.index', 'Cancelar', $bitacora_planta->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
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

