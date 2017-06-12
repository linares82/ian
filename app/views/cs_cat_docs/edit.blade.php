@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($cs_cat_doc, array('class' => 'form', 'method' => 'PUT', 'url' => 'cs_cat_doc/update/'.$cs_cat_doc->id)) }}
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

        <div class="row_1 @if ( $errors->has('cat_doc')) has-error @endif">
            {{ Form::label('cat_doc', 'Documento:') }}
              {{ Form::text('cat_doc', Input::old('cat_doc'), array('placeholder'=>'Documento')) }}
            {{ $errors->first('cat_doc', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('cs_cat_doc.index', 'Cancelar', $cs_cat_doc->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop