@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 's_registro.store', 'class' => 'form', 'files'=>true, 'id'=>'f_registros')) }}
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

        <div class="row_2 @if ( $errors->has('grupo_id')) has-error @endif">
            {{ Form::label('grupo_id', 'Grupo:') }}
              {{ Form::select('grupo_id', $grupos_ls, Input::old('grupo_id'))  }}
            {{ $errors->first('grupo_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('norma_id')) has-error @endif">
            {{ Form::label('norma_id', 'Norma:') }}
            <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
            {{ Form::select('norma_id', $normas_ls, Input::old('norma_id'))  }}
            {{ $errors->first('norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('elemento_id')) has-error @endif">
            {{ Form::label('elemento_id', 'Elemento:') }}
            <div class="row_1"><div id='loading2' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
            {{ Form::select('elemento_id', $elementos_ls, Input::old('elemento_id'))  }}
            {{ $errors->first('elemento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_2 @if ( $errors->has('detalle')) has-error @endif">
            {{ Form::label('detalle', 'Detalle:') }}
              {{ Form::text('detalle', Input::old('detalle'), array('placeholder'=>'Detalle')) }}
            {{ $errors->first('detalle', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_registro')) has-error @endif">
            {{ Form::label('fec_registro', 'F. Registro:') }}
              {{ Form::text('fec_registro', Input::old('fec_registro'), array('placeholder'=>'Fec_registro', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_registro', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('aviso')) has-error @endif">
            {{ Form::label('aviso', 'Aviso:') }}
            {{ Form::select('aviso', $bnds_ls, Input::old('aviso'))  }}
            {{ $errors->first('aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias Aviso:') }}
              {{ Form::input('number', 'dias_aviso', Input::old('dias_aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_fin_vigencia')) has-error @endif">
            {{ Form::label('fec_fin_vigencia', 'F. Fin Vigencia:') }}
              {{ Form::text('fec_fin_vigencia', Input::old('fec_fin_vigencia'), array('placeholder'=>'Fec_fin_vigencia', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_fin_vigencia', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('archivo')) has-error @endif">
            {{ Form::label('archivo', 'Archivo:') }}
            {{ Form::file('file', array('id'=>'file')) }}  
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('s_registro.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
<script type="text/javascript">

    $(document).ready(function() { 
        cmbNormas();
        cmbElementos();
        $("#grupo_id").change(function(event) {
            cmbNormas();
        });
        $("#norma_id").change(function(event) {
            cmbElementos();
        });
    });

    function cmbNormas(){
        var a= $('#f_registros').serialize();
            $.ajax({
                url: '{{ route("s_registro.cmbNormas") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(registros){
                    $('select#norma_id').html('');
                    $('select#norma_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(registros, function(i) {
                        $('select#norma_id').append("<option "+registros[i].selectec+" value=\""+registros[i].id+"\">"+registros[i].norma+"<\/option>");
                    });
                }
            });
    }
    function cmbElementos(){
        var a= $('#f_registros').serialize();
            $.ajax({
                url: '{{ route("s_registro.cmbElementos") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(elementos){
                    $('select#elemento_id').html('');
                    $('select#elemento_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(elementos, function(i) {
                        $('select#elemento_id').append("<option "+elementos[i].selectec+" value=\""+elementos[i].id+"\">"+elementos[i].elemento+"<\/option>");
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


