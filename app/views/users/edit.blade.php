@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($user, array('class' => 'form', 'method' => 'PUT', 'url' => 'user/update/'.$user->id)) }}
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



        <div class="row_1">
            <label>Baneado</label>
            <input id="no" name="banned" type="radio" style="width:20%; float:left;" value="no" {{ ($throttle->isBanned() === false) ? 'checked' : '' }}>
            <label for="no" onclick="" style="width:20%; float:left;">No</label>
            <input id="yes" name="banned" type="radio" style="width:20%; float:left;" value="yes" {{ ($throttle->isBanned() === true) ? 'checked' : '' }}>
            <label for="yes" onclick="" style="width:20%; float:left;">Si</label>
        </div>

        <div class="row_1" style="clear:left">
            <label>Multientidad</label>
            <input id="no" name="multi_entidad" type="radio" style="width:20%; float:left;" value="no" {{ ($user_me->multi_entidad == '0') ? 'checked' : '' }}>
            <label for="no" onclick="" style="width:20%; float:left;">No</label>
            <input id="yes" name="multi_entidad" type="radio" style="width:20%; float:left;" value="yes" {{ ($user_me->multi_entidad == '1') ? 'checked' : '' }}>
            <label for="yes" onclick="" style="width:20%; float:left;">Si</label>
        </div>

        <div class="row_1 @if ($errors->has('entidad_id')) has-error @endif">
            {{ Form::label('entidad_id', 'Entidad:') }}
            {{ Form::select('entidad_id', ['0' => 'Seleccionar'] +Entidad::lists('abreviatura','id')) }}
            @if ($errors->has('entidad_id')) <div class="errorMessage">{{ $errors->first('entidad_id') }}</div> @endif
        </div>
        <div class="row_1 @if ($errors->has('empleado_id')) has-error @endif">
            {{ Form::label('empleado_id', 'Empleado:') }}
            {{ Form::select('empleado_id', ['0' => 'Seleccionar'] +Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id')) }}
            @if ($errors->has('empleado_id')) <div class="errorMessage">{{ $errors->first('empleado_id') }}</div> @endif
        </div>

        <div class="row_1" style="height:40px; "></div>

        <div class="row_2" style="clear:left"><b>Grupos</b><br/>
        @foreach($groups as $group)
            <label>
                <input type="checkbox" id="groups[{{ $group->id }}]" name="groups[]" value="{{ $group->id }}" {{ ($user->inGroup($group)) ? 'checked="checked"' : ''}}>
                {{ $group->name }}
            </label>
            <br/>
        @endforeach
        </div>

        
        <div class="row_1 @if ($errors->has('permissions')) has-error @endif">
            
            @include('permissions.permissions-select', array('permissions'=> $permissions))
            
            @if ($errors->has('permissions')) <div class="errorMessage">{{ $errors->first('permissions') }}</div> @endif
        
        </div>


    <div class="row_buttons">
      {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
      {{ link_to_route('user.index', 'Cancelar', $user->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
    </div>

	</div>
</div>



{{ Form::close() }}

@stop
@section('js_local')
    <script type="text/javascript" src="{{ asset('js/base.js')}}"></script>
@stop