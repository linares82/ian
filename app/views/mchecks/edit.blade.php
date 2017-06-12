@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($mcheck, array('class' => 'form', 'method' => 'PUT', 'url' => 'mcheck/update/'.$mcheck->id)) }}
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

        <div class="row_2 @if ($errors->has('a_chequeo')) has-error @endif">
            {{ Form::label('a_chequeo', 'Area de chequeo:') }}
            {{ Form::select('a_chequeo', $achecks_ls, Input::old('a_chequeo'))  }}
            {{ $errors->first('a_chequeo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('norma_id')) has-error @endif">
            {{ Form::label('norma_id', 'Norma:') }}
            {{ Form::select('norma_id', $normas_ls, Input::old('norma_id'))  }}
            {{ $errors->first('norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('no_conformidad')) has-error @endif" style="clear:left">
            {{ Form::label('no_conformidad', 'No Conformidad:') }}
            {{ Form::textArea('no_conformidad', Input::old('no_conformidad'), array('placeholder'=>'No Conformidad', 'rows'=>'7')) }}
            {{ $errors->first('no_conformidad', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ($errors->has('requisito')) has-error @endif">
            {{ Form::label('requisito', 'Requisito:') }}
              {{ Form::textArea('requisito', Input::old('requisito'), array('placeholder'=>'Requisito', 'rows'=>'7')) }}
            {{ $errors->first('requisito', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('rnc')) has-error @endif">
            {{ Form::label('rnc', 'Rnc:') }}
              {{ Form::text('rnc', Input::old('rnc'), array('placeholder'=>'Rnc')) }}
            {{ $errors->first('rnc', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('Minimo VSM')) has-error @endif">
            {{ Form::label('minimo_vsm', 'Minimo VSM:') }}
              {{ Form::text('minimo_vsm', Input::old('minimo_vsm'), array('placeholder'=>'Minimo VSM')) }}
            {{ $errors->first('minimo_vsm', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('Maximo VSM')) has-error @endif">
            {{ Form::label('maximo_vsm', 'Maximo VSM:') }}
              {{ Form::text('maximo_vsm', Input::old('maximo_vsm'), array('placeholder'=>'Maximo VSM')) }}
            {{ $errors->first('maximo_vms', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row2 @if ($errors->has('correccion')) has-error @endif" style="clear:left">
            {{ Form::label('correcion', 'Correccion:') }}
              {{ Form::textArea('correccion', Input::old('especifico'), array('placeholder'=>'Correccion', 'rows'=>'3')) }}
            {{ $errors->first('correccion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('orden')) has-error @endif">
            {{ Form::label('orden', 'Orden:') }}
              {{ Form::input('number', 'orden', Input::old('orden'), array('class'=>'form-control')) }}
            {{ $errors->first('roden', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('mcheck.index', 'Cancelar', $mcheck->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop