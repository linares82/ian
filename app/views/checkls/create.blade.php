@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'checkl.store', 'class' => 'form')) }}
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

        <div class="row_2 @if ($errors->has('a_chequeo')) has-error @endif">
            {{ Form::label('a_chequeo', 'Area de chequeo:') }}
              {{ Form::select('a_chequeo', $areas_ls, Input::old('a_chequeo'))  }}
            {{ $errors->first('a_chequeo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('norma_id')) has-error @endif">
            {{ Form::label('norma_id', 'Norma:') }}
              {{ Form::select('norma_id', $normas_ls, Input::old('norma_id'))  }}
            {{ $errors->first('norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ($errors->has('no_conformidad')) has-error @endif">
            {{ Form::label('no_conformidad', 'No Conformidad:') }}
            {{ Form::textArea('no_conformidad', Input::old('no_conformidad'), array('placeholder'=>'No Conformidad', 'rows'=>'3')) }}
            {{ $errors->first('no_conformidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('especifico')) has-error @endif">
            {{ Form::label('especifico', 'Especifico:') }}
              {{ Form::textArea('especifico', Input::old('especifico'), array('placeholder'=>'Especifico', 'rows'=>'7')) }}
            {{ $errors->first('especifico', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('requisito')) has-error @endif">
            {{ Form::label('requisito', 'Requisito:') }}
              {{ Form::textArea('requisito', Input::old('requisito'), array('placeholder'=>'Requisito', 'rows'=>'7')) }}
            {{ $errors->first('requisito', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('rnc')) has-error @endif">
            {{ Form::label('rnc', 'Rnc:') }}            
              {{ Form::textArea('rnc', Input::old('rnc'), array('placeholder'=>'Rnc', 'rows'=>'3')) }}
            {{ $errors->first('rnc', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('minimo_vsm')) has-error @endif">
            {{ Form::label('minimo_vsm', 'Minimo VSM:') }}            
              {{ Form::text('minimo_vsm', Input::old('minimo_vsm'), array('placeholder'=>'Minimo VSM')) }}
            {{ $errors->first('minimo_vsm', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('maximo_vsm')) has-error @endif">
            {{ Form::label('maximo_vsm', 'Maximo VSM:') }}            
              {{ Form::text('maximo_vsm', Input::old('maximo_vsm'), array('placeholder'=>'Maximo VSM')) }}
            {{ $errors->first('maximo_vsm', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('cumplimiento')) has-error @endif", style="clear:left;">
            {{ Form::label('cumplimiento', 'Cumplimiento:') }}            
              {{ Form::select('cumplimiento', $cumplimiento_ls, Input::old('cumplimiento'))  }}
            {{ $errors->first('cumplimiento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" title="DATOS DE LA VERIFICACION" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ($errors->has('monto_min')) has-error @endif">
            {{ Form::label('monto_min', 'Monto Minimo:') }}            
              {{ Form::text('monto_min', Input::old('monto_min'), array('placeholder'=>'Monto Minimo')) }}
            {{ $errors->first('monto_min', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('monto_medio')) has-error @endif">
            {{ Form::label('monto_medio', 'Monto Medio:') }}            
              {{ Form::text('monto_medio', Input::old('monto_medio'), array('placeholder'=>'Monto Medio')) }}
            {{ $errors->first('monto_medio', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('monto_max')) has-error @endif">
            {{ Form::label('monto_max', 'Monto Maximo:') }}            
              {{ Form::text('monto_max', Input::old('monto_max'), array('placeholder'=>'Monto Maximo')) }}
            {{ $errors->first('monto_max', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('correccion')) has-error @endif">
            {{ Form::label('correccion', 'Correccion:') }}            
              {{ Form::textArea('correccion', Input::old('correccion'), array('placeholder'=>'Correccion', 'rows'=>'3')) }}
            {{ $errors->first('correccion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('correccion_detallada')) has-error @endif">
            {{ Form::label('correccion_detallada', 'Correccion:') }}            
              {{ Form::textArea('correccion_detallada', Input::old('correccion_detallada'), array('placeholder'=>'Correccion detallada', 'rows'=>'3')) }}
            {{ $errors->first('correccion_detallada', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('t_semanas')) has-error @endif">
            {{ Form::label('t_semanas', 'T. Semanas:') }}            
              {{ Form::input('number', 't_semanas', Input::old('t_semanas'), array('class'=>'form-control')) }}
            {{ $errors->first('t_semanas', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('responsable')) has-error @endif">
            {{ Form::label('responsable', 'Responsable:') }}            
              {{ Form::text('responsable', Input::old('responsable'), array('placeholder'=>'Responsable')) }}
            {{ $errors->first('responsable', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('monto_estimado')) has-error @endif">
            {{ Form::label('monto_estimado', 'Monto Estimado:') }}            
              {{ Form::text('monto_estimado', Input::old('monto_estimado'), array('placeholder'=>'Monto Estimado')) }}
            {{ $errors->first('monto_estimado', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('checkl.index', 'Cancelar', array('id'=>$check), array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


@section('js_local')
<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#monto_min").prop('readonly', true);
        $("#monto_medio").prop('readonly', true);
        $("#monto_max").prop('readonly', true);
        $("#correccion").prop('readonly', true);
        $("#correccion_detallada").prop('readonly', true);
        $("#t_semanas").prop('readonly', true);
        $("#responsable").prop('readonly', true);
        $("#monto_estimado").prop('readonly', true);
        $("#cumplimiento").change(function(event) {
            var id = $("#cumplimiento option:selected").val();
            if(id==1 || id==2 || id==4){
                $("#monto_min").prop('readonly', true);
                $("#monto_medio").prop('readonly', true);
                $("#monto_max").prop('readonly', true);
                $("#correccion").prop('readonly', true);
                $("#correccion_detallada").prop('readonly', true);
                $("#t_semanas").prop('readonly', true);
                $("#responsable").prop('readonly', true);
                $("#monto_estimado").prop('readonly', true);
            }
            else if(id==3){
                $("#monto_min").prop('readonly', false);
                $("#monto_medio").prop('readonly', false);
                $("#monto_max").prop('readonly', false);
                $("#correccion").prop('readonly', false);
                $("#correccion_detallada").prop('readonly', false);
                $("#t_semanas").prop('readonly', false);
                $("#responsable").prop('readonly', false);
                $("#monto_estimado").prop('readonly', false);   
            }
        });
    }); 
</script>
@stop