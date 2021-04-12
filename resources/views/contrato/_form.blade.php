<div class="wrapper wrapper-content animated fadeIn">
    <form class="wizard-big" action="{{ $action }}" method="POST" id="form_registrar_contrato">
        @csrf
        <div class="ibox"> 
            <div class="ibox-content"> 
                <div class="row">
                    <div class="col-sm-6 b-r">
                        <h4 class=""><b>Documento de venta</b></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <p>Registrar datos del documento de venta:</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12">
                                <label class="">Fecha de Inicio</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_inicio" name="fecha_inicio" onchange="fechafinal(this)" class="form-control {{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}" value="{{old('fecha_inicio')?old('fecha_inicio'):getFechaFormato($contrato->fecha_inicio, 'Y/m/d')}}" readonly>
                                        @if ($errors->has('fecha_inicio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_inicio') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <label class="">Fecha de fin</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_fin" name="fecha_fin" class="form-control {{ $errors->has('fecha_fin') ? ' is-invalid' : '' }}" value="{{old('fecha_fin')?old('fecha_fin'):getFechaFormato($contrato->fecha_fin, 'Y/m/d')}}" readonly>
                                        @if ($errors->has('fecha_fin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_fin') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-lg-12 col-xs-12">
                                <label class="required">Empresa</label>
                                <select id="empresa" name="empresa" class="select2_form form-control {{ $errors->has('empresa') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(empresas() as $empresa)
                                        <option value="{{ $empresa->id }}" {{ old('empresa') ? (old('empresa') == $empresa->id ? "selected" : "") : ($empresa->id== $contrato->empresa_id ? "selected" : "") }} >{{ $empresa->nombre_comercial }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('empresa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('empresa') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-xs-12">
                                <label class="required">Cliente</label>
                                <select id="cliente" name="cliente" class="select2_form form-control {{ $errors->has('cliente') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(clientes() as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente') ? (old('cliente') == $cliente->id ? "selected" : "") : ($cliente->id== $contrato->cliente_id ? "selected" : "") }} >{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('cliente'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cliente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class=""><b>Detalle del Contrato</b></h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="col-form-label required">Placa:</label>
                                        <select class="select2_form form-control" onchange="dispositivoprecio(this)"
                                            style="text-transform: uppercase; width:100%" name="dispositivo"
                                            id="dispositivo" >
                                            <option></option>
                                            @foreach (dispositivos() as $dispositivo)
                                            <option value="{{$dispositivo->id}}" data-precio="{{$dispositivo->precio}}">{{$dispositivo->placa}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"><b><span id="error-dispositivo"></span></b>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label required" for="amount">Pago :</label>
                                            <input type="text" id="pago" class="form-control"  >
                                            <div class="invalid-feedback"><b><span id="error-pago"></span></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label required" for="amount">Costo Instalacion:</label>
                                            <input type="text" id="costo_instalacion" class="form-control"  >
                                            <div class="invalid-feedback"><b><span id="error-costo_instalacion"></span></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="amount">&nbsp;</label>
                                            <a class="btn btn-block btn-warning" style='color:white;' id="btn_agregar_detalle"> <i class="fa fa-plus"></i> AGREGAR</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                @if ($errors->has('dispositivo_tabla'))
                                    <h5 style="color:rgb(220,54,70);">{{ $errors->first('dispositivo_tabla') }}</h5>
                                @endif
                                    <table
                                        class="table dataTables-detalle-contrato table-striped table-bordered table-hover"
                                        style="text-transform:uppercase">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">ACCIONES</th>
                                                <th class="text-center">PLACA</th>
                                                <th class="text-center">PAGO</th>
                                                <th class="text-center">COSTO INSTALACION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right">Total:</th>
                                                <th><span id="total">0.0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                   
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
        <div class="form-group row">
            <div class="col-md-6 text-left" style="color:#fcbc6c">
                <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                    (<label class="required"></label>) son obligatorios.</small>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{route('contrato.index')}}" id="btn_cancelar"
                    class="btn btn-w-m btn-default">
                    <i class="fa fa-arrow-left"></i> Regresar
                </a>
                <button type="submit" id="btn_grabar" class="btn btn-w-m btn-primary">
                    <i class="fa fa-save"></i> Grabar
                </button>
            </div>
            <input type="hidden" name="dispositivo_tabla" id="dispositivo_tabla"> 
        </div>
    </form>
    @include('contrato.modal')
    @if (!empty($detalle))
            <input id="detalle" value="{{$detallecontrato}}" type="hidden">
    @endif
</div>
@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <style>
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
            position: absolute;
        }
    </style>
@endpush
@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        
         $(document).ready(function() {
                $(".select2_form").select2({
                    placeholder: "SELECCIONAR",
                    allowClear: true,
                    height: '200px',
                    width: '100%',
                });
                $('.input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    language: 'es',
                    format: "yyyy/mm/dd"
                });
                if($('#fecha_inicio').val()==="-")
                {
                $('#fecha_inicio').val(" ");
                $('#fecha_fin').val(" ");
                }
                
                
                $('.dataTables-detalle-contrato').DataTable({
                "dom": 'lTfgitp',
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        searchable: false,
                        "targets": [1],
                        data: null,
                        render: function(data, type, row) {
                                return  "<div class='btn-group'>" +
                                        "<a class='btn btn-sm btn-warning btn-edit' style='color:white'>"+ "<i class='fa fa-pencil'></i>"+"</a>" +
                                        "<a class='btn btn-sm btn-danger btn-delete' style='color:white'>"+"<i class='fa fa-trash'></i>"+"</a>"+ 
                                        "</div>";
                        }
                    },
                    {
                        "targets": [2],
                    },
                    {
                        "targets": [3],
                    },
                    {
                        "targets": [4],
                    },

                ],
                'bAutoWidth': false,
                'aoColumns': [
                    { sWidth: '0%' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
                ],
                "language": {
                    url: "{{asset('Spanish.json')}}"
                },
                "order": [[ 0, "desc" ]],
            });
            if(!($("#detalle").val()=== undefined))
            {
               var detalle=JSON.parse($("#detalle").val());
              
               var t = $('.dataTables-detalle-contrato').DataTable();
               for (var i = 0; i < detalle.length; i++) {
                  t.row.add([
                    detalle[i].dispositivo_id,
                    '',
                    detalle[i].placa,
                    detalle[i].pago,
                    detalle[i].costo_instalacion,
                    detalle[i].costo_instalacion,
                   ]).draw(false);
                }
               
             
               
                 guardardispositivos();
            }
            


            });
            function fechafinal(e)
            {
               
                var start= new Date($(e).val());
                start.setFullYear(start.getFullYear()+1);
                var final = start.toISOString().slice(0,10).replace(/-/g,"/");
                
                $('#fecha_fin').val( final);

            }
            function limpiarErrores() {
            $('#pago').removeClass("is-invalid")
            $('#error-precio').text('')
            $('#dispositivo').removeClass("is-invalid")
            $('#error-dispositivo').text('')
            $('#costo_instalacion').removeClass("is-invalid")
            $('#erro-costo_instalacion').removeClass("is-invalid")
            }
            function buscardispositivo(id) {
                    var existe = false;
                    var t = $('.dataTables-detalle-contrato').DataTable();
                    t.rows().data().each(function(el, index) {
                        if (el[0] == id) {
                            existe = true
                        }
                    });
                    return existe
            }
            $("#btn_agregar_detalle").click(function() {
                limpiarErrores()
                var enviar = false;
                if ($('#dispositivo').val() == '') {
                    toastr.error('Seleccione dispositivo.', 'Error');
                    enviar = true;
                    $('#dispositivo').addClass("is-invalid")
                    $('#error-dispositivo').text('El campo Dispositivo es obligatorio.')
                } else {
                    var existe = buscardispositivo($('#dispositivo').val())
                    if (existe == true) {
                        toastr.error('dispositivo ya se encuentra ingresado.', 'Error');
                        enviar = true;
                    }
                }
                if ($('#pago').val() == '') {
                    toastr.error('Ingrese el precio del despositivo.', 'Error');
                    enviar = true;
                    $("#pago").addClass("is-invalid");
                    $('#error-precio').text('El campo Precio es obligatorio.')
                }
                if ($('#costo_instalacion').val() == '') {
                    toastr.error('Ingrese el costo instalacion del despositivo.', 'Error');
                    enviar = true;
                    $("#costo_instalacion").addClass("is-invalid");
                    $('#error-costo_instalacion').text('El campo costo instalacion es obligatorio.')
                }
                if (enviar != true) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger',
                        },
                        buttonsStyling: false
                    })
                    Swal.fire({
                        title: 'Opción Agregar',
                        text: "¿Seguro que desea agregar Dispositivo?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: 'Si, Confirmar',
                        cancelButtonText: "No, Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            llegarDatos();
                        } else if (
                            // Read more about handling dismissals below 
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                                'Cancelado',
                                'La Solicitud se ha cancelado.',
                                'error'
                            )
                        }
                    })
                }
            });
            function llegarDatos() {
                var detalle = {
                    producto_id: $('#dispositivo').val(),
                    presentacion: $( "#dispositivo option:selected" ).text(),
                    precio: $('#pago').val(),
                    costo:$('#costo_instalacion').val(),
                }
                agregarTabla(detalle);
            }
            function agregarTabla($detalle) {
                var t = $('.dataTables-detalle-contrato').DataTable();
                t.row.add([
                    $detalle.producto_id,
                    '',
                    $detalle.presentacion,
                    $detalle.precio,
                    $detalle.costo,
                ]).draw(false);
                 guardardispositivos();
            }
            $(document).on('click', '.btn-edit', function(event) {
            var table = $('.dataTables-detalle-contrato').DataTable();
            var data = table.row($(this).parents('tr')).data();
            $('#modal_editar_detalle #indice').val(table.row($(this).parents('tr')).index());
            $("#modal_editar_detalle #dispositivo").val(data[0]).trigger('change');
            $('#modal_editar_detalle #pago').val(data[3]);
            $('#modal_editar_detalle #costo_instalacion').val(data[4]);
            $('#modal_editar_detalle').modal('show');
            });
          function guardardispositivos()
          {
            var dispositivo = [];
            var table = $('.dataTables-detalle-contrato').DataTable();
            var data = table.rows().data();
            var total=0;
            data.each(function(value, index) {
                total=total+parseFloat(value[4]);
                let fila = {
                    dispositivo_id: value[0],
                    pago: value[3],
                    costo:value[4],
                };
                dispositivo.push(fila);
            });
            $('#dispositivo_tabla').val(JSON.stringify(dispositivo));
            
            $('#total').html(total);
          }
          $(document).on('click', '.btn-delete', function(event) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })
                Swal.fire({
                    title: 'Opción Eliminar',
                    text: "¿Seguro que desea eliminar Producto?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var table = $('.dataTables-detalle-contrato').DataTable();
                        table.row($(this).parents('tr')).remove().draw();
                        guardardispositivos();
                        // sumaTotal()
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })
            });
            function dispositivoprecio(e)
            {
               $('#pago').val($(e).find(':selected').data('precio'));
            }
    </script>
@endpush