@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($aa_aspecto, array('class' => 'form', 'method' => 'PUT', 'url' => 'aa_aspecto/update/'.$aa_aspecto->id)) }}
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

        <div class="row_1 @if ( $errors->has('aspectos')) has-error @endif">
            {{ Form::label('aspectos', 'Aspectos:') }}
              {{ Form::text('aspectos', Input::old('aspectos'), array('placeholder'=>'Aspectos')) }}
            {{ $errors->first('aspectos', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('detalle')) has-error @endif">
            {{ Form::label('detalle', 'Detalle:') }}
              {{ Form::text('detalle', Input::old('detalle'), array('placeholder'=>'Detalle')) }}
            {{ $errors->first('detalle', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('aa_aspecto.index', 'Cancelar', $aa_aspecto->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop