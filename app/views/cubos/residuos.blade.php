@extends('layouts.tabs')

@section('contenido_tab')

<link rel="stylesheet" type="text/css" href="{{ asset('dist/pivot.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('dist/c3.min.css') }} ">
<script type="text/javascript" src="{{ asset('jeasyui/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/d3.v3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/c3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/pivot.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/pivot.es.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/c3_renderers.js') }}"></script>

<style type="text/css">
@media print {
  body  {
    visibility: hidden;
  }
  #output  {
    visibility: visible;
  }
  #output  {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>

<script type="text/javascript">
            
            $(function(){
                var derivers = $.pivotUtilities.derivers;
                var renderers = $.extend($.pivotUtilities.renderers, 
                              $.pivotUtilities.c3_renderers);

                $("#output").pivotUI({{$consulta}}, {
                    renderers: renderers,
                    cols: ["Año", "Mes"], 
                    rows: ["Entidad", "Residuo"],
                    rendererName: "Grafica Barras C3"
                }, false, "es");
                
             });
        </script>

<div id="output" style="padding:30px;width:80%"></div>

@stop
@section('js_local')
<script type="text/javascript" src="{{ asset('jeasyui/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/d3.v3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/c3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/pivot.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/pivot.es.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/c3_renderers.js') }}"></script>

@stop

