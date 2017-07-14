<!DOCTYPE html>
<html>
<head>
    <title>Aviso del sistema SIAM</title>
</head>
<body>
    <h3>Aviso del sistema SIAM</h3>
    <p>Buen dia, la siguiente tabla contiene información avisos.</p>
    <p>Responsable: {{$nombre}}</p>
    
   	<div class="datagrid">
    <table  border="0" cellspacing=1 cellpadding=2 bordercolor="#013ADF">
    	<thead>
    		<tr bgcolor="#013ADF">
    			<th> <font color="white">Id </font></th>
    			<th> <font color="white">No. Orden </font></th>
                <th> <font color="white">Tipo Mantenimiento </font></th>
                <th> <font color="white">Equipo </font></th>
    			<th> <font color="white">Subequipo </font></th>
    			<th> <font color="white">Solicitante </font></th>
    			<th> <font color="white">Fecha Planeda </font></th>
    			<th> <font color="white">Dias Restantes </font></th>
                <th> <font color="white">Estatus </font></th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($rs as $r)
            @if($r['dias_restantes']<=$r['dias_aviso'])
    		<tr bgcolor="#A9BCF5"> 
    			<td> {{{ $r['id'] }}} </td>
                <td> {{{ $r['no_orden'] }}} </td>
                <td> {{{ $r['tpo_manto'] }}} </td>
                <td> {{{ $r['objetivo'] }}} </td>
    			<td> {{{ $r['subequipo'] }}} </td>
    			<td> {{{ $r['nombre'] }}} </td>
    			<td> {{{ $r['fec_planeada'] }}} </td>
    			<td> {{{ $r['dias_restantes'] }}} </td>
                <td> {{{ $r['estatus'] }}} </td>
    			</tr>
            @endif
    		@endforeach
    	</tbody>
    </table>
    </div>
</body>
</html>