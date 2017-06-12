@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'condicione.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('impacto_id')) has-error @endif">
            {{ Form::label('impacto_id', 'Impacto:') }}
              {{ Form::select('impacto_id', $impactos_ls, Input::old('impacto_id'))  }}
            {{ $errors->first('impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('condicion')) has-error @endif">
            {{ Form::label('condicion', 'Condicion:') }}
              {{ Form::text('condicion', Input::old('condicion'), array('placeholder'=>'Condicion')) }}
            {{ $errors->first('condicion', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('condicione.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


