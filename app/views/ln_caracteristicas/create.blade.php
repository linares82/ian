@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'ln_caracteristica.store', 'class' => 'form')) }}
    <div class="easyui-tabs" style="width:auto;height:auto;">
        <div title="Crear" style="padding:10px;">  

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

        <div class="form-group">
            {{ Form::label('reg_impacto_id', 'Reg_impacto_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'reg_impacto_id', Input::old('reg_impacto_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('caracteristica_id', 'Caracteristica_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'caracteristica_id', Input::old('caracteristica_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('efecto_id', 'Efecto_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'efecto_id', Input::old('efecto_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('desc_efecto', 'Desc_efecto:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('desc_efecto', Input::old('desc_efecto'), array('class'=>'form-control', 'placeholder'=>'Desc_efecto')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('usu_alta_id', 'Usu_alta_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'usu_alta_id', Input::old('usu_alta_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('usu_mod_id', 'Usu_mod_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'usu_mod_id', Input::old('usu_mod_id'), array('class'=>'form-control')) }}
            </div>
        </div>


				<div class="row_buttons">
					  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
					  {{ link_to_route('ln_caracteristica.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
				</div>
			</div>
    </div>

{{ Form::close() }}

@stop


