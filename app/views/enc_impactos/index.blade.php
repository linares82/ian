@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('enc_impacto.contentListIndex', null)}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">Id</th>
				<th field="proyecto" sortable="true">Proyecto</th>
				<th field="cliente" sortable="true">Promovente</th>
				<th field="tipo_impacto" sortable="true">Tipo de Impacto</th>
				<th field="fecha_inicio" sortable="true">Fecha Inicio</th>
				<th field="fecha_fin" sortable="true">Fecha Fin</th>
				<th field="dias" sortable="true">Dias Transcurridos</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('enc_impacto-create')) 
		{{ link_to_route('enc_impacto.create', 'Crear', null, array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('enc_impacto-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('enc_impacto-show')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>
		@endif

		<a href="#" class="easyui-menubutton" data-options="menu:'#mm1',iconCls:'icon-pdf'">Tablas y Graficas</a>
		<div id="mm1" style="width:150px;">
			<div data-options="iconCls:'icon-pdf'">
				@if (Sentry::getUser()->hasAccess('enc_impacto-imprimir')) 
				<a href="#" class="easyui-linkbutton" iconCls="" plain="true" onclick="showImp()">R. Impacto</a>
				@endif
			</div>
			<div data-options="iconCls:'icon-chart_pie'">
				@if (Sentry::getUser()->hasAccess('enc_impacto-imprimir')) 
				<a href="#" class="easyui-linkbutton" iconCls="" plain="true" onclick="grfPie()">G. Pie</a>
				@endif
			</div>
			<div data-options="iconCls:'icon-chart_bar'">
				@if (Sentry::getUser()->hasAccess('enc_impacto-imprimir')) 
				<a href="#" class="easyui-linkbutton" iconCls="" plain="true" onclick="grfBarras()">G. Barras</a>
				@endif
			</div>
			<div data-options="iconCls:'icon-table'">
				@if (Sentry::getUser()->hasAccess('enc_impacto-imprimir')) 
				<a href="#" class="easyui-linkbutton" plain="true" onclick="showImp2()">M. Leopold</a>
				@endif
			</div>
		</div>

		
		
		@if (Sentry::getUser()->hasAccess('enc_impacto-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('enc_impacto-recover')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-recover" plain="true" onclick="recoverReg()">Recuperar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('enc_impacto-lineas')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-lineas" plain="true" onclick="lineas()">Lineas</a>
		@endif
		@if (Sentry::getUser()->hasAccess('enc_impacto-documentos')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-documentos" plain="true" onclick="documentos()">Documentos</a>
		@endif
		</div>
		<div>
			id: <input id="idbox" class="easyui-textbox" style="width:80px">
			Cliente: {{ Form::select('cliente_id', $clientes_ls , Input::old('cliente_id'),array('style'=>'width:200px;', 'id'=>'cliente_id')) }}
			Tipo de Impacto: {{ Form::select('tipo_impacto_id', $tipo_impactos_ls , Input::old('tipo_impacto_id'),array('style'=>'width:200px;', 'id'=>'tipo_impacto_id')) }}
			Fecha: {{ Form::text('fecha', Input::old('fecha'), array('placeholder'=>'Fecha', 'class'=>'easyui-datebox', 'data-options'=>'formatter:myformatter,parser:myparser', 'id'=>'fecha')) }}
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Buscar</a>
		</div>
	</div>
@stop
@section('js_local')

<script type="text/javascript" src="{{ asset('jeasyui/datagrid-scrollview.js')}}"></script>

<script type="text/javascript">
	function grfPie(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="grfPie/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function grfBarras(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="grfBarras/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function showImp2(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="imprimir2/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function showImp(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="imprimir/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
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
		   	cliente_id: $('#cliente_id').val(),
		    tipo_impacto_id: $('#tipo_impacto_id').val(),
		    fecha: $("input[name$='fecha']" ).val(),
	    });
    }

    function doLimpiar(){
	    $('#dg').datagrid('load',{
		    id: 0,
	    });
    }

    function lineas(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				//url="enc_impacto/lineas/"+row.id;
				url="{{url('enc_impacto/lineas/', $parameters = array(), $secure = null)}}"+"/"+row.id;
				/*$(location).attr('href',url);*/
				window.parent.addTab('Lineas: '+row.id, url);
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function documentos(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				//url="enc_impacto/documentos/"+row.id;
				url="{{url('enc_impacto/documentos/', $parameters = array(), $secure = null)}}"+"/"+row.id;
				/*$(location).attr('href',url);*/
				window.parent.addTab('Documentos: '+row.id, url);
			}else{
				alert("Seleccionar registro valido");
			}
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
