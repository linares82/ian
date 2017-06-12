@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($empleado, array('class' => 'form', 'method' => 'PUT', 'url' => 'empleado/update/'.$empleado->id)) }}
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

        <div class="row_1 @if ( $errors->has('ctrl_interno')) has-error @endif">
            {{ Form::label('ctrl_interno', 'C. Interno:') }}
              {{ Form::text('ctrl_interno', Input::old('ctrl_interno'), array('placeholder'=>'C. Interno')) }}
            {{ $errors->first('ctrl_interno', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('nombre')) has-error @endif">
            {{ Form::label('nombre', 'Nombre:') }}
              {{ Form::text('nombre', Input::old('nombre'), array('placeholder'=>'Nombre')) }}
            {{ $errors->first('nombre', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('direccion')) has-error @endif">
            {{ Form::label('direccion', 'Dirección:') }}
              {{ Form::textArea('direccion', Input::old('direccion'), array('placeholder'=>'Dirección', 'rows'=>'3')) }}
            {{ $errors->first('direccion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('contacto')) has-error @endif">
            {{ Form::label('contacto', 'Contacto:') }}
              {{ Form::textArea('contacto', Input::old('contacto'), array('placeholder'=>'Contacto', 'rows'=>'3')) }}
            {{ $errors->first('contacto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('mail')) has-error @endif">
            {{ Form::label('mail', 'Mail:') }}
              {{ Form::text('mail', Input::old('mail'), array('placeholder'=>'Mail')) }}
            {{ $errors->first('mail', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('area_id')) has-error @endif">
            {{ Form::label('area_id', 'Area:') }}
              {{ Form::select('area_id', $areas_ls, Input::old('area_id'))  }}
            {{ $errors->first('area_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('puesto_id')) has-error @endif">
            {{ Form::label('puesto_id', 'Puesto:') }}
              {{ Form::select('puesto_id', $puestos_ls, Input::old('puesto_id'))  }}
            {{ $errors->first('puesto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('bnd_subordinados')) has-error @endif">
            {{ Form::label('bnd_subordinados', 'Subordinados:') }}
            {{ Form::select('bnd_subordinados', $bnds_ls, Input::old('bnd_subordinados'))  }}
            {{ $errors->first('bnd_subordinados', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('jefe_id')) has-error @endif">
            {{ Form::label('jefe_id', 'Jefe:') }}
              {{ Form::select('jefe_id', $jefes_ls, Input::old('jefe_id'))  }}
            {{ $errors->first('jefe_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('empleado.index', 'Cancelar', $empleado->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop