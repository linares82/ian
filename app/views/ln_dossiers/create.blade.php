@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'ln_dossier.store', 'class' => 'form')) }}
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
            {{ Form::label('dossier_id', 'Dossier_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'dossier_id', Input::old('dossier_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('modulo_id', 'Modulo_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'modulo_id', Input::old('modulo_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('doc_dossier_id', 'Doc_dossier_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'doc_dossier_id', Input::old('doc_dossier_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('fec_planeada', 'Fec_planeada:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('fec_planeada', Input::old('fec_planeada'), array('class'=>'form-control', 'placeholder'=>'Fec_planeada')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('fec_obs', 'Fec_obs:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('fec_obs', Input::old('fec_obs'), array('class'=>'form-control', 'placeholder'=>'Fec_obs')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('datos_relevantes', 'Datos_relevantes:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('datos_relevantes', Input::old('datos_relevantes'), array('class'=>'form-control', 'placeholder'=>'Datos_relevantes')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('estatus_id', 'Estatus_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'estatus_id', Input::old('estatus_id'), array('class'=>'form-control')) }}
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
					  {{ link_to_route('ln_dossier.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
				</div>
			</div>
    </div>

{{ Form::close() }}

@stop


