@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($ca_tpo_inconformidade, array('class' => 'form', 'method' => 'PUT', 'url' => 'ca_tpo_inconformidad/update/'.$ca_tpo_inconformidade->id)) }}
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

        <div class="row_1 @if ( $errors->has('tpo_inconformidad')) has-error @endif">
            {{ Form::label('tpo_inconformidad', 'Tpo_inconformidad:') }}
              {{ Form::text('tpo_inconformidad', Input::old('tpo_inconformidad'), array('placeholder'=>'T. Inconformidad')) }}
            {{ $errors->first('tpo_inconformidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('ca_tpo_inconformidad.index', 'Cancelar', $ca_tpo_inconformidade->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop