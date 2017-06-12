@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($probabilidad, array('class' => 'form', 'method' => 'PUT', 'url' => 'probabilidad/update/'.$probabilidad->id)) }}
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
            {{ Form::label('probabilidad', 'Probabilidad:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('probabilidad', Input::old('probabilidad'), array('class'=>'form-control', 'placeholder'=>'Probabilidad')) }}
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
  {{ link_to_route('probabilidad.index', 'Cancelar', $probabilidad->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop