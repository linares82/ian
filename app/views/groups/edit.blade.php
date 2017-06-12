@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($group, array('class' => 'form', 'method' => 'PUT', 'url' => 'group/update/'.$group->id, 'files' => true)) }}
     <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Editar" style="padding:10px;"> 

       <div class="row_2 @if ($errors->has('name')) has-error @endif">
            {{ Form::label('name', 'Nombre:') }}
            {{ Form::text('name', Input::old('name'), array('placeholder'=>'Nombre')) }}
            @if ($errors->has('name')) <div class="errorMessage">{{ $errors->first('name') }}</div> @endif
        </div>

        <div class="row_2">
        </div>

        <div class="row_2 @if ($errors->has('name')) has-error @endif">
            
            @include('permissions.permissions-select', array('permissions'=> $permissions))
            
        </div>

        <div class="row_2">
        </div>


    <div class="row_buttons">
      {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
      {{ link_to_route('group.index', 'Cancelar', $group->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
    </div>

	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
    <script type="text/javascript" src="{{ asset('js/base.js')}}"></script>
@stop