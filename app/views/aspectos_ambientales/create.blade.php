@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'aspectos_ambientale.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('proceso_id')) has-error @endif">
            {{ Form::label('proceso_id', 'Proceso:') }}
              {{ Form::select('proceso_id', $procesos_ls, Input::old('proceso_id'))  }}
            {{ $errors->first('proceso_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('area_id')) has-error @endif">
            {{ Form::label('area_id', 'Area:') }}
              {{ Form::select('area_id', $areas_ls, Input::old('area_id'))  }}
            {{ $errors->first('area_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('actividad')) has-error @endif">
            {{ Form::label('actividad', 'Actividad:') }}
              {{ Form::text('actividad', Input::old('actividad'), array('placeholder'=>'Actividad')) }}
            {{ $errors->first('actividad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripcion:') }}
              {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('aspecto_id')) has-error @endif">
            {{ Form::label('aspecto_id', 'Aspecto:') }}
              {{ Form::select('aspecto_id', $aspectos_ls, Input::old('aspecto_id'))  }}
            {{ $errors->first('aspecto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('eme_id')) has-error @endif">
            {{ Form::label('eme_id', '5 Emes:') }}
              {{ Form::select('eme_id', $emes_ls, Input::old('eme_id'))  }}
            {{ $errors->first('eme_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('condicion_id')) has-error @endif">
            {{ Form::label('condicion_id', 'Condicion:') }}
              {{ Form::select('condicion_id', $condiciones_ls, Input::old('condicion_id'))  }}
            {{ $errors->first('condicion_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('impacto_id')) has-error @endif">
            {{ Form::label('impacto_id', 'Impacto:') }}
              {{ Form::select('impacto_id', $impactos_ls, Input::old('impacto_id'))  }}
            {{ $errors->first('impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" title="CONSIDERACIONES" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ( $errors->has('al_federal_bnd')) has-error @endif">
            {{ Form::label('al_federal_bnd', 'Aspecto Legislado Nivel Federal:') }}
              {{ Form::select('al_federal_bnd', $bnds_ls, Input::old('al_federeal_bnd'))  }}
            {{ $errors->first('al_federal_bnd', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('al_estatal_bnd')) has-error @endif">
            {{ Form::label('al_estatal_bnd', 'Aspecto Legislado Nivel Estatal:') }}
              {{ Form::select('al_estatal_bnd', $bnds_ls, Input::old('al_estatal_bnd'))  }}
            {{ $errors->first('al_estatal_bnd', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('obj_corporativo_bnd')) has-error @endif">
            {{ Form::label('obj_corporativo_bnd', 'Obj. Corporativo:') }}
              {{ Form::select('obj_corporativo_bnd', $bnds_ls, Input::old('obj_corporativo_bnd'))  }}
            {{ $errors->first('obj_corporativo_bnd', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('quejas_bnd')) has-error @endif">
            {{ Form::label('quejas_bnd', 'Quejas:') }}
              {{ Form::select('quejas_bnd', $bnds_ls, Input::old('quejas_bnd'))  }}
            {{ $errors->first('quejas_bnd', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" title="CALIFICACION DEL IMPACTO" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ( $errors->has('severidad_id')) has-error @endif">
            {{ Form::label('severidad_id', 'Severidad:') }}
              {{ Form::select('severidad_id', $severidades_ls, Input::old('severidad_id'))  }}
            {{ $errors->first('severidad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bnd_potencial')) has-error @endif">
            {{ Form::label('bnd_potencial', 'I. Potencial:') }}
              {{ Form::select('bnd_potencial', $bnds_ls, Input::old('bnd_potencial'))  }}
            {{ $errors->first('bnd_potencial', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('frecuencia_id')) has-error @endif">
            {{ Form::label('frecuencia_id', 'Frecuencia:') }}
              {{ Form::select('frecuencia_id', $frecuencias_ls, Input::old('frecuencia_id'))  }}
            {{ $errors->first('frecuencia_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bnd_real')) has-error @endif">
            {{ Form::label('bnd_real', 'I. Real:') }}
              {{ Form::select('bnd_real', $bnds_ls, Input::old('bnd_real'))  }}
            {{ $errors->first('bnd_real', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('probabilidad_id')) has-error @endif">
            {{ Form::label('probabilidad_id', 'Probabilidad:') }}
              {{ Form::select('probabilidad_id', $probabilidades_ls, Input::old('probabilidad_id'))  }}
            {{ $errors->first('probabilidad_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('observaciones')) has-error @endif">
            {{ Form::label('observaciones', 'Observaciones:') }}
              {{ Form::text('observaciones', Input::old('observaciones'), array('placeholder'=>'Observaciones')) }}
            {{ $errors->first('observaciones', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('ctrls_opracionales')) has-error @endif">
            {{ Form::label('ctrls_opracionales', 'Controles Operacionales:') }}
              {{ Form::text('ctrls_opracionales', Input::old('ctrls_opracionales'), array('placeholder'=>'Controles Operacionales')) }}
            {{ $errors->first('ctrls_opracionales', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('aspectos_ambientale.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
<script type="text/javascript">

    $(document).ready(function() { 
        $("#bnd_potencial").change(function(event) {
                var potencial = $("#bnd_potencial").val();
                if(potencial==1){
                    $("#bnd_real").val('2')
                    $("#probabilidad_id").val('5')
                    $("#frecuencia_id").val('0')
                }else if(potencial==2){
                    $("#bnd_real").val('1')
                    $("#probabilidad_id").val('0')
                    $("#frecuencia_id").val('5')
                }
            });

        $("#bnd_real").change(function(event) {
                var real = $("#bnd_real").val();
                if(real==1){
                    $("#bnd_potencial").val('2')
                    $("#frecuencia_id").val('5')
                    $("#probabilidad_id").val('0')
                }else if(real==2){
                    $("#bnd_potencial").val('1')
                    $("#frecuencia_id").val('0')
                    $("#probabilidad_id").val('5')
                }
            });
        });

    
</script>
@stop







