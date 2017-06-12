@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($a_st_archivo, array('class' => 'form', 'method' => 'PUT', 'url' => 'a_st_archivo/update/'.$a_st_archivo->id)) }}
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

        <div class="row_1 @if ( $errors->has('estatus')) has-error @endif">
            {{ Form::label('estatus', 'Estatus:') }}
              {{ Form::text('estatus', Input::old('estatus'), array('placeholder'=>'Estatus')) }}
            {{ $errors->first('estatus', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('usu_alta_id')) has-error @endif">
            {{ Form::label('usu_alta_id', 'Usu_alta_id:') }}
              {{ Form::input('number', 'usu_alta_id', Input::old('usu_alta_id')) }}
            {{ $errors->first('usu_alta_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('usu_mod_id')) has-error @endif">
            {{ Form::label('usu_mod_id', 'Usu_mod_id:') }}
              {{ Form::input('number', 'usu_mod_id', Input::old('usu_mod_id')) }}
            {{ $errors->first('usu_mod_id', '<div class="errorMessage">:message</div>') }}
        </div>


<div class="row_buttons">
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('a_st_archivo.index', 'Cancelar', $a_st_archivo->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop