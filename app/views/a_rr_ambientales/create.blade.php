@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'a_rr_ambientale.store', 'class' => 'form', 'id'=>'f_rr_ambientales', 'files'=>true)) }}
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

        <div class="row_1 @if ( $errors->has('material_id')) has-error @endif">
            {{ Form::label('material_id', 'Material:') }}
              {{ Form::select('material_id', $materiales_ls, Input::old('material_id'))  }}
            {{ $errors->first('material_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('categoria_id')) has-error @endif">
            {{ Form::label('categoria_id', 'Categoria:') }}
              <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
              {{ Form::select('categoria_id', $categorias_ls, Input::old('categoria_id'))  }}
            {{ $errors->first('categoria_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('documento_id')) has-error @endif">
            {{ Form::label('documento_id', 'Documento:') }}
            <div class="row_1"><div id='loading2' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
              {{ Form::select('documento_id', $documentos_ls, Input::old('documento_id'))  }}
            {{ $errors->first('documento_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('descripcion')) has-error @endif">
            {{ Form::label('descripcion', 'Descripcion:') }}
              {{ Form::text('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion')) }}
            {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('fec_fin_vigencia')) has-error @endif">
            {{ Form::label('fec_fin_vigencia', 'F. Fin Vigencia:') }}
              {{ Form::text('fec_fin_vigencia', Input::old('fec_fin_vigencia'), array('placeholder'=>'Fec_fin_vigencia', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'style'=>'width:85%')) }}
            {{ $errors->first('fec_fin_vigencia', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('archivo')) has-error @endif">
            {{ Form::label('archivo', 'Archivo:') }}
              {{ Form::file('file', array('id'=>'file')) }}
            {{ $errors->first('archivo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('aviso')) has-error @endif">
            {{ Form::label('aviso', 'Aviso:') }}
              {{ Form::select('aviso', $bnds_ls, Input::old('aviso_id'))  }}
            {{ $errors->first('aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('dias_aviso')) has-error @endif">
            {{ Form::label('dias_aviso', 'Dias_aviso:') }}
              {{ Form::input('number', 'dias_aviso', Input::old('dias_aviso')) }}
            {{ $errors->first('dias_aviso', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('responsable_id')) has-error @endif">
            {{ Form::label('responsable_id', 'Responsable:') }}
              {{ Form::select('responsable_id', $responsables_ls, Input::old('responsable_id'))  }}
            {{ $errors->first('responsable_id', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('a_rr_ambientale.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
<script type="text/javascript">

    $(document).ready(function() { 
        $("#material_id").change(function(event) {
            var a= $('#f_rr_ambientales').serialize();
            $.ajax({
                url: '{{ route("a_rr_ambientale.cmbCategorias") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(categorias){
                    $('select#categoria_id').html('');
                    $('select#categoria_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(categorias, function(i) {
                        $('select#categoria_id').append("<option "+categorias[i].selectec+" value=\""+categorias[i].id+"\">"+categorias[i].categoria+"<\/option>");
                    });
                }
            });
        });

        $("#categoria_id").change(function(event) {
            var a= $('#f_rr_ambientales').serialize();
            $.ajax({
                url: '{{  route("a_rr_ambientale.cmbDocumentos") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(documentos){
                    $('select#documento_id').html('');
                    $('select#documento_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(documentos, function(i) {
                        $('select#documento_id').append("<option "+documentos[i].selectec+" value=\""+documentos[i].id+"\">"+documentos[i].doc+"<\/option>");
                    });
                }
            });
        });
    });


         
    

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



