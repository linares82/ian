@extends('layouts.tabs')

@section('contenido_tab')

{{ Form::model($reg_impacto, array('class' => 'form', 'method' => 'PUT', 'url' => 'reg_impacto/update/'.$reg_impacto->id)) }}
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

        <div class="row_1 @if ($errors->has('factor_id')) has-error @endif">
            {{ Form::label('factor_id', 'Factor:') }}
            {{ Form::select('factor_id', $factor_ls, Input::old('factor_id'))  }}
            {{ $errors->first('factor_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1"><div id='loading1' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>

        <div class="row_1 @if ($errors->has('factor_id')) has-error @endif">
            {{ Form::label('rubro_id', 'Rubro:') }}
            {{ Form::select('rubro_id', $rubro_ls, Input::old('rubro_id'))  }}
            {{ $errors->first('rubro_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1"><div id='loading2' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>

        <div class="row_1 @if ($errors->has('especifico_id')) has-error @endif">
            {{ Form::label('especifico_id', 'Especifico:') }}
            {{ Form::select('especifico_id', $especifico_ls, Input::old('especifico_id'))  }}
            {{ $errors->first('especifico_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <div class="row_1 @if ($errors->has('estatus_id')) has-error @endif">
            {{ Form::label('estatus_id', 'Estatus:') }}
            {{ Form::select('estatus_id', $estatus_ls, Input::old('Estatus'))  }}
            {{ $errors->first('estatus_id', '<div class="errorMessage">:message</div>') }}
        </div>

        <table id="dg" class="easyui-datagrid" title="Caracteristicas" style="width:92%;height:auto"
                toolbar="#toolbar" data-options="pageList:[11,22,44], singleSelect:true, rownumbers:true,
                url:'{{ route('reg_impacto.contentListLn', array('id_ln'=>$reg_impacto->id)) }}',autoRowHeight:false,pageSize:11, 
                pagination:true, collapsible:true"
                fit="false" fitColumns="true" >
            <thead>
                <tr>
                    <th field="id" sortable="true" hidden="true">id</th>
                    <th field="reg_impacto_id" sortable="true" hidden="true">reg_impacto_id</th>
                    <th field="caracteristica_id" sortable="true" hidden="true">caracteristica_id</th>
                    <th field="caracteristica" sortable="true">Caracteristica</th>
                    <th field="efecto_id" sortable="true" hidden="true">efecto_id</th>
                    <th field="efecto" sortable="true" hidden="true">Efecto</th>
                    <th field="desc_efecto" sortable="true">Descripción</th>
                    <th field="imp_potencial" sortable="true" >I. Potencial</th>
                    <th field="imp_real" sortable="true" >I. Real</th>
                    <th field="descripcion" sortable="true" hidden="true">Descripción</th>
                    <th field="resarcion" sortable="true" hidden="true">Resarción</th>
                    <th field="emision_efecto_id" sortable="true" hidden="true">emision_efecto_id</th>
                    <th field="duracion_accion_id" sortable="true" hidden="true">duracion_accion_id</th>
                    <th field="continuidad_efecto_id" sortable="true" hidden="true">continuidad_efecto_id</th>
                    <th field="reversinbilidad_id" sortable="true" hidden="true">reversibilidad_id</th>
                    <th field="probabilidad_id" sortable="true" hidden="true">probabilidad_id</th>
                    <th field="mitigacion_id" sortable="true" hidden="true">mitigacion_id</th>
                    <th field="intensidad_impacto_id" sortable="true" hidden="true">intensidad_impacto_id</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <div>
            @if (Sentry::getUser()->hasAccess('ln_caracteristica-edit')) 
            <a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editLn()">Editar</a>
            @endif
            </div>
        </div>

        <div class="row_buttons">
          {{ Form::submit('Actualizar', array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
          {{ link_to_route('reg_impacto.index', 'Cancelar', array('id'=>$reg_impacto->enc_impacto_id), array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')) }}
        </div>
        

	</div>
</div>
{{ Form::close() }}
<!--/////////////////////////////////////Linea de caracteristica/////////////////////////////////-->
        <div id="dlg" class="easyui-dialog" style="width:700px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
        {{ Form::open(array('route' =>'reg_impacto.updateLn', 'class' => 'form', 'id'=>'ln_form')) }}
                <div class="row_2">
                      {{ Form::hidden('id', Input::old('id'), array('value'=>'0', 'id'=>'id')) }}
                </div>

                <div class="row_2">
                      {{ Form::hidden('reg_impacto_id', Input::old('reg_impacto_id'), array('value'=>'0', 'id'=>'reg_impacto_id')) }}
                </div>

                <div class="row_2">
                    {{ Form::hidden('caracteristica_id', Input::old('caracteristica_id'), array('value'=>'0', 'id'=>'caracteristica_id')) }}
                </div>

                <div class="row_2"><div id='loading3' style='display: none'><img src="{{ asset('img/ajax-loader.gif') }}" title="Loading" /></div> </div>

                <div class="row" style="clear:left">
                    {{ Form::label('efecto_id', 'Ponderación del Impacto:') }}
                    {{ Form::select('efecto_id', $efecto_ls, array('id'=>'efecto_id'))  }}
                    {{ Form::hidden('desc_efecto', Input::old('desc_efecto'), array('placeholder'=>'Descripcion', 'id'=>'desc_efecto', 'style'=>'width:100%')) }}
                </div>
                
                <div class="row_2 @if ($errors->has('descripcion')) has-error @endif" style="clear:left">
                    {{ Form::label('descripcion', 'Descripción del Impacto:') }}
                    {{ Form::textArea('descripcion', Input::old('descripcion'), array('placeholder'=>'Descripcion', 'rows'=>'3', 'style'=>'width:100%')) }}
                    {{ $errors->first('descripcion', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('resarcion')) has-error @endif">
                    {{ Form::label('resarcion', 'Medida de Resarción:') }}
                      {{ Form::textArea('resarcion', Input::old('resarcion'), array('placeholder'=>'Resarcion', 'rows'=>'3', 'style'=>'width:100%')) }}
                    {{ $errors->first('resarcion', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('emision_efecto_id')) has-error @endif">
                    {{ Form::label('emision_efecto_id', 'Emision del Efecto:') }}
                    {{ Form::select('emision_efecto_id', $emision_efecto_ls, Input::old('emision_efecto_id'), array())  }}
                    {{ $errors->first('emision_efecto_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('duracion_accion_id')) has-error @endif">
                    {{ Form::label('duracion_accion_id', 'Duracion de la Acción:') }}
                    {{ Form::select('duracion_accion_id', $duracion_accion_ls, Input::old('duracion_accion_id'))  }}
                    {{ $errors->first('duracion_accion_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('continuidad_efecto_id')) has-error @endif" style="clear:left">
                    {{ Form::label('continuidad_efecto_id', 'Continuidad del Efecto:') }}
                    {{ Form::select('continuidad_efecto_id', $continuidad_efecto_ls, Input::old('continuidad_efecto_id'))  }}
                    {{ $errors->first('continuidad_efecto_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('reversibilidad_id')) has-error @endif">
                    {{ Form::label('reversibilidad_id', 'Reversibilidad:') }}
                    {{ Form::select('reversibilidad_id', $reversibilidad_ls, Input::old('reversibilidad_id'))  }}
                    {{ $errors->first('reversibilidad_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('probabilidad_id')) has-error @endif" style="clear:left">
                    {{ Form::label('probabilidad_id', 'Probabilidad:') }}
                    {{ Form::select('probabilidad_id', $probabilidad_ls, Input::old('probabilidad_id'))  }}
                    {{ $errors->first('probabilidad_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('mitigacion_id')) has-error @endif">
                    {{ Form::label('mitigacion_id', 'Suceptibilidad de mitigacion:') }}
                    {{ Form::select('mitigacion_id', $mitigacion_ls, Input::old('mitigacion_id'))  }}
                    {{ $errors->first('mitigacion_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div class="row_2 @if ($errors->has('intensidad_impacto_id')) has-error @endif">
                    {{ Form::label('intensidad_impacto_id', 'Intensidad de impacto:') }}
                    {{ Form::select('intensidad_impacto_id', $intensidad_impacto_ls, Input::old('intensidad_impacto_id'))  }}
                    {{ $errors->first('intensidad_impacto_id', '<div class="errorMessage">:message</div>') }}
                </div>

                <div id="dlg-buttons">
                    <div class="row_buttons">
                      <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveLn()" style="width:90px">Save</a>
                      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
                    </div>
                </div>

        {{ Form::close() }}
        </div>

<!--/////////////////////////////////////Linea de caracteristica/////////////////////////////////-->
@stop
@section('js_local')

<script "type/javascript">
    var url;
    var row;

    function editLn(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#ln_form').form('clear');
            $('#id').val(row.id);
            $('#reg_impacto_id').val(row.reg_impacto_id);
            $('#caracteristica_id').val(row.caracteristica_id);
            $("#rubro_id option:selected").val()
            $('#efecto_id').val(row.efecto_id); 
            $('#desc_efecto').val(row.efecto);
            $('#descripcion').val(row.descripcion);
            $('#resarcion').val(row.resarcion);
            $('#emision_efecto_id').prop("selectedIndex", row.emision_efecto_id); 
            $('#duracion_accion_id').prop("selectedIndex", row.duracion_accion_id); 
            $('#continuidad_efecto_id').prop("selectedIndex", row.continuidad_efecto_id); 
            $('#reversibilidad_id').prop("selectedIndex", row.reversibilidad_id); 
            $('#probabilidad_id').prop("selectedIndex", row.probabilidad_id); 
            $('#mitigacion_id').prop("selectedIndex", row.mitigacion_id); 
            $('#intensidad_impacto_id').prop("selectedIndex", row.intensidad_impacto_id); 
            $('#dlg').dialog('open').dialog('setTitle','Actualizar');
            url='updateLn';
        }else{
            alert("Seleccionar registro valido");
        }
    }
    function saveLn(){
        var a=$('#ln_form').serialize();
        $.ajax({
            type:'post',
            url:"{{ route('reg_impacto.updateLn') }}",
            data:a,
            success:function(result){
                 $('#dlg').dialog('close'); // close the dialog
                 $('#dg').datagrid('reload'); // reload the user data
            },
            error: function(){
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                    });
            }
        });
    }
    jQuery(document).ready(function() {
        $("#factor_id").change(function(event) {
            var id = $("#factor_id option:selected").val(); 
            $.ajax({
                url: 'cmbRubro/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading1").show();},
                complete : function(){$("#loading1").hide();},
                success: function(rubro){
                    $('select#rubro_id').html('');
                    $('select#rubro_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(rubro, function(i) {
                        $('select#rubro_id').append("<option value=\""+rubro[i].id+"\">"+rubro[i].rubro+"<\/option>");
                    });
                }
            });
        });
        
        $("#rubro_id").change(function(event) {
            var id = $("#rubro_id option:selected").val(); 
            $.ajax({
                url: 'cmbEspecifico/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading2").show();},
                complete : function(){$("#loading2").hide();},
                success: function(especifico){
                    $('select#especifico_id').html('');
                    $('select#especifico_id').append($('<option></option>').text('Seleccionar').val(''));
                    $.each(especifico, function(i) {
                        $('select#especifico_id').append("<option value=\""+especifico[i].id+"\">"+especifico[i].especifico+"<\/option>");
                    });
                }
            });
        });

        $("select#efecto_id").change(function(event) {
            //var id = $("#efecto_id option:selected").val();         
            var id = $("select#efecto_id option:selected").val(); 
            $.ajax({
                url: 'descEfecto/'+id,
                type: 'POST',
                data: 'id='+id, 
                dataType: 'json',
                beforeSend : function(){$("#loading3").show();},
                complete : function(){$("#loading3").hide();},
                success: function(especifico){
                    $('html > body > div.panel.window > div#dlg.easyui-dialog.panel-body.panel-body-noborder.window-body > form#ln_form.form > div.row > #desc_efecto').val('');
                    $('#desc_efecto').val(especifico.efecto);
                }
            });
        });
    });
</script>

@stop


