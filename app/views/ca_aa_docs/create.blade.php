@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::open(array('route' => 'ca_aa_doc.store', 'class' => 'form', 'id'=>'f_aa_doc')) }}
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

        <div class="row_1 @if ( $errors->has('doc')) has-error @endif">
            {{ Form::label('doc', 'Doc:') }}
              {{ Form::text('doc', Input::old('doc'), array('placeholder'=>'Doc')) }}
            {{ $errors->first('doc', '<div class="errorMessage">:message</div>') }}
        </div>

		<div class="row_buttons">
			  {{ Form::submit('Crear', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
			  {{ link_to_route('ca_aa_doc.index', 'Cancelar', $parameters=null, array('class' => 'easyui-linkbutton', 'style'=>'height:28px;width:100px;')) }}
		</div>
	</div>
</div>

{{ Form::close() }}

@stop

@section('js_local')
    
<script type="text/javascript">
    
     $(document).ready(function() { 
        $("#material_id").change(function(event) {
            var id = $("select#material_id option:selected").val(); 
            var a= $('#f_aa_doc').serialize();
            $.ajax({
                url: '{{  route("ca_aa_doc.cmbCategorias") }}',
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
    });


</script>
@stop


