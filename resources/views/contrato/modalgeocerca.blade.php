<div class="modal inmodal" id="modal_editar_geocerca" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%;max-width:1200px;" >
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Detalle del Contrato</h4>
                <small class="font-bold">Editar detalle</small>
            </div>
            <div class="modal-body">
                <div class="ibox">
                    <div class="ibox-content">
                        <input type="hidden" id="indice" name="indice">
                        <input type="hidden" id="geocerca_gps" name="geocerca_gps">
                          <div class="row">
                            <div class="col-lg-7">
                            <div class="card text-center">
                                    <div class="card-header bg-primary">
                                        Localizacion-Rango
                                    </div>
                                    <div class="card-body">
                                        <div id="map_geocerca" style="height:500px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card text-center">
                                            <div class="card-header bg-primary">
                                                Posiciones
                                            </div>
                                        <div class="card-body" >
                                            <div class="form-group">
                                                <div class="col-lg-12 col-xs-12">
                                                    <label class="required">Rangos</label>
                                                    <select id="rangos_gps" name="rangos_gps" class="select2_form form-control" onchange="rangoelegido_editar(this)">
                                                        <option></option>
                                                        @foreach(rangoscontrato() as $rango)
                                                            <option value="{{ $rango->id }}"   >{{ $rango->nombre }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <br>
                                                <div class="col-lg-12 col-xs-12">
                                                    <label class="required">Nombre Geocerca</label>
                                                    <input type="text" name="nombre_contrato_rango" id="nombre_contrato_rango" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                          </div>
                    </div>
                </div>
             </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm boton-editar" ><i class="fa fa-save"></i> Guardar</button>
                    <button type="button"  class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).on('click','.boton-editar',function()
        {
            if($("#modal_editar_geocerca #nombre_contrato_rango").val().length!=0)
            {
                var table = $('.dataTables-detalle-geocerca').DataTable();
                table.row($('#modal_editar_geocerca #indice').val()).remove().draw();

            var arreglo=JSON.parse($("#modal_editar_geocerca #geocerca_gps").val());
                var t = $('.dataTables-detalle-geocerca').DataTable();
            var fila=t.rows().count();
                        t.row.add([
                            '',
                            $("#modal_editar_geocerca #nombre_contrato_rango").val(),
                            arreglo
                        ]).draw(false);
                guardar();
                $("#modal_editar_geocerca").modal('hide');
            }
            else
            {
                toastr.error("Ingrese todo los datos","Error")
            }

        });
    </script>
@endpush
