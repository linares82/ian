@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($user, array('class' => 'form', 'method' => 'PUT', 'url' => 'user/postPerfil')) }}
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

        <div class="row_1 @if ($errors->has('email')) has-error @endif">
            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email', Input::old('email'), array('placeholder'=>'Email')) }}
            @if ($errors->has('email')) <div class="errorMessage">{{ $errors->first('email') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('username')) has-error @endif">
            {{ Form::label('username', 'Usuario:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::text('username', Input::old('username'), array('class'=>'form-control', 'placeholder'=>'Usuario')) }}
            @if ($errors->has('username')) <div class="errorMessage">{{ $errors->first('username') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('password')) has-error @endif">
            {{ Form::label('password', 'Password:') }}
              {{ Form::password('password', Input::old('description'), array('placeholder'=>'Password')) }}
            @if ($errors->has('password')) <div class="errorMessage">{{ $errors->first('password') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('first_name')) has-error @endif">
            {{ Form::label('first_name', 'Nombre:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::text('first_name', Input::old('first_name'), array('class'=>'form-control', 'placeholder'=>'Nombre')) }}
            @if ($errors->has('first_name')) <div class="errorMessage">{{ $errors->first('first_name') }}</div> @endif
        </div>

        <div class="row_1 @if ($errors->has('last_name')) has-error @endif">
            {{ Form::label('last_name', 'Apellidos:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::text('last_name', Input::old('last_name'), array('class'=>'form-control', 'placeholder'=>'Apellidos')) }}
            @if ($errors->has('last_name')) <div class="errorMessage">{{ $errors->first('last_name') }}</div> @endif
        </div>

        @if ($user->multi_entidad==1)
        <div class="row_1 @if ($errors->has('entidad_id')) has-error @endif">
            {{ Form::label('entidad_id', 'Entidad:') }}
            {{ Form::select('entidad_id', ['0' => 'Seleccionar'] +Entidad::lists('abreviatura','id')) }}
            @if ($errors->has('entidad_id')) <div class="errorMessage">{{ $errors->first('entidad_id') }}</div> @endif
        </div>
        @endif

        <div class="row_1" style="height:40px; "></div>

    <div class="row_buttons">
      {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
	  {{ link_to_route('inicio', 'Regresar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
    </div>

	</div>
</div>



{{ Form::close() }}

@stop
@section('js_local')
    <script type="text/javascript" src="{{ asset('js/base.js')}}"></script>
    
@stop