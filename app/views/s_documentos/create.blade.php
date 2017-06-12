@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 's_documento.store', 'class' => 'form', 'files'=>true)) }}
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

        <div class="row_1 @if ( $errors->has('documento_id')) has-error @endif">
            {{ Form::label('documento_id', 'Documento:') }}
              {{ Form::select('documento_id', $cat_docs_ls, Input::old('documento_id'))  }}
            {{ $errors->first('documento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @if ( $errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripcion:') }}
              {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_ini_vigencia')) has-error @endif">
            {{ Form::label('fec_ini_vigencia', 'F. Inicio Vigencia:') }}
              {{ Form::text('fec_ini_vigencia', Input::old('fec_ini_vigencia'), array('placeholder'=>'Fec_ini_vigencia', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_ini_vigencia', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_fin_vigencia')) has-error @endif">
            {{ Form::label('fec_fin_vigencia', 'F. Fin Vigencia:') }}
              {{ Form::text('fec_fin_vigencia', Input::old('fec_fin_vigencia'), array('placeholder'=>'Fec_fin_vigencia', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_fin_vigencia', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('aviso')) has-error @endif">
            {{ Form::label('aviso', 'Aviso:') }}
            {{ Form::select('aviso', $bnds_ls, Input::old('aviso'))  }}
            {{ $errors->first('aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias Aviso:') }}
              {{ Form::input('number', 'dias_aviso', Input::old('dias_aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('archivo')) has-error @endif">
            {{ Form::label('archivo', 'Archivo:') }}
              {{ Form::file('file', array('id'=>'file')) }}
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('observaciones')) has-error @endif">
            {{ Form::label('observaciones', 'Observaciones:') }}
              {{ Form::text('observaciones', Input::old('observaciones'), array('placeholder'=>'Observaciones')) }}
            {{ $errors->first('observaciones', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('s_documento.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop

@section('js_local')
<script type="text/javascript">

    function myformatter(date){
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate();
        return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
    }
    function myparser(s){
        if (!s) return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0],10);
        var m = parseInt(ss[1],10);
        var d = parseInt(ss[2],10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
            return new Date(y,m-1,d);
        } else {
            return new Date();
        }
    }

</script>
@stop


