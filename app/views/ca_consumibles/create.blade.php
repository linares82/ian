@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'ca_consumible.store', 'class' => 'form')) }}
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
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('ca_consumible.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


