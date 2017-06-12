@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => array('rev_requisitos_ln.store', $rev_requisitos_id), 
                    'class' => 'form', 'id'=>'f_rev_requisitos_ln')) }}
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
        
        <div class="row @if ( $errors->has('impacto_id')) has-error @endif">
            {{ Form::label('impacto_id', 'Impacto:') }}
              {{ Form::select('impacto_id', $impactos_ls, Input::old('impacto_id'))  }}
            {{ $errors->first('impacto_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row @if ( $errors->has('condicion')) has-error @endif">
            {{ Form::label('condicion', 'Condicion:') }}
            <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
            {{ Form::select('condicion_id', $condiciones_ls, Input::old('condicion_id'),array('id'=>'condicion_id'))  }}
            {{ $errors->first('condicion', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('area_id')) has-error @endif">
            {{ Form::label('area_id', 'Area:') }}
              {{ Form::select('area_id', $areas_ls, Input::old('area_id'))  }}
            {{ $errors->first('area_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('norma')) has-error @endif">
            {{ Form::label('norma', 'Norma:') }}
              {{ Form::text('norma', Input::old('norma'), array('placeholder'=>'Norma')) }}
            {{ $errors->first('norma', '<div class="errorMessage">:message</div>') }}
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

        <div class="row @if ( $errors->has('observaciones')) has-error @endif">
            {{ Form::label('observaciones', 'Observaciones:') }}
              {{ Form::text('observaciones', Input::old('observaciones'), array('placeholder'=>'Observaciones')) }}
            {{ $errors->first('observaciones', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('rev_requisitos_ln.index', 'Cancelar', array('id'=>$rev_requisitos_id), array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
<script type="text/javascript">

    $(document).ready(function() { 
        $("#impacto_id").change(function(event) {
                cmbDoc();
            });
        });

    function cmbDoc(){
        var a= $('#f_rev_requisitos_ln').serialize();
        $.ajax({
            url: '{{ route("rev_requisitos_ln.cmbDoc") }}',
            type: 'POST',
            data: a, 
            dataType: 'json',
            beforeSend : function(){$("#loading1").show();},
            complete : function(){$("#loading1").hide();},
            success: function(condiciones){
                $('select#condicion_id').html('');
                $('select#condicion_id').append($('<option></option>').text('Seleccionar').val(''));
                $.each(condiciones, function(i) {
                    $('select#condicion_id').append("<option "+condiciones[i].selectec+" value=\""+condiciones[i].id+"\">"+condiciones[i].condicion+"<\/option>");
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

