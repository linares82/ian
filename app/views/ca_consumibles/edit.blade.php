@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($ca_consumible, array('class' => 'form', 'method' => 'PUT', 'url' => 'ca_consumible/update/'.$ca_consumible->id)) }}
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

        <div class="row_1 @if ( $errors->has('consumible')) has-error @endif">
            {{ Form::label('consumible', 'Consumible:') }}
              {{ Form::text('consumible', Input::old('consumible'), array('placeholder'=>'Consumible')) }}
            {{ $errors->first('consumible', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('unidad')) has-error @endif">
            {{ Form::label('unidad', 'Unidad:') }}
              {{ Form::text('unidad', Input::old('unidad'), array('placeholder'=>'Unidad')) }}
            {{ $errors->first('unidad', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('ca_consumible.index', 'Cancelar', $ca_consumible->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop