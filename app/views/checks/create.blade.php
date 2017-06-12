@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'check.store', 'class' => 'form', 'id'=>'f_check')) }}
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

        <div class="row_1 @if ($errors->has('cliente')) has-error @endif">
            {{ Form::label('cliente', 'Cliente:') }}            
              {{ Form::select('cliente', $clientes_ls, Input::old('cliente'))  }}
            {{ $errors->first('cliente', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('a_chequeo')) has-error @endif">
            {{ Form::label('a_chequeo', 'Aarea de chequeo:') }}
              {{ Form::select('a_chequeo', $areas_ls, Input::old('a_chequeo'))  }}
            {{ $errors->first('a_chequeo', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('solicitud')) has-error @endif">
            {{ Form::label('solicitud', 'Solicitud:') }}
              {{ Form::text('solicitud', Input::old('solicitud'), array('placeholder'=>'Solicitud')) }}
            {{ $errors->first('colicitud', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('detalle')) has-error @endif">
            {{ Form::label('detalle', 'Detalle:') }}
              {{ Form::text('detalle', Input::old('detalle'), array('placeholder'=>'Detalle')) }}
            {{ $errors->first('detalle', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('fec_apertura')) has-error @endif">
            {{ Form::label('fec_apertura', 'F. Apertura:') }}
              {{ Form::text('fec_apertura', Input::old('fec_apertura'), array('placeholder'=>'F. Apertura', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'id'=>'fec_apertura')) }}
            {{ $errors->first('fec_apertura', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('fec_cierre')) has-error @endif">
            {{ Form::label('fec_cierre', 'F. Cierre:') }}
              {{ Form::text('fec_cierre', Input::old('fec_cierre'), array('placeholder'=>'F. Cierre', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'id'=>'fec_cierre')) }}
            {{ $errors->first('fec_cierre', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row" style="clear:left;width:92%">
            {{ Form::label('normas', 'Normas:') }}
            <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
            {{ Form::select('normas[]', $normas_ls, array('',''), array('multiple'=>True, 
            'id'=>'normas', 'style'=>'width:90%'), Input::old('normas[]')) }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('check.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop

@section('js_local')
    <link href="{{ asset('select2-3.5.1/select2.css') }}" rel="stylesheet"/>
    <script type="text/javascript" src="{{ asset('select2-3.5.1/select2.js') }} "></script>
    
<script type="text/javascript">
     $(document).ready(function() { $("#normas").select2({placeholder: "Selecionar opcion"}); });

     $(document).ready(function() { 
        $("#a_chequeo").change(function(event) {
            var id = $("select#a_chequeo option:selected").val(); 
            var a= $('#f_check').serialize();
            $.ajax({
                url: '{{  route("check.cmbNormas") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(norma){
                    $('select#normas').html('');
                    $('select#normas').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(norma, function(i) {
                        $('select#normas').append("<option "+norma[i].selectec+" value=\""+norma[i].norma_id+"\">"+norma[i].norma+"<\/option>");
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

