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
    			<th> <font color="white">Id </font></th>
    			<th> <font color="white">Grupo </font></th>
                <th> <font color="white">Norma </font></th>
                <th> <font color="white">Elemento </font></th>
                <th> <font color="white">Detalle </font></th>
    			<th> <font color="white">F. Fin Vigencia </font></th>
    			<th> <font color="white">Estatus </font></th>
    			<th> <font color="white">Abreviatura </font></th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($rs as $r)
            @if($r['dias_restantes']<=$r['dias_aviso'])
    		<tr bgcolor="#A9BCF5"> 
    			<td> {{{ $r['id'] }}} </td>
                <td> {{{ $r['grupo_norma'] }}} </td>
                <td> {{{ $r['norma'] }}} </td>
                <td> {{{ $r['elemento'] }}} </td>
    			<td> {{{ $r['detalle'] }}} </td>
    			<td> {{{ $r['fec_fin_vigencia'] }}} </td>
    			<td> {{{ $r['estatus'] }}} </td>
    			<td> {{{ $r['abreviatura'] }}} </td>
    			</tr>
            @endif
    		@endforeach
    	</tbody>
    </table>
    </div>
</body>
</html>