<!DOCTYPE html>
<html>
<head>
    <title>Aviso del sistema SIAM</title>
</head>
<body>
    <h3>Aviso del sistema SIAM</h3>
    <p>Buen dia, la siguiente tabla contiene información de retrazos.</p>
    <p>Responsable: {{$nombre}}</p>
    
   	<div class="datagrid">
    <table  border="0" cellspacing=1 cellpadding=2 bordercolor="#013ADF">
    	<thead>
    		<tr bgcolor="#013ADF">
    			<th> <font color="white">Entidad </font></th>
                <th> <font color="white">Mes </font></th>
                <th> <font color="white">Año </font></th>
                <th> <font color="white">T. Documento </font></th>
    			<th> <font color="white">Documento </font></th>
                <th> <font color="white">Importancia </font></th>
                <th> <font color="white">Estatus </font></th>
    			<th> <font color="white">Dias restantes </font></th>
                <th> <font color="white">F. Cumplimiento </font></th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($rs as $r)
            @if($r['dias_restantes']<=$r['dias_advertencia1'])
    		<tr bgcolor="#A9BCF5"> 
    			<td> {{{ $r['abreviatura'] }}} </td>
                <td> {{{ $r['mes'] }}} </td>
    			<td> {{{ $r['anio'] }}} </td>
    			<td> {{{ $r['tpo_doc'] }}} </td>
                <td> {{{ $r['documento'] }}} </td>
    			<td> {{{ $r['importancia'] }}} </td>
                <td> {{{ $r['estatus'] }}} </td>
    			<td> {{{ $r['dias_restantes'] }}} </td>
                <td> {{{ $r['fec_cumplimiento'] }}} </td>
    			</tr>
            @endif
    		@endforeach
    	</tbody>
    </table>
    </div>
</body>
</html>