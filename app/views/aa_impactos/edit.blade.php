@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($aa_impacto, array('class' => 'form', 'method' => 'PUT', 'url' => 'aa_impacto/update/'.$aa_impacto->id)) }}
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

        <div class="row_1 @if ( $errors->has('impacto')) has-error @endif">
            {{ Form::label('impacto', 'Impacto:') }}
              {{ Form::text('impacto', Input::old('impacto'), array('placeholder'=>'Impacto')) }}
            {{ $errors->first('impacto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('detalle')) has-error @endif">
            {{ Form::label('detalle', 'Detalle:') }}
              {{ Form::text('detalle', Input::old('detalle'), array('placeholder'=>'Detalle')) }}
            {{ $errors->first('detalle', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('aa_impacto.index', 'Cancelar', $aa_impacto->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop