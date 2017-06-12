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
    			<th> <font color="white">No Conformidad </font></th>
    			<th> <font color="white">Fecha </font></th>
    			<th> <font color="white">F. Planeada </font></th>
    			<th> <font color="white">Area </font></th>
    			<th> <font color="white">Estatus </font></th>
    			<th> <font color="white">Entidad </font></th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($rs as $r)
            @if($r['dias_restantes']<=$r['dias_aviso'])
    		<tr bgcolor="#A9BCF5"> 
    			<td> {{{ $r['id'] }}} </td>
                <td> {{{ $r['no_conformidad'] }}} </td>
    			<td> {{{ $r['fecha'] }}} </td>
    			<td> {{{ $r['fec_planeada'] }}} </td>
    			<td> {{{ $r['area'] }}} </td>
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