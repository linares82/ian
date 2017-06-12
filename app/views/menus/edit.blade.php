@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($menu, array('class' => 'form', 'method' => 'PUT', 'url' => 'menus/update/'.$menu->id)) }}
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
		
        <div class="row_1 @if ($errors->has('item')) has-error @endif">
            {{ Form::label('item', 'Item:') }}
              {{ Form::text('item', Input::old('item'), array('placeholder'=>'Item')) }}
			  @if ($errors->has('item')) <div class="errorMessage">{{ $errors->first('item') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('orden')) has-error @endif">
            {{ Form::label('orden', 'Orden:') }}
              {{ Form::input('number', 'orden', Input::old('orden')) }}
			  @if ($errors->has('orden')) <div class="errorMessage">{{ $errors->first('orden') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('depende_de')) has-error @endif">
            {{ Form::label('depende_de', 'Depende de:') }}
              {{ Form::select('depende_de', ['0' => 'Seleccionar'] +Menu::lists('item','id')) }}
			  @if ($errors->has('depende_de')) <div class="errorMessage">{{ $errors->first('depende_de') }}</div> @endif
        </div>
        <div class="row_1 @if ($errors->has('lin')) has-error @endif" style="clear:left;">
            {{ Form::label('link', 'Link:') }}
              {{ Form::text('link', Input::old('link'), array('placeholder'=>'Link')) }}
			  @if ($errors->has('link')) <div class="errorMessage">{{ $errors->first('link') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('permiso_id')) has-error @endif">
            {{ Form::label('permiso_id', 'Permiso:') }}
              {{ Form::text('permiso_id', Input::old('permiso_id'), array('placeholder'=>'permiso_id')) }}
			  @if ($errors->has('permiso_id')) <div class="errorMessage">{{ $errors->first('permiso_id') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('target')) has-error @endif">
            {{ Form::label('target', 'Target:') }}
              {{ Form::text('target', Input::old('target'), array('placeholder'=>'Target')) }}
			  @if ($errors->has('target')) <div class="errorMessage">{{ $errors->first('target') }}</div> @endif
        </div>

        <div class="row_buttons">
              {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
              {{ link_to_route('menus.index', 'Cancelar', $menu->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>
    </div>
    </div>
{{ Form::close() }}

@stop