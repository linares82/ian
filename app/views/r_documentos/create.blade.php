@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'r_documento.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('tpo_documento_id')) has-error @endif">
            {{ Form::label('tpo_documento_id', 'T. Documento:') }}
              {{ Form::select('tpo_documento_id', $tpo_docs_ls, Input::old('tpo_documento_id'))  }}
            {{ $errors->first('tpo_documento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('r_documento')) has-error @endif">
            {{ Form::label('r_documento', 'Documento:') }}
              {{ Form::text('r_documento', Input::old('r_documento'), array('placeholder'=>'Documento')) }}
            {{ $errors->first('r_documento', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('r_documento.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop


