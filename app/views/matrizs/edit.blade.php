@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($matriz, array('class' => 'form', 'method' => 'PUT', 'url' => 'matriz/update/'.$matriz->id)) }}
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

        <div class="row_1 @if ($errors->has('tipo_impacto_id')) has-error @endif">
            {{ Form::label('tipo_impacto_id', 'Tipo de Impacto:') }}
            {{ Form::select('tipo_impacto_id', $tipo_impacto_ls, Input::old('Tipo de Impacto'))  }}
            {{ $errors->first('tipo_impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('factor_id')) has-error @endif">
            {{ Form::label('factor_id', 'Factor:') }}
            {{ Form::select('factor_id', $factor_ls, Input::old('factor_id'))  }}
            {{ $errors->first('factor_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('factor_id')) has-error @endif">
            {{ Form::label('rubro_id', 'Rubro:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::select('rubro_id', $rubro_ls, Input::old('rubro_id'))  }}
            {{ $errors->first('rubro_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('especifico_id')) has-error @endif">
            {{ Form::label('especifico_id', 'Especifico:', array('class'=>'col-md-2 control-label')) }}
            {{ Form::select('especifico_id', $especifico_ls, Input::old('especifico_id'))  }}
            {{ $errors->first('especifico_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row" style="clear:left;width:92%">
            {{ Form::label('caracteristicas', 'Documentos:') }}
            {{ Form::select('caracteristicas[]', $caracteristicas_ls, $caracteristicas_seleccionadas, array('multiple'=>True, 
            'id'=>'caracteristicas', 'style'=>'width:90%'), Input::old('caracteristicas[]')) }}
        </div>


<div class="row_buttons">
  {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
  {{ link_to_route('matriz.index', 'Cancelar', $matriz->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
</div>

	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
    <link href="{{ asset('select2-3.5.1/select2.css') }}" rel="stylesheet"/>
    <script type="text/javascript" src="{{ asset('select2-3.5.1/select2.js') }} "></script>
    <script type="text/javascript">
        $(document).ready(function() { $("#caracteristicas").select2({placeholder: "Selecionar opcion"}); });
    </script>
@stop