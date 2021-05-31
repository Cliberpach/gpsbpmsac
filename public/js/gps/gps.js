var arreglo = []; //contendra a todo los markers de los gps
var markers = [];
var polylines=[];
var imei_click = "";
$.ajax({
    dataType: "json",
    type: "POST",
    async: false,
    url: window.location.origin + "/gpsposicion"
    // url: window.location.origin + "/gps",
}).done(function(result) {
    const image = {
        url: window.location.origin + "/img/gps.png",
        // This marker is 20 pixels wide by 32 pixels high.
        scaledSize: new google.maps.Size(50, 50)
        // The origin for this image is (0, 0).
    };
    for (var i = 0; i < result.length; i++) {
        //var velocidad_km = velocidad(result[i].cadena, result[i].nombre);
        if (result[i].fecha != "") {
            $("#tr_" + result[i].imei + " #last_time").html(result[i].fecha);
        } else {
            $("#tr_" + result[i].imei + " #last_time").html("Sin Fecha");
        }
        var velocidad_km = result[i].velocidad;
        $("#tr_" + result[i].imei + " #last_velocidad").html(
            parseFloat(velocidad_km).toFixed(2) + " kph"
        );
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(result[i].lat, result[i].lng),
            icon: image,
            title: result[i].placa
        });
        if (result[i].lat == "") {
            marker.setMap(null);
        } else {
            marker.setMap(map);
        }
        google.maps.event.clearInstanceListeners(marker);
        /*google.maps.event.addListener(
            marker,
            "click",
            function () {
                var direccion = "Sin direccion";
                $.ajax({
                    url:
                        "https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
                        result[i].lat +
                        "," +
                        result[i].lng +
                        "&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI",
                    type: "GET",
                    async: false,
                    success: function (res) {
                        direccion = res.results[0].formatted_address;
                    },
                });
                var contentString =
                    "<div>Placa:" +
                    result[i].placa +
                    "<br>Marca:" +
                    result[i].marca +
                    "<br>Color:" +
                    result[i].color +
                    "<br>Direccion:" +
                    direccion +
                    "</div>";
                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    width: 192,
                    height: 100,
                });
                infowindow.open(map, this);
                info_.push(infowindow);
            },
            false
        );*/
        //apartado para la placa --start
        var myOptions = {
            disableAutoPan: false,
            maxWidth: 0,
            pixelOffset: new google.maps.Size(-40, -69),
            zIndex: null,
            closeBoxURL: "",
            position: new google.maps.LatLng(result[i].lat, result[i].lng),
            infoBoxClearance: new google.maps.Size(1, 1),
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: false
        };
        myOptions.content =
            '<div class="info-box-wrap"><div class="info-box-text-wrap">' +
            result[i].placa +
            "</div></div>";
        var ibLabel = new InfoBox(myOptions);
        if (result[i].lat != "") {
            ibLabel.open(map);
        }
        arreglo.push({
            lat: result[i].lat,
            infow: ibLabel,
            lng: result[i].lng,
            imei: result[i].imei,
            marker: marker,
            marca: result[i].marca,
            color: result[i].color,
            placa: result[i].placa,
            velocidad: velocidad_km,
            recorrido: result[i].recorrido
        });
    }
});
/**
 *
 * @param {*} cadena la cadena que manda el gps
 * @param {*} nombre el tipo de gps (Tracker303,Meitrack,Tracer3b,etc)
 * @returns
 */
function velocidad_(cadena, nombre) {
    if (nombre == "TRACKER303") {
        var arreglo_cadena = cadena.split(",");
        var velocidad_km = parseFloat(arreglo_cadena[11]) * 1.15078 * 1.61;
        return velocidad_km;
    } else if (nombre == "MEITRACK") {
        var arreglo_cadena = cadena.split(",");
        var velocidad_km = parseFloat(arreglo_cadena[10]);
        return velocidad_km;
    }
}
/**
 * Verificar el estado del dispositivo por tipo de usuario
 */
function dispositivo_estado() {
    $.ajax({
        dataType: "json",
        type: "POST",
        url: window.location.origin + "/gpsestado"
    }).done(function(result) {
        for (var i = 0; i < result.length; i++) {
            if (result[i].estado == "Conectado") {
                if (result[i].movimiento == "Sin Movimiento") {
                    $("#tr_" + result[i].imei + " #estado_gps").html(
                        '<div class="circulo" style="background-color:yellow;"></div>'
                    );
                } else {
                    $("#tr_" + result[i].imei + " #estado_gps").html(
                        '<div class="circulo" style="background-color:green;"></div>'
                    );
                }
            } else {
                $("#tr_" + result[i].imei + " #estado_gps").html(
                    '<div class="circulo" style="background-color:red;"></div>'
                );
            }
        }
    });
}
function dispositivo() {
    $.ajax({
        dataType: "json",
        type: "POST",
        async: false,
        url: window.location.origin + "/gpsposicion"
        //url: window.location.origin + "/gps",
    }).done(function(result) {
        var i = 0;
        for (i = 0; i < result.length; i++) {
            if (result[i].fecha != "") {
                $("#tr_" + result[i].imei + " #last_time").html(
                    result[i].fecha
                );
            } else {
                $("#tr_" + result[i].imei + " #last_time").html("Sin Fecha");
            }
            var latlng = new google.maps.LatLng(result[i].lat, result[i].lng);
            var indice = buscar(arreglo, parseInt(result[i].imei));
            // var mph = velocidad(result[i].cadena, result[i].nombre);
            var mph = result[i].velocidad;
            $("#tr_" + result[i].imei + " #last_velocidad").html(
                parseFloat(mph).toFixed(2) + " kph"
            );
            if (result[i].lat != "") {
                if (arreglo[indice].marker.getMap() == null) {
                    arreglo[indice].marker.setMap(map);
                    arreglo[indice].infow.open(map);
                }
            }
            arreglo[indice].marker.setPosition(latlng);

            var imei = result[i].imei;
            arreglo[indice].imei = imei;
            arreglo[indice].placa = result[i].placa;
            arreglo[indice].marca = result[i].marca;
            arreglo[indice].color = result[i].color;
            arreglo[indice].velocidad = mph;
            arreglo[indice].lat = result[i].lat;
            arreglo[indice].lng = result[i].lng;
            arreglo[indice].recorrido = result[i].recorrido;
            arreglo[indice].infow.setOptions({
                position: new google.maps.LatLng(result[i].lat, result[i].lng)
            });
            if (imei === imei_click) {
                ruta(imei);
            }
            google.maps.event.clearInstanceListeners(arreglo[indice].marker);
            /*google.maps.event.addListener(
                arreglo[indice].marker,
                "click",
                function () {
                    var nindice = buscarmarker(this);
                    var direccion = "Sin direccion";
                    $.ajax({
                        url:
                            "https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
                            arreglo[nindice].lat +
                            "," +
                            arreglo[nindice].lng +
                            "&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI",
                        type: "GET",
                        async: false,
                        success: function (res) {
                            direccion = res.results[0].formatted_address;
                        },
                    });
                    var contentString =
                        "<div>Placa:" +
                        arreglo[nindice].placa +
                        "<br>Marca:" +
                        arreglo[nindice].marca +
                        "<br>Color:" +
                        arreglo[nindice].color +
                        "<br>Direccion:" +
                        direccion +
                        "</div>";
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString,
                        width: 192,
                        height: 100,
                    });
                    infowindow.open(map, this);
                    info_.push(infowindow);
                },
                false
            );*/
        }
    });
}
/**
 *
 * @param {*} data El arreglo de los dispositivosgps
 * @param {*} elemento El elemento a buscar
 * @returns Retorna la posicion del elemento
 */
function buscar(data, elemento) {
    var position = -1;
    var i = 0;
    for (i = 0; i < data.length; i++) {
        if (data[i].imei == elemento) {
            position = i;
        }
    }
    return position;
}
function zoom(e) {
    var nindice = buscar(arreglo, parseInt($(e).data("imei")));
    var posicion = arreglo[nindice].marker.getPosition();
    if (arreglo[nindice].marker.getMap() != null) {
        map.setZoom(16);
        map.setCenter(posicion);
    }
    imei_click=$(e).data("imei");
    ruta($(e).data("imei"));
}
function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}
function eliminaruta(map) {
    for (let i = 0; i < polylines.length; i++) {
        polylines[i].setMap(map);
    }
}
function ruta(imei) {
    setMapOnAll(null);
    eliminaruta(null);
    $.ajax({
        dataType: "json",
        type: "POST",
        async: false,
        url: window.location.origin + "/gpsruta",
        data: {
            _token: $("input[name=_token]").val(),
            imei: imei
        }
    }).done(function(result) {
        var arregloruta = [];
        var latlng = [];
        for (var i = 0; i < result.length - 1; i++) {
          latlng = [];
            latlng.push(result[i].lat);
            latlng.push(result[i].lng);
            arregloruta.push(latlng);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(result[i].lat, result[i].lng),
                map: map,
                title: result[i].placa
            });
            markers.push(marker);
        }
        latlng = [];
        latlng.push(lat);
        latlng.push(lng);
        arregloruta.push(latlng);

        for (var j = 0; j < markers.length; j++) {
            if (j != markers.length - 1) {
                var heading = google.maps.geometry.spherical.computeHeading(
                    markers[j].getPosition(),
                    markers[j + 1].getPosition()
                );
                kmre =
                    kmre +
                    google.maps.geometry.spherical.computeDistanceBetween(
                        markers[j].getPosition(),
                        markers[j + 1].getPosition()
                    );
                var image;
                if (heading == 0) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_0.png"
                    };
                } else if (heading > 0 && heading < 45) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_22.png"
                    };
                } else if (heading == 45) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_45.png"
                    };
                } else if (heading > 45 && heading < 90) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_67.png"
                    };
                } else if (heading == 90) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_90.png"
                    };
                } else if (heading > 90 && heading < 135) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_112.png"
                    };
                } else if (heading == 135) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_135.png"
                    };
                } else if (heading > 135 && heading < 180) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_157.png"
                    };
                } else if (heading == 180 || heading == -180) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_180.png"
                    };
                } else if (heading < 0 && heading > -45) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N22.png"
                    };
                } else if (heading == -45) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N45.png"
                    };
                } else if (heading < -45 && heading > -90) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N67.png"
                    };
                } else if (heading == -90) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N90.png"
                    };
                } else if (heading < 90 && heading > -135) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N112.png"
                    };
                } else if (heading == -135) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N135.png"
                    };
                } else if (heading < -135 && heading > -180) {
                    image = {
                        url:
                            window.location.origin +
                            "img/rotation/gpa_prueba_N157.png"
                    };
                }
                image.scaledSize = new google.maps.Size(40, 40);
                image.origin = new google.maps.Point(0, 0);
                markers[j].setIcon(image);
            }
        }
        addPolyline(arregloruta);
    });
}
$(".i-checks").on("ifChecked", function(e) {
    var nindice = buscar(arreglo, parseInt($(e.currentTarget).data("imei")));
    if (arreglo[nindice].marker.getMap() == null) {
        arreglo[nindice].marker.setMap(map);
        arreglo[nindice].infow.setOptions({
            isHidden: false
        });
    }
});
$(".i-checks").on("ifUnchecked", function(e) {
    var nindice = buscar(arreglo, parseInt($(e.currentTarget).data("imei")));
    if (arreglo[nindice].marker.getMap() != null) {
        arreglo[nindice].marker.setMap(null);
        arreglo[nindice].infow.setOptions({
            isHidden: true
        });
    }
});
/**
 *Dibujar en el mapa por posiciones dadas
 * @param {*} lineCoordinates Lista de posiciones a dibujar
 */
function addPolyline(lineCoordinates) {
    var pointCount = lineCoordinates.length;
    var linePath = [];
    for (var i = 0; i < pointCount; i++) {
        var tempLatLng = new google.maps.LatLng(
            lineCoordinates[i][0],
            lineCoordinates[i][1]
        );
        linePath.push(tempLatLng);
    }
    var lineOptions = {
        path: linePath,

        strokeWeight: 7,
        strokeColor: "#FF0000",
        strokeOpacity: 0.8
    };
    var polyline = new google.maps.Polyline(lineOptions);
    polyline.setMap(map);
    polylines.push(polyline);
}
