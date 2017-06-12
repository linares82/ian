@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($a_rr_amb_doc, array('class' => 'form', 'method' => 'PUT', 'url' => 'a_rr_amb_doc/update/'.$a_rr_amb_doc->id)) }}
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

        <div class="row_1 @if ( $errors->has('a_rr_ambiental_id')) has-error @endif">
            {{ Form::label('a_rr_ambiental_id', 'A_rr_ambiental_id:') }}
              {{ Form::input('number', 'a_rr_ambiental_id', Input::old('a_rr_ambiental_id')) }}
            {{ $errors->first('a_rr_ambiental_id', '<div class="errorMessage">:message</div>') }}
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
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('a_rr_amb_doc.index', 'Cancelar', $a_rr_amb_doc->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop