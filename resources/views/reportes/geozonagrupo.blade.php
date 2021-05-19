@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('reportesgeozonagrupo-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Reportes Grupo</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Reportes Grupo</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                          <div class="row">
                              <div class="col-lg-4">
                                    <div class="card text-center">
                                        <div class="card-header bg-primary">
                                        Localizacion
                                        </div>
                                        <div class="card-body">
                                            <div id="map" style="height:300px;">
                                            </div>
                                                <br>
                                                <br>
                                            <div id="map2" style="height:300px;">
                                            </div>
                                        </div>
                                    </div>
                              </div>
                              <div class="col-lg-8">
                                <div class="card text-center">
                                    <div class="card-header bg-primary">
                                      Movimientos
                                    </div>
                                    <div class="card-body">
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                   <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name="datetimes" id="datetimes" class="form-control"/>
                                                    </div>
                                                </div>



                                                <!--<div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Fecha de Inicio</label></div>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" id="fecha" name="fecha"  class="form-control"  >
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Hora Inicio</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hinicio" name="hinicio" readonly>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Hora final</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hfinal" name="hfinal" readonly >
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Fecha Final</label></div>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" id="fecha" name="fecha"  class="form-control"  >
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Hora Inicio</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hinicio" name="hinicio" readonly>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Hora final</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hfinal" name="hfinal" readonly >
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>-->
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-3 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Empresa</label></div>
                                                    <select class="select2_form form-control" style="text-transform: uppercase; width:100%" name="empresa" id="empresa">
                                                        <option></option>
                                                        @foreach (empresas() as $empresa)
                                                        <option value="{{$empresa->id}}" >{{$empresa->nombre_comercial}}</option>
                                                        @endforeach
                                                     </select>
                                                </div>
                                                <div class="col-lg-3 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Cliente</label></div>
                                                    <select class="select2_form form-control" style="text-transform: uppercase; width:100%" name="cliente" id="cliente" >
                                                        <option></option>
                                                        @foreach (clientes() as $cliente)
                                                        <option value="{{$cliente->id}}" >{{$cliente->nombre}}</option>
                                                        @endforeach
                                                     </select>
                                                </div>
                                                 <div class="col-lg-3">
                                                    <div style="text-align:left;"><label class="required" >Kilometraje</label></div>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="kilometraje" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button id="btn_reporte" class="btn btn-block btn-w-m btn-primary m-t-md" onclick="consultar()">
                                                        <i class="fa fa-plus-square"></i>Consultar
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <form action="{{route('reportes.movimientopdf')}}" method="POST" id="frm_pdf">
                                                        @csrf
                                                       <!-- <button  type="button" id="btn_reporte_pdf" class="btn btn-block btn-w-m btn-primary m-t-md" onclick="descargarpdf()">
                                                            <i class="fa fa-file-pdf-o"></i>PDF
                                                        </button>-->
                                                        <input type="hidden" id="arreglo_reporte" name="arreglo_reporte">
                                                        <input type="hidden" id="fecha_reporte" name="fecha_reporte">
                                                        <input type="hidden" id="hinicio_reporte" name="hinicio_reporte">
                                                        <input type="hidden" id="hfinal_reporte" name="hfinal_reporte">
                                                        <input type="hidden" id="dispositivo_reporte" name="dispositivo_reporte">
                                                    </form>
                                                </div>

                                                <div class="col-lg-3" >
                                                    <div  id="cargando"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table dataTables-reporte table-striped table-bordered table-hover"  style="text-transform:uppercase">
                                                    <thead>
                                                        <tr> <th>Latitud</th>
							                                 <th>Longitud</th>
                                                             <th class="text-center">Velocidad</th>
                                                             <th class="text-center">fecha</th>
							                                 <th>Opciones</th>
                                                            </tr>
                                                    </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@push('styles')
    <!-- DataTable -->
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <style>
    .loader {
  border: 13px solid #f3f3f3;
  border-radius: 50%;
  border-top: 13px solid #3498db;
  margin:20px 0px 0px 0px;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- DataTable -->
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('Inspinia/js/plugins/clockpicker/clockpicker.js') }}" ></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <script>
        $(function() {
  $('input[name="datetimes"]').daterangepicker({
    "timePicker": true,
    "timePicker24Hour": true,
    "showDropdowns": true,

    locale: {
      format: 'Y/M/DD H:mm'
    }
  });
});
    var map;
	var map2;
	var markers=[];
    var markers_ruta=[];
	var polylines=[];
    var datos=[];
    var pdf=[];
    function descargarpdf()
    {
        if(pdf.length==0)
        {
            toastr.error('No hay datos para generar reporte','Error');
        }
        else{
             $('#arreglo_reporte').val(JSON.stringify(pdf));
            $('#fecha_reporte').val($('#fecha').val());
            $('#hinicio_reporte').val($('#hinicio').val());
            $('#hfinal_reporte').val($('#hfinal').val());
            $('#dispositivo_reporte').val($('#dispositivo').val());
            document.getElementById('frm_pdf').submit();


        }
    }
         function initMap() {
                  map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: { lat: -8.1092027, lng: -79.0244529 },
                gestureHandling: "greedy",
                mapTypeControl: false,
                fullscreenControl: false
            });
	map2= new google.maps.Map(document.getElementById("map2"), {
        zoom: 12,
        center: { lat: -8.1092027, lng: -79.0244529 },
        gestureHandling: "greedy",
        mapTypeControl: false,
        fullscreenControl: false
      });
         }
           $(document).ready(function() {

                $(".select2_form").select2({
                    placeholder: "SELECCIONAR",
                    allowClear: true,
                    height: '200px',
                    width: '100%',
                });
                /*
                $('.input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    language: 'es',
                    format: "yyyy/mm/dd"
                });*/
                $('.clockpicker').clockpicker();
                $('.dataTables-reporte').DataTable({
                    "dom": '<"html5buttons"B>lTfgitp',
                "buttons": [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'Reporte de movimiento',
                        exportOptions: {
                            columns:  [ 0,1,2, 3]
                        }
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PdF',
                        title: 'Reporte de movimiento',
                        exportOptions: {
                            columns:  [ 0,1,2, 3]
                        }
                    }
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [
		    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
		    {
                        "targets": [1],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [2],
                    },
                    {
                        "targets": [3],
                    },
                    {
                        searchable: false,
                        "targets": [4],
                        data: null,
                        render: function(data, type, row) {
                                return  "<div class='btn-group'>" +
                                        "<a class='btn btn-sm btn-warning btn-ubicacion' style='color:white'>"+ "<i class='fa fa-location-arrow'></i>"+"</a>" +
                                        "</div>";
                        }
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [
                     { sWidth: '0%' },
	            { sWidth: '0%' },
                    { sWidth: '30%', sClass: 'text-center' },
                    { sWidth: '30%', sClass: 'text-center' },
		    { sWidth: '0%' },
              ],
                "language": {
                    url: "{{asset('Spanish.json')}}"
                },
                "order": [[ 0, "desc" ]],
            });
            });
         function consultar()
         {

            var fecha=$("#datetimes").val().split(" - ");
            var fechainicio=fecha[0];
            var fechafinal=fecha[1];
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1); //January is 0!
                var yyyy = today.getFullYear();

               var  fechanow= yyyy + '/' + mm + '/' + dd;
            var enviar=true;
            var fecha = $("#fecha").val();
            var empresa=$("#empresa").val();
            var cliente=$("#cliente").val();

            if (!(empresa.length != 0 && cliente.length != 0))
            {
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                enviar= false;
            }

            if(enviar==true)
            {
                    datos=[];
                    setMapOnAll(null);
                    setMapOnAll_ruta(null);
                    $("#cargando").addClass("loader");
                    //console.log("lleg");
                    $.ajax({
                        dataType : 'json',
                        type     : 'GET',
                        timeout: 7200000,
                        url : '{{ route('reportes.dispositivogeozonagrupo') }}',
                        data : {
                            '_token' : $('input[name=_token]').val(),
                            'empresa': empresa,
                            'cliente':cliente,

                            'fechainicio': fechainicio,
                            'fechafinal' : fechafinal,
                            'fechanow' : fechanow
                        },

            }).done(function (returnValue){
              //console.log(result);
              agregar(returnValue);



            });

            }
         }
         function marker_ruta(arregloruta)
         {
        var marker = new google.maps.Marker({ position: new google.maps.LatLng(parseFloat(arregloruta[0][0]),
            parseFloat(arregloruta[0][1])),
         map: map2,
          });
	      markers_ruta.push(marker);
          marker.setMap(map2);
          const image1 ={
                    url:"http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                    // This marker is 20 pixels wide by 32 pixels high.
                    scaledSize: new google.maps.Size(50, 50),
                    };
        var marker1 = new google.maps.Marker({ position: new google.maps.LatLng(arregloruta[arregloruta.length-1][0],
            arregloruta[arregloruta.length-1][1]),
         map: map2,
         icon:image1
          });
          markers_ruta.push(marker1);
          marker1.setMap(map2);
          map2.setZoom(15);
          if(((arregloruta.length)%2)==0)
          {
              //console.log((arregloruta.length)/2);
        map2.setCenter(new google.maps.LatLng(arregloruta[(arregloruta.length)/2][0],
            arregloruta[(arregloruta.length)/2][1]));
          }
          else
          {
            map2.setCenter(new google.maps.LatLng(arregloruta[(((arregloruta.length)/2)+0.5)][0],
            arregloruta[(((arregloruta.length)/2)+0.5)][1]));
          }
         }
     function agregar(returnValue)
     {
        // pdf=returnValue;
        $("#cargando").removeClass("loader");
        var t = $('.dataTables-reporte').DataTable();
                                    t.clear().draw();
                                    var arregloruta=[];
                                    var kmre=0;
                                for(var i=0;i<returnValue.length;i++)
                                {
                                    var cadena = returnValue[i].cadena.split(',');
                                            var  latlng=[];
                                    latlng.push(returnValue[i].lat);
                                    latlng.push(returnValue[i].lng);
                                    arregloruta.push(latlng);
                                    var  velocidad=cadena != "" ? ((parseFloat(cadena[11])*1.15078)*1.61) : 0;
                                    datos.push({"lat":returnValue[i].lat,"lng":returnValue[i].lng,"velocidad":velocidad.toFixed(2),"direccion":"Sin Direccion","fecha":returnValue[i].fecha});
                                    t.row.add([
                                        returnValue[i].lat,
                                        returnValue[i].lng,
                                        velocidad.toFixed(2)+"km/h",
                                            returnValue[i].fecha,
                                            '',
                                        ]).draw(false);
                                        if(i!=returnValue.length-1)
                                         {
                                            kmre =kmre+ google.maps.geometry.spherical.computeDistanceBetween( new google.maps.LatLng(returnValue[i].lat,  returnValue[i].lng), new google.maps.LatLng(returnValue[i+1].lat,  returnValue[i+1].lng));
                                         }

                                         var fila={"lat":returnValue[i].lat,"lng":returnValue[i].lng,"velocidad":velocidad.toFixed(2)+"km/h","fecha":returnValue[i].fecha};
                                         pdf.push(fila);
                                }
                                $("#kilometraje").val((kmre/1000).toFixed(3));
                                eliminaruta(null);
                                addPolyline (arregloruta);
                                 marker_ruta(arregloruta)
     }
	 function data(dispositivo,fechainicio,fechafinal,datos)
	 {

        $.ajax({
                        dataType : 'json',
                        type : 'POST',
                        async:false,
                        timeout: 7200000,
                        url : '{{ route('reportes.data') }}',
                        data : {
                            '_token' : $('input[name=_token]').val(),
                            'dispositivo': dispositivo,
                            'fechainicio': fechainicio,
                            'fechafinal' : fechafinal
                        },
                        success: datos
                    });
	 }
	 $(document).on('click', '.btn-ubicacion', function(event) {
	 setMapOnAll(null);
		var table = $('.dataTables-reporte').DataTable();
            var data = table.row($(this).parents('tr')).data();
		const image ={
                    url: window.location.origin +"/img/gps.png",
                    // This marker is 20 pixels wide by 32 pixels high.
                    scaledSize: new google.maps.Size(50, 50),
                    // The origin for this image is (0, 0).
                    };
        var marker = new google.maps.Marker({ position: new google.maps.LatLng(data[0],
          data[1]),
         map: map,
         icon: image,
          });
	      markers.push(marker);
          marker.setMap(map);
          map.setZoom(18);
          map.setCenter(marker.getPosition());
          google.maps.event.addListener(marker, 'click', function() {
            var  geocoder=new google.maps.Geocoder();
            var marcador=this;
            geocoder.geocode({'latLng':this.getPosition()},function(results,status){
                                        if(status==google.maps.GeocoderStatus.OK)
                                        {
                                        if(results){
                                                direccion_gps(marcador,results[0].formatted_address)
                                                }
                                        }
                        });
        });
            });
        function addPolyline (lineCoordinates) {
                var pointCount = lineCoordinates.length;
                var linePath = [];
                for (var i=0; i < pointCount; i++) {
                var tempLatLng = new google.maps.LatLng(
                lineCoordinates[i][0] , lineCoordinates[i][1]
                );
                linePath.push(tempLatLng);
                }
                var lineOptions = {
                path: linePath,
                strokeWeight: 7,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8
                }
                var polyline = new google.maps.Polyline(lineOptions);
                polyline.setMap(map2);
                polylines.push(polyline);
        }
        function direccion_gps(marker,direccion)
        {
            var contentString = '<div><br>Direccion:'+direccion+'</div>';
                var infowindow = new google.maps.InfoWindow({
                                                        content: contentString,
                                                        width:192,
                                                        height:100
                                                    });
                                                    infowindow.open(map,marker);
        }
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function setMapOnAll_ruta(map) {
            for (let i = 0; i < markers_ruta.length; i++) {
                markers_ruta[i].setMap(map);
            }
        }
        function eliminaruta(map) {
            for (let i = 0; i < polylines.length; i++) {
                polylines[i].setMap(map);
            }
        }
        function getGeozona(e)
        {
            var dispositivo=$("#dispositivo").val();
            $.ajax({
                        dataType : 'json',
                        type     : 'POST',
                        url : '{{ route('reportes.datageozona')}}',
                        data : {
                            '_token' : $('input[name=_token]').val(),
                            'dispositivo': dispositivo
                        },

            }).done(function (returnValue){
              //console.log(result);
              var html="<option></option>";
             for (let i = 0; i < returnValue.length; i++) {
                html=html+"<option value='"+returnValue[i].id+"' >"+returnValue[i].nombre+"</option>"
             }
             $("#geozona").html(html);


            });
        }
        </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&libraries=geometry&callback=initMap" async
></script>
@endpush
