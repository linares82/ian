@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'ca_categoria.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('material_id')) has-error @endif">
            {{ Form::label('material_id', 'Material_id:') }}
              {{ Form::select('material_id', $materiales_ls, Input::old('material_id'))  }}
            {{ $errors->first('material_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('categoria')) has-error @endif">
            {{ Form::label('categoria', 'Categoria:') }}
              {{ Form::text('categoria', Input::old('categoria'), array('placeholder'=>'Categoria')) }}
            {{ $errors->first('categoria', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('ca_categoria.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


