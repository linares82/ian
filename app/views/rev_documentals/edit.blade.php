@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($rev_documental, array('class' => 'form', 'method' => 'PUT', 'url' => 'rev_documental/update/'.$rev_documental->id)) }}
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

        <div class="row_1 @if ( $errors->has('anio')) has-error @endif">
            {{ Form::label('anio', 'Año(aaaa):') }}
            {{ Form::input('number', 'anio', Input::old('anio')) }}  
            {{ $errors->first('anio', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('mes_id')) has-error @endif">
            {{ Form::label('mes_id', 'Mes:') }}
            {{ Form::select('mes_id', $meses_ls, Input::old('mes_id'))  }}      
            {{ $errors->first('mes_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('rev_documental.index', 'Cancelar', $rev_documental->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop