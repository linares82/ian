@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($acheck, array('class' => 'form', 'method' => 'PUT', 'url' => 'acheck/update/'.$acheck->id)) }}
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
            {{ Form::label('area', 'Area:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('area', Input::old('area'), array('class'=>'form-control', 'placeholder'=>'Area')) }}
            </div>
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('acheck.index', 'Cancelar', $acheck->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop