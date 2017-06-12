@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'efecto.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ($errors->has('efecto')) has-error @endif">
            {{ Form::label('efecto', 'Ponderacion del Impacto:') }}
            {{ Form::text('efecto', Input::old('efecto'), array('placeholder'=>'Efecto')) }}
            {{ $errors->first('efecto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripcion:') }}
            {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('efecto.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


