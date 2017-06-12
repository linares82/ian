<!DOCTYPE html>
<html>
<head>
    <title>Aviso del sistema SIAM</title>
</head>
<body>
    <h3>Aviso del sistema SIAM</h3>
    <p>Buen dia, la siguiente tabla contiene información de retrazos en captura en la bitacora de Consumibles.</p>
    <p>Responsable: {{$resp}}</p>    
   	<div class="datagrid">
    <table  border="0" cellspacing=1 cellpadding=2 bordercolor="#013ADF">
    	<thead>
    		<tr bgcolor="#013ADF">
    			<th> <font color="white">Entidad </font></th>
    			<th> <font color="white">Consumible </font></th>
                <th> <font color="white">Fecha </font></th>
                <th> <font color="white">Dias Sin Capturar </font></th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($rs as $r)
            @if($r['dias']>=$dias_plazo)
    		<tr bgcolor="#A9BCF5"> 
    			<td> {{{ $r['abreviatura'] }}} </td>
                <td> {{{ $r['consumible'] }}} </td>
                <td> {{{ $r['fecha'] }}} </td>
                <td> {{{ $r['dias'] }}} </td>
    			</tr>
            @endif
    		@endforeach
    	</tbody>
    </table>
    </div>
</body>
</html>