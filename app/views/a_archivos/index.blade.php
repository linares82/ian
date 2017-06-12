@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('a_archivo.contentListIndex', null)}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">id</th>
				<th field="doc" sortable="true">Documento</th>
				<th field="descripcion" sortable="true">Descripción</th>
				<th field="archivo" sortable="true">Archivo</th>
				<th field="estatus" sortable="true">Estatus</th>
				<th field="fec_fin_vigencia" sortable="true">F. fin Vigencia</th>
				<th field="dias_restantes" sortable="true" styler="cellStyler1">Dias Restantes</th>
				<th field="dias_aviso" hidden="true">Dias Aviso</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('a_archivo-create')) 
		{{ link_to_route('a_archivo.create', 'Crear', null, array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('a_archivo-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('a_archivo-show')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('a_archivo-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('a_archivo-recover')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-recover" plain="true" onclick="recoverReg()">Recuperar</a>
		@endif
		<a href="#" class="easyui-menubutton" data-options="menu:'#mm1'">Estatus</a>
			<div id="mm1" style="width:150px;">
				@if (Sentry::getUser()->hasAccess('ln_dossier-comentarioEnProceso')) 
					<div data-options="iconCls:'icon-comentario'"><a href="#" onclick="stEnProceso()">En proceso</a></div>
				@endif	
				@if (Sentry::getUser()->hasAccess('ln_dossier-comentarioTerminado')) 
					<div data-options="iconCls:'icon-atendido'"><a href="#" onclick="stTerminado()">Terminado</a></div>
				@endif
				@if (Sentry::getUser()->hasAccess('ln_dossier-comentarioInactivo')) 
					<div data-options="iconCls:'icon-finalizado'"><a href="#" onclick="stInactivo()">Inactivo</a></div>
				@endif	
			</div>
		</div>
		
		<div>
			id: <input id="idbox" class="easyui-textbox" style="width:80px">
			Documento:{{ Form::select('documento_id', $documentos_ls, null, array('id'=>'documento_id'))  }}
			Estatus:{{ Form::select('estatus_id', $estatus_ls, null, array('id'=>'estatus_id'))  }}
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Buscar</a>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:700px;height:300px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
        {{ Form::open(array('route' =>'a_archivo.comentarioEstatus', 'class' => 'form', 'id'=>'estatus_form')) }}
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


		        <div class="ftitle">Comentario para el cambio de estatus</div><br/><br/>

		        <div class="row">
		              {{ Form::hidden('a_archivo_id', Input::old('a_archivo_id'), array('value'=>'0', 'id'=>'a_archivo_id')) }}
		        </div>

		        <div class="row">
		            {{ Form::label('comentario', 'Comentario:') }}
		            {{ Form::textArea('comentario', Input::old('comentario'), array('placeholder'=>'Comentario', 'rows'=>'3', 'style'=>'width:100%')) }}
		        </div>
		        <div class="row">
		            {{ Form::hidden('a_st_archivo_id', Input::old('a_st_archivo_id'), array('value'=>'0', 'id'=>'a_st_archivo_id')) }}
		        </div>

		        <div id="dlg-buttons">
					<div class="row_buttons">
					  <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSt()" style="width:90px">Save</a>
					  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
					</div>
				</div>
        {{ Form::close() }}
    </div>
@stop
@section('js_local')

<script type="text/javascript" src="{{ asset('jeasyui/datagrid-scrollview.js')}}"></script>

<script type="text/javascript">
	var url;
	var row;
	function stEnProceso(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Cambio Estatus: En proceso');
			$('#estatus_form').form('clear');
			$('#a_archivo_id').val(row.id);
			$('#a_st_archivo_id').val('2');
			url="{{ route('a_archivo.comentarioEstatus') }}";
		}else{
			alert("Seleccionar registro valido");
		}
	}
	function stTerminado(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Cambio Estatus: Terminado');
			$('#estatus_form').form('clear');
			$('#a_archivo_id').val(row.id);
			$('#a_st_archivo_id').val('3');
			url="{{ route('a_archivo.comentarioEstatus') }}";
		}else{
			alert("Seleccionar registro valido");
		}
	}
	function stInactivo(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Cambio Estatus: Inactivo');
			$('#estatus_form').form('clear');
			$('#a_archivo_id').val(row.id);
			$('#a_st_archivo_id').val('4');
			url="{{ route('a_archivo.comentarioEstatus') }}";
		}else{
			alert("Seleccionar registro valido");
		}
	}
	function saveSt(){
		var a=$('#estatus_form').serialize();
		$.ajax({
		    type:'post',
		    url:url,
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
	function showReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row && row.deleted_at==null){
				url="show/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function editReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row && row.deleted_at==null){
				url="edit/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function removeReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirmar','¿Estas seguro de eliminar este registro?',function(r){
					if (r){
						$.post('destroy/'+row.id,function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}else{
				alert("Seleccionar registro valido");
			}
		}
		
	function recoverReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirmar','¿Estas seguro de recuperar este registro?',function(r){
					if (r){
						$.post('recover/'+row.id,function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function doSearch(){
	    $('#dg').datagrid('load',{
		    id: $('#idbox').val(),
		    documento: $("select#documento_id option:selected").val(),
		    estatus: $("select#estatus_id option:selected").val()
	    });
    }

    function doLimpiar(){
	    $('#dg').datagrid('load',{
		    id: 0,
	    });
    }

    function cellStyler1(value,row,index){
		var d = new Date();
		var f1=new Date(d.getFullYear()+ "/" + (d.getMonth() + 1 ) + "/" + d.getDate());
		var f2 = new Date(row.fec_fin_vigencia);
		var r=f1-f2;
		r=((((r/1000)/60)/60)/24)*-1;
        if (parseInt(row.dias_restantes) > parseInt(row.dias_aviso)){
            return 'background-color:#088A08;color:white;';
        }else if(parseInt(row.dias_restantes)<=parseInt(row.dias_aviso) & parseInt(row.dias_restantes)>1){
        	 return 'background-color:#F7FE2E;color:black;';
        }else if(parseInt(row.dias_restantes)<=1){
        	return 'background-color:#ff0000;color:white;';
        }
    }

</script>

@stop
