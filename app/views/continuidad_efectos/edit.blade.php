@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($continuidad_efecto, array('class' => 'form', 'method' => 'PUT', 'url' => 'continuidad_efecto/update/'.$continuidad_efecto->id)) }}
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

        <div class="form-group">
            {{ Form::label('continuidad_efecto', 'Continuidad_efecto:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('continuidad_efecto', Input::old('continuidad_efecto'), array('class'=>'form-control', 'placeholder'=>'Continuidad_efecto')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('usu_alta_id', 'Usu_alta_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'usu_alta_id', Input::old('usu_alta_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('usu_mod_is', 'Usu_mod_is:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'usu_mod_is', Input::old('usu_mod_is'), array('class'=>'form-control')) }}
            </div>
        </div>


<div class="row_buttons">
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('continuidad_efecto.index', 'Cancelar', $continuidad_efecto->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop