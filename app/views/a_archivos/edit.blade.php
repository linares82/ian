@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($a_archivo, array('class' => 'form', 'method' => 'PUT', 'url' => 'a_archivo/update/'.$a_archivo->id, 'files'=>true)) }}
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

        <div class="row @if ( $errors->has('documento_id')) has-error @endif">
            {{ Form::label('documento_id', 'Documento:') }}
              {{ Form::select('documento_id', $documentos_ls, Input::old('documento_id'))  }}
            {{ $errors->first('documento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripción:') }}
            {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripción')) }}
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

        <div class="row_1 @if ( $errors->has('archivo')) has-error @endif", style="clear:left">
            {{ Form::label('archivo', 'Archivo:') }}
            {{ Form::file('file', Input::old('file'), array('id'=>'file')) }}
            {{ Form::text('archivo', Input::old('archivo'), array('id'=>'archivo', 'readonly'=>'readonly')) }}
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>


        <div class="row_1 @if ( $errors->has('aviso')) has-error @endif" >
            {{ Form::label('aviso', 'Aviso:') }}
            {{ Form::select('aviso', $bnds_ls, Input::old('aviso_id'))  }}
            {{ $errors->first('aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias Para Aviso:') }}
            {{ Form::input('number', 'dias_aviso', Input::old('dias_aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('obs')) has-error @endif">
            {{ Form::label('obs', 'Obs:') }}
            {{ Form::textArea('obs', Input::old('obs'), array('placeholder'=>'Obs', 'rows'=>"2")) }}
            {{ $errors->first('obs', '<div class="errorMessage">:message</div>') }}
        </div>

    <div class="row_buttons">
      {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
      {{ link_to_route('a_archivo.index', 'Cancelar', $a_archivo->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
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
