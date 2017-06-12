@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'bit_doc_accidente.store', 'class' => 'form')) }}
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

        <div class="row_1 @if ( $errors->has('bitacora_accidente')) has-error @endif">
            {{ Form::label('bitacora_accidente', 'Bitacora_accidente:') }}
              {{ Form::input('number', 'bitacora_accidente', Input::old('bitacora_accidente')) }}
            {{ $errors->first('bitacora_accidente', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('documento')) has-error @endif">
            {{ Form::label('documento', 'Documento:') }}
              {{ Form::text('documento', Input::old('documento'), array('placeholder'=>'Documento')) }}
            {{ $errors->first('documento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('archivo')) has-error @endif">
            {{ Form::label('archivo', 'Archivo:') }}
              {{ Form::text('archivo', Input::old('archivo'), array('placeholder'=>'Archivo')) }}
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>


				<div class="row_buttons">
					  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
					  {{ link_to_route('bit_doc_accidente.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
				</div>
			</div>
    </div>

{{ Form::close() }}

@stop


