@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($ca_tpo_noconformidade, array('class' => 'form', 'method' => 'PUT', 'url' => 'ca_tpo_noconformidade/update/'.$ca_tpo_noconformidade->id)) }}
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

        <div class="row_1 @if ( $errors->has('tpo_bitacora_id')) has-error @endif">
            {{ Form::label('tpo_bitacora_id', 'T. Bitacora:') }}
              {{ Form::select('tpo_bitacora_id', $tpo_bitacoras_ls, Input::old('tpo_bitacora_id'))  }}
            {{ $errors->first('tpo_bitacora_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('tpo_inconformidad')) has-error @endif">
            {{ Form::label('tpo_inconformidad', 'T. Inconformidad:') }}
              {{ Form::textArea('tpo_inconformidad', Input::old('tpo_inconformidad'), array('placeholder'=>'T. Inconformidad', 'rows'=>'4')) }}
            {{ $errors->first('tpo_inconformidad', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('ca_tpo_noconformidade.index', 'Cancelar', $ca_tpo_noconformidade->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop