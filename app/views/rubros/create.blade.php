@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'rubro.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ($errors->has('rubro')) has-error @endif">
            {{ Form::label('rubro', 'Rubro:') }}
            {{ Form::text('rubro', Input::old('rubro'), array('placeholder'=>'Rubro')) }}
            {{ $errors->first('rubro', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('rubro.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


