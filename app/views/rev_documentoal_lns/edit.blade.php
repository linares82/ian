@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($rev_documentoal_ln, 
                array('class' => 'form', 
                      'method' => 'POST', 
                      'url' => 'rev_documentoal_ln/update/'.$rev_documentoal_ln->id,
                      'files'=>true,
                      'id'=>'f_rev_documentoal_lns'
                      )) }}
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

        <div class="row @if ( $errors->has('tpo_documento_id')) has-error @endif">
            {{ Form::label('tpo_documento_id', 'T. Documento:') }}
              {{ Form::select('tpo_documento_id', $tpo_documentos_ls, Input::old('tpo_documento_id'))  }}
            {{ $errors->first('tpo_documento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('documento_id')) has-error @endif">
            {{ Form::label('documento_id', 'Documento:') }}
            <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
              {{ Form::select('documento_id', $r_documentos_ls, Input::old('documento_id'), array('id'=>'documento_id'))  }}
            {{ $errors->first('documento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('grupo_normal_id')) has-error @endif" style="clear:left">
            {{ Form::label('grupo_norma_id', 'Grupo:') }}
              {{ Form::select('grupo_norma_id', $grupos_ls, Input::old('grupo_id'))  }}
            {{ $errors->first('grupo_norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2cols @if ( $errors->has('norma_id')) has-error @endif">
            {{ Form::label('norma_id', 'Norma:') }}
            <div class="row_1"><div id='loading2' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
            {{ Form::select('norma_id', $normas_ls, Input::old('norma_id'))  }}
            {{ $errors->first('norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('estatus_id')) has-error @endif">
            {{ Form::label('estatus_id', 'Estatus:') }}
              {{ Form::select('estatus_id', $estatus_ls, Input::old('estatus_id'))  }}
            {{ $errors->first('estatus_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('importancia_id')) has-error @endif">
            {{ Form::label('importancia_id', 'Importancia:') }}
              {{ Form::select('importancia_id', $importancia_ls, Input::old('importancia_id'))  }}
            {{ $errors->first('importancia_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_advertencia1')) has-error @endif">
            {{ Form::label('dias_advertencia1', 'Dias Advertencia 1:') }}
              {{ Form::input('number', 'dias_advertencia1', Input::old('dias_advertencia1')) }}
            {{ $errors->first('dias_advertencia1', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_advertencia2')) has-error @endif">
            {{ Form::label('dias_advertencia2', 'Dias Advertencia 2:') }}
              {{ Form::input('number', 'dias_advertencia2', Input::old('dias_advertencia2')) }}
            {{ $errors->first('dias_advertencia2', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_advertencia3')) has-error @endif">
            {{ Form::label('dias_advertencia3', 'Dias Advertencia 3:') }}
              {{ Form::input('number', 'dias_advertencia3', Input::old('dias_advertencia3')) }}
            {{ $errors->first('dias_advertencia3', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_cumplimiento')) has-error @endif">
            {{ Form::label('fec_cumplimiento', 'F. Cumplimiento:') }}
              {{ Form::text('fec_cumplimiento', Input::old('fec_cumplimiento'), array('placeholder'=>'Fec_cumplimiento', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser')) }}
            {{ $errors->first('fec_cumplimiento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_vencimiento')) has-error @endif">
            {{ Form::label('fec_vencimiento', 'F. Vencimiento:') }}
              {{ Form::text('fec_vencimiento', Input::old('fec_vencimiento'), array('placeholder'=>'Fec_vencimiento', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser')) }}
            {{ $errors->first('fec_vencimiento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('archivo')) has-error @endif">
            {{ Form::label('archivo', 'Archivo:') }}
              {{ Form::file('file', array('id'=>'file')) }}
              {{ Form::text('archivo', Input::old('archivo'), array('placeholder'=>'Archivo', 'readonly'=>'readonly')) }}
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('observaciones')) has-error @endif">
            {{ Form::label('observaciones', 'Observaciones:') }}
              {{ Form::text('observaciones', Input::old('observaciones'), array('placeholder'=>'Observaciones')) }}
            {{ $errors->first('observaciones', '<div class="errorMessage">:message</div>') }}
        </div>
        
        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('rev_documentoal_ln.index', 'Cancelar', array('id'=>$rev_documentoal_ln->rev_documental_id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
<script type="text/javascript">
    $(document).ready(function() { 
        $("#tpo_documento_id").change(function(event) {
                cmbDoc();
            });
        $("#grupo_norma_id").change(function(event) {
            cmbNormas();
            });
        });

    function cmbDoc(){
        var a= $('#f_rev_documentoal_lns').serialize();
        $.ajax({
            url: '{{ route("rev_documentoal_ln.cmbDoc") }}',
            type: 'POST',
            data: a, 
            dataType: 'json',
            beforeSend : function(){$("#loading1").show();},
            complete : function(){$("#loading1").hide();},
            success: function(documentos){
                $('select#documento_id').html('');
                $('select#documento_id').append($('<option></option>').text('Seleccionar').val(''));
                $.each(documentos, function(i) {
                    $('select#documento_id').append("<option "+documentos[i].selectec+" value=\""+documentos[i].id+"\">"+documentos[i].r_documento+"<\/option>");
                });
            }
        });
    }

    function cmbNormas(){
        var a= $('#f_rev_documentoal_lns').serialize();
            $.ajax({
                url: '{{ route("rev_documentoal_ln.cmbNormas") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(normas){
                    $('select#norma_id').html('');
                    $('select#norma_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(normas, function(i) {
                        $('select#norma_id').append("<option "+normas[i].selectec+" value=\""+normas[i].id+"\">"+normas[i].norma+"<\/option>");
                    });
                }
            });
    }

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

