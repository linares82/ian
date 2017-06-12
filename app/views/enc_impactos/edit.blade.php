@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($enc_impacto, array('class' => 'form', 'method' => 'PUT', 'url' => 'enc_impacto/update/'.$enc_impacto->id)) }}
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

        <div class="row_1 @if ($errors->has('proyecto')) has-error @endif">
            {{ Form::label('proyecto', 'Proyecto:') }}
            {{ Form::text('proyecto', Input::old('rzon_social'), array('placeholder'=>'Proyecto')) }}
            {{ $errors->first('proyecto', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('tipo_impacto_id')) has-error @endif">
            {{ Form::label('tipo_impacto_id', 'Tipo de Impacto:') }}
            {{ Form::select('tipo_impacto_id', $tipo_impactos_ls, Input::old('tipo_impacto_id'))  }}
            {{ $errors->first('tipo_impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('fecha_inicio')) has-error @endif">
            {{ Form::label('fecha_inicio', 'Fecha Inicio:') }}
            {{ Form::text('fecha_inicio', Input::old('fecha_inicio'), array('placeholder'=>'Fecha Inicio', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'id'=>'fecha_inicio')) }}
            {{ $errors->first('fecha_inicio', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('fecha_fin')) has-error @endif" style="clear:left;">
            {{ Form::label('fecha_fin', 'Fecha Fin:') }}
            {{ Form::text('fecha_fin', Input::old('fecha'), array('placeholder'=>'Fecha Fin', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'id'=>'fecha_fin')) }}
            {{ $errors->first('fecha_fin', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('up_calle')) has-error @endif" >
            {{ Form::label('up_calle', 'Calle:') }}
            {{ Form::text('up_calle', Input::old('up_calle'), array('placeholder'=>'Calle')) }}
            {{ $errors->first('up_calle', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('up_no')) has-error @endif">
            {{ Form::label('up_no', 'No. :') }}
            {{ Form::text('up_no', Input::old('up_no'), array('placeholder'=>'No.')) }}
            {{ $errors->first('up_no', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('up_colonia')) has-error @endif">
            {{ Form::label('up_colonia', 'Colonia:') }}
            {{ Form::text('up_colonia', Input::old('up_colonia'), array('placeholder'=>'Colonia')) }}
            {{ $errors->first('up_colonia', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('up_cp')) has-error @endif">
            {{ Form::label('up_cp', 'CP:') }}
            {{ Form::text('up_cp', Input::old('up_cp'), array('placeholder'=>'CP')) }}
            {{ $errors->first('up_cp', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('up_delegacion')) has-error @endif">
            {{ Form::label('up_delegacion', 'Delegación:') }}
            {{ Form::text('up_delegacion', Input::old('up_delegacion'), array('placeholder'=>'Delegación')) }}
            {{ $errors->first('up_delegacion', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('up_sup_predio')) has-error @endif">
            {{ Form::label('up_sup_predio', 'Superficice del Predio:') }}
            {{ Form::text('up_sup_predio', Input::old('up_sup_predio'), array('placeholder'=>'Superficice del Predio')) }}
            {{ $errors->first('up_sup_predio', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('longitud')) has-error @endif">
            {{ Form::label('longitud', 'Longitud:') }}
            {{ Form::text('longitud', Input::old('longitud'), array('placeholder'=>'Longitud')) }}
            {{ $errors->first('longitud', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('latitud')) has-error @endif">
            {{ Form::label('latitud', 'Latitud:') }}
            {{ Form::text('latitud', Input::old('latitud'), array('placeholder'=>'Latitud')) }}
            {{ $errors->first('latitud', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('altitud')) has-error @endif">
            {{ Form::label('altitud', 'Altitud:') }}
            {{ Form::text('altitud', Input::old('altitud'), array('placeholder'=>'Altitud')) }}
            {{ $errors->first('altitud', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('utm_x')) has-error @endif">
            {{ Form::label('utm_x', 'X:') }}
            {{ Form::text('utm_x', Input::old('utm_x'), array('placeholder'=>'X')) }}
            {{ $errors->first('utm_x', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('utm_y')) has-error @endif">
            {{ Form::label('utm_y', 'Y:') }}
            {{ Form::text('utm_y', Input::old('utm_y'), array('placeholder'=>'Y')) }}
            {{ $errors->first('utm_y', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ($errors->has('notas')) has-error @endif">
            {{ Form::label('notas', 'Breve descripción del proyecto:') }}
            {{ Form::textArea('notas', Input::old('notas'), array('placeholder'=>'Notas', 'rows'=>'3', 'style'=>'width:95%')) }}
            {{ $errors->first('notas', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" title="DATOS DEL PROMOVENTE" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ($errors->has('cliente_id')) has-error @endif">
            {{ Form::label('cliente_id', 'Nombre o razón social del Promovente:') }}
            {{ Form::select('cliente_id', $clientes_ls, Input::old('cliente_id'))  }}
            {{ $errors->first('cliente_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('od_calle')) has-error @endif">
            {{ Form::label('od_calle', 'Calle:') }}
            {{ Form::text('od_calle', Input::old('od_calle'), array('placeholder'=>'Calle')) }}
            {{ $errors->first('od_calle', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_no')) has-error @endif">
            {{ Form::label('od_no', 'No. :') }}
            {{ Form::text('od_no', Input::old('od_no'), array('placeholder'=>'No. ')) }}
            {{ $errors->first('od_no', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_colonia')) has-error @endif">
            {{ Form::label('od_colonia', 'Colonia:') }}
            {{ Form::text('od_colonia', Input::old('od_colonia'), array('placeholder'=>'Colonia')) }}
            {{ $errors->first('od_colonia', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_cp')) has-error @endif">
            {{ Form::label('od_cp', 'CP:') }}
            {{ Form::text('od_cp', Input::old('od_cp'), array('placeholder'=>'CP')) }}
            {{ $errors->first('od_cp', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_delegacion')) has-error @endif">
            {{ Form::label('od_delegacion', 'Delegacion:') }}
            {{ Form::text('od_delegacion', Input::old('od_delegacion'), array('placeholder'=>'Delegacion')) }}
            {{ $errors->first('od_delegacion', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_rfc')) has-error @endif">
            {{ Form::label('od_rfc', 'RFC:') }}
            {{ Form::text('od_rfc', Input::old('od_rfc'), array('placeholder'=>'RFC')) }}
            {{ $errors->first('od_rfc', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_telefono')) has-error @endif">
            {{ Form::label('od_telefono', 'Teléfono:') }}
            {{ Form::text('od_telefono', Input::old('od_telefono'), array('placeholder'=>'Teléfono')) }}
            {{ $errors->first('od_telefono', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('od_correo')) has-error @endif">
            {{ Form::label('od_correo', 'Correo Eletrónico:') }}
            {{ Form::text('od_correo', Input::old('od_correo'), array('placeholder'=>'Correo Electrónico')) }}
            {{ $errors->first('od_correo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div id="p" class="easyui-panel" title="DATOS DEL REPRESENTANTE LEGAL (EN SU CASO)" style="width:96%;margin-top:10px;margin-bottom:15px;">
        </div>

        <div class="row_1 @if ($errors->has('rl_ape_pat')) has-error @endif">
            {{ Form::label('rl_ape_pat', 'A. Paterno:') }}
            {{ Form::text('rl_ape_pat', Input::old('rl_ape_pat'), array('placeholder'=>'A. Paterno')) }}
            {{ $errors->first('rl_ape_pat', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('rl_ape_mat')) has-error @endif">
            {{ Form::label('rl_ape_mat', 'A. Materno:') }}
            {{ Form::text('rl_ape_mat', Input::old('rl_ape_mat'), array('placeholder'=>'A. Materno')) }}
            {{ $errors->first('rl_ape_mat', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('rl_nombre')) has-error @endif">
            {{ Form::label('rl_nombre', 'Nombre:') }}
            {{ Form::text('rl_nombre', Input::old('rl_nombre'), array('placeholder'=>'Nombre')) }}
            {{ $errors->first('rl_nombre', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('rl_id_vigente')) has-error @endif">
            {{ Form::label('rl_id_vigente', 'Identificación Oficial Vigente:') }}
            {{ Form::text('rl_id_vigente', Input::old('rl_id_vigente'), array('placeholder'=>'Identificación Oficial Vigente')) }}
            {{ $errors->first('rl_id_vigente', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('rl_id_no')) has-error @endif">
            {{ Form::label('rl_id_no', 'No. :') }}
            {{ Form::text('rl_id_no', Input::old('rl_id_no'), array('placeholder'=>'No. ')) }}
            {{ $errors->first('rl_id_no', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_1 @if ($errors->has('rl_no_intrumento')) has-error @endif">
            {{ Form::label('rl_no_intrumento', 'Instrumento Público No.:') }}
            {{ Form::text('rl_no_intrumento', Input::old('rl_no_intrumento'), array('placeholder'=>'Instrumento Público No.')) }}
            {{ $errors->first('rl_no_intrumento', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row @if ($errors->has('rl_autorizados')) has-error @endif">
            {{ Form::label('rl_autorizados', 'Autorizados:') }}
            {{ Form::textArea('rl_autorizados', Input::old('rl_autorizados'), array('placeholder'=>'Instrumento Público No.', 'rows'=>'3', 'style'=>'width:95%')) }}
            {{ $errors->first('rl_autorizados', '<div class="errorMessage">:message</div>') }}
        </div>
        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('enc_impacto.index', 'Cancelar', $enc_impacto->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
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


