@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($norma, array('class' => 'form', 'method' => 'PUT', 'url' => 'norma/update/'.$norma->id)) }}
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

        <div class="row_1 @if ($errors->has('norma')) has-error @endif">
            {{ Form::label('norma', 'Norma:') }}
            {{ Form::text('norma', Input::old('norma'), array('placeholder'=>'Norma')) }}
            {{ $errors->first('norma', '<div class="errorMessage">:message</div>') }}
        </div>

<div class="row_buttons">
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('norma.index', 'Cancelar', $norma->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop