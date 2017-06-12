@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'cs_norma.store', 'class' => 'form', 'files' => true)) }}
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

        <div class="row_1 @if ( $errors->has('grupo_norma_id')) has-error @endif">
            {{ Form::label('grupo_norma_id', 'Grupo Norma:') }}
              {{ Form::select('grupo_norma_id', $grupo_normas_ls, Input::old('grupo_norma_id'))  }}
            {{ $errors->first('grupo_norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('norma')) has-error @endif">
            {{ Form::label('norma', 'Norma:') }}
              {{ Form::text('norma', Input::old('norma'), array('placeholder'=>'Norma')) }}
            {{ $errors->first('norma', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="form-group">
            {{ Form::label('archivo', 'Archivo:') }}
            {{ Form::file('file', array('id'=>'file')) }}
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('cs_norma.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


