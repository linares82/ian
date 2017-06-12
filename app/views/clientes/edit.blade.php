@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($cliente, array('class' => 'form', 'method' => 'PUT', 'url' => 'cliente/update/'.$cliente->id)) }}
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

        <div class="row_1 @if ($errors->has('cliente')) has-error @endif">
            {{ Form::label('cliente', 'Cliente:') }}
            {{ Form::text('cliente', Input::old('cliente'), array('placeholder'=>'Cliente')) }}
            {{ $errors->first('cliente', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('cliente.index', 'Cancelar', $cliente->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop