@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($cs_tpo_bitacora, array('class' => 'form', 'method' => 'PUT', 'url' => 'cs_tpo_bitacora/update/'.$cs_tpo_bitacora->id)) }}
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

        <div class="row_1 @if ( $errors->has('tpo_bitacora')) has-error @endif">
            {{ Form::label('tpo_bitacora', 'Tpo_bitacora:') }}
              {{ Form::text('tpo_bitacora', Input::old('tpo_bitacora'), array('placeholder'=>'Tpo_bitacora')) }}
            {{ $errors->first('tpo_bitacora', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('cs_tpo_bitacora.index', 'Cancelar', $cs_tpo_bitacora->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop