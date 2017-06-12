@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'bitacora_residuo.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('residuo')) has-error @endif">
            {{ Form::label('residuo', 'Residuo:') }}
              {{ Form::select('residuo', $residuos_ls, Input::old('residuo'))  }}
            {{ $errors->first('residuo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('cantidad')) has-error @endif">
            {{ Form::label('cantidad', 'Cantidad:') }}
              {{ Form::text('cantidad', Input::old('cantidad'), array('placeholder'=>'Cantidad')) }}
            {{ $errors->first('cantidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fecha')) has-error @endif">
            {{ Form::label('fecha', 'Fecha Generación:') }}
              {{ Form::text('fecha', Input::old('fecha'), array('placeholder'=>'Fecha', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fecha', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('lugar_generacion')) has-error @endif", style="clear:left">
            {{ Form::label('lugar_generacion', 'Lugar Generación:') }}
              {{ Form::text('lugar_generacion', Input::old('lugar_generacion'), array('placeholder'=>'Lugar Generación')) }}
            {{ $errors->first('lugar_generacion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('ubicacion')) has-error @endif">
            {{ Form::label('ubicacion', 'Ubicación:') }}
              {{ Form::text('ubicacion', Input::old('ubicacion'), array('placeholder'=>'Ubicación')) }}
            {{ $errors->first('ubicacion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dispocision')) has-error @endif">
            {{ Form::label('dispocision', 'Dispocisión:') }}
              {{ Form::text('dispocision', Input::old('dispocision'), array('placeholder'=>'Dispocisión')) }}
            {{ $errors->first('dispocision', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('transportista')) has-error @endif">
            {{ Form::label('transportista', 'Transportista:') }}
              {{ Form::text('transportista', Input::old('transportista'), array('placeholder'=>'Transportista')) }}
            {{ $errors->first('transportista', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('manifiesto')) has-error @endif">
            {{ Form::label('manifiesto', 'Manifiesto:') }}
              {{ Form::text('manifiesto', Input::old('manifiesto'), array('placeholder'=>'Manifiesto')) }}
            {{ $errors->first('manifiesto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('resp_tecnico')) has-error @endif">
            {{ Form::label('resp_tecnico', 'Resp. Técnico Bitacora:') }}
              {{ Form::text('resp_tecnico', Input::old('resp_tecnico'), array('placeholder'=>'Resp. Técnico Bitacora')) }}
            {{ $errors->first('resp_tecnico', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('requiere_vobo')) has-error @endif">
            {{ Form::label('requiere_vobo', 'Requiere Vo. Bo.:') }}
              {{ Form::select('requiere_vobo', $bnds_ls, Input::old('requiere_vobo'))  }}
            {{ $errors->first('requiere_vobo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('registro_residuos')) has-error @endif">
            {{ Form::label('registro_residuos', 'Registro Residuos:') }}
              {{ Form::select('registro_residuos', $bnds_ls, Input::old('registro_residuos'))  }}
            {{ $errors->first('registro_residuos', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('peligrosidad')) has-error @endif">
            {{ Form::label('peligrosidad', 'Caracteristica Peligrosidad:') }}
              {{ Form::text('peligrosidad', Input::old('peligrosidad'), array('placeholder'=>'Caracteristica Peligrosidad')) }}
            {{ $errors->first('peligrosidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_ingreso')) has-error @endif">
            {{ Form::label('fec_ingreso', 'F. Ingreso Almacén:') }}
              {{ Form::text('fec_ingreso', Input::old('fec_ingreso'), array('placeholder'=>'F. Ingreso Almacén', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_ingreso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_salida')) has-error @endif">
            {{ Form::label('fec_salida', 'F. Salida Almacén:') }}
              {{ Form::text('fec_salida', Input::old('fec_salida'), array('placeholder'=>'F. Salida Almacén', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_salida', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('cedula_operacion')) has-error @endif" style="clear:left">
            {{ Form::label('cedula_operacion', 'Cedula Operación Anual:') }}
              {{ Form::select('cedula_operacion', $bnds_ls, Input::old('cedula_operacion'))  }}
            {{ $errors->first('cedula_operacion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('factor_indicador1')) has-error @endif">
            {{ Form::label('factor_indicador', 'F. Ambiental:') }}
              {{ Form::text('factor_indicador', Input::old('factor_indicador'), array('placeholder'=>'No. Personas')) }}
            {{ $errors->first('factor_indicador', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('bitacora_residuo.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
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



