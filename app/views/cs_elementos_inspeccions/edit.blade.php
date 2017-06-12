@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($cs_elementos_inspeccion, array('class' => 'form', 'method' => 'POST', 
'url' => 'cs_elementos_inspeccion/update/'.$cs_elementos_inspeccion->id, 'id'=>'f_elementos_inspeccion')) }}
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

        <div class="row_1 @if ( $errors->has('grupo_norma_id')) has-error @endif">
            {{ Form::label('grupo_norma_id', 'Grupo Norma:') }}
              {{ Form::select('grupo_norma_id', $grupo_normas_ls, Input::old('grupo_norma_id'))  }}
            {{ $errors->first('grupo_norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('norma_id')) has-error @endif">
            {{ Form::label('norma_id', 'Norma:') }}
            <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>
              {{ Form::select('norma_id', $normas_ls, Input::old('norma_id'))  }}
            {{ $errors->first('norma_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ( $errors->has('elemento')) has-error @endif">
            {{ Form::label('elemento', 'Elemento:') }}
              {{ Form::text('elemento', Input::old('elemento'), array('placeholder'=>'Elemento')) }}
            {{ $errors->first('elemento', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('cs_elementos_inspeccion.index', 'Cancelar', $cs_elementos_inspeccion->id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>

	</div>
</div>

{{ Form::close() }}

@stop
@section('js_local')
    
<script type="text/javascript">
    
     $(document).ready(function() { 
        cmbNormas();
        $("#grupo_norma_id").change(function(event) {
            cmbNormas();
        }); 
    });

     function cmbNormas(){
        var a= $('#f_elementos_inspeccion').serialize();
            $.ajax({
                url: '{{ route("cs_elementos_inspeccion.cmbNormas") }}',
                type: 'POST',
                data: a, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(normas){
                    $('select#norma_id').html('');
                    $('select#norma_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(normas, function(i) {
                        $('select#norma_id').append("<option "+normas[i].selectec+" value=\""+normas[i].id+"\">"+normas[i].norma+"<\/option>");
                    });
                }
            });
     }

</script>
@stop


