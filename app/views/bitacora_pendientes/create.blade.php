@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'bitacora_pendiente.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('pendiente')) has-error @endif">
            {{ Form::label('pendiente', 'Pendiente:') }}
              {{ Form::textArea('pendiente', Input::old('pendiente'), array('placeholder'=>'Pendiente', 'rows'=>'4')) }}
            {{ $errors->first('pendiente', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('comentarios')) has-error @endif">
            {{ Form::label('comentarios', 'Comentarios:') }}
              {{ Form::textArea('comentarios', Input::old('comentarios'), array('placeholder'=>'Comentarios', 'rows'=>'4')) }}
            {{ $errors->first('comentarios', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('solucion')) has-error @endif">
            {{ Form::label('solucion', 'Solución:') }}
              {{ Form::textArea('solucion', Input::old('solucion'), array('placeholder'=>'Solución', 'rows'=>'4')) }}
            {{ $errors->first('solucion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_planeada')) has-error @endif">
            {{ Form::label('fec_planeada', 'F. Planeada:') }}
              {{ Form::text('fec_planeada', Input::old('fec_planeada'), array('placeholder'=>'Fec_planeada', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_planeada', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_fin')) has-error @endif">
            {{ Form::label('fec_fin', 'F. Fin:') }}
              {{ Form::text('fec_fin', Input::old('fec_fin'), array('placeholder'=>'Fec_fin', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_fin', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('aviso')) has-error @endif">
            {{ Form::label('aviso', 'Aviso:') }}
              {{ Form::select('aviso', $bnds_ls, Input::old('aviso'))  }}
            {{ $errors->first('aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias Aviso:') }}
              {{ Form::input('number', 'dias_aviso', Input::old('dias_aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('observaciones')) has-error @endif">
            {{ Form::label('observaciones', 'Observaciones:') }}
              {{ Form::textArea('observaciones', Input::old('observaciones'), array('placeholder'=>'Observaciones', 'rows'=>'2')) }}
            {{ $errors->first('observaciones', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('bitacora_pendiente.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
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


