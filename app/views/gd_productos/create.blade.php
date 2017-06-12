@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'gd_producto.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ($errors->has('producto')) has-error @endif">
            {{ Form::label('producto', 'Producto:') }}
			{{ Form::text('producto', Input::old('producto'), array('placeholder'=>'Producto')) }}
			@if ($errors->has('producto')) <div class="errorMessage">{{ $errors->first('producto') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('abreviacion')) has-error @endif">
            {{ Form::label('abreviacion', 'Abreviacion:') }}
              {{ Form::text('abreviacion', Input::old('abreviacion'), array('placeholder'=>'Abreviacion')) }}
			  @if ($errors->has('abreviacion')) <div class="errorMessage">{{ $errors->first('abreviacion') }}</div> @endif
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('gd_producto.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
			</div>
    </div>

{{ Form::close() }}

@stop


