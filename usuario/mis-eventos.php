<?php include_once 'includes/header.php';
$id_user = $_SESSION['id_user'];
?>
<!-- ----------------------------------------------------------------------------- -->
<section class="seccion contenedor min-altura margin-barra">
  <h2> Mis eventos </h2>

  <div class="box-body">
    <table id="registros" class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>Nombre</th>
          <th class="col-xs-2">Fecha inicio</th>
          <th class="col-xs-2">Fecha fin</th>
          <th class="col-xs-2">Acciones</th>
        </tr>
      </thead>
      <tbody>

        <?php
        try {
          $sql = "
                      SELECT e.id_evento, e.nombre, e.fecha_inicio, e.fecha_fin, p.id_participante
                      FROM evento e INNER JOIN participante p on e.id_evento=p.id_evento
                      WHERE p.id_user=" . $id_user . " and e.estado=1
                      ORDER BY e.fecha_inicio, e.nombre";
          $tuplas = $db->query($sql);
        } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
        }
        while ($evento = $tuplas->fetch_assoc()) {
        ?>
          <tr>
            <td><?php echo $evento['nombre']; ?></td>
            <td> <?php echo date_format(date_create($evento['fecha_inicio']), 'd-m-Y'); ?></td>
            <td> <?php echo date_format(date_create($evento['fecha_fin']), 'd-m-Y'); ?></td>
            <td>
              <a href="../index.php?id=<?php echo $evento['id_evento']?>" target="_blank">
                <button type="button" class="btn  btn-success">Ver evento</button>
              </a>
              <button type="button" id="cargar_comprobante" data-toggle="modal" data-target="#uploadModal" data-evento="<?php echo $evento['id_evento'];?>" data-id="<?php echo $evento['id_participante'] ?>" class="btn  btn-default"><i class="fa fa-upload"></i> Cargar comprobante de pago</button>

              <button type="button" id="baja" data-id="<?php echo $evento['id_participante']; ?>" data-evento="<?php echo $evento['id_evento'];?>" class="btn  btn-danger"><i class="fa fa-trash"></i> Darme de baja</button>
            </td>
          </tr>
        <?php
        }
        ?>
        </tr>

        </tfoot>
    </table>
  </div>
  <!-- /.box-body -->

  <!-- Modal -->
  <div class="modal " id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Cargar comprobante de pago (* campo obligatorio)</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form -->
          <form id='upload' method='post' action='control-user.php' enctype="multipart/form-data">
            
            <legend class="col-form-label col-sm-12">Información de pago</legend>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="medio" class="col-sm-5 control-label">Medio de pago *</label>
                          <div class="col-sm-12">
                            <select name="medio" class="form-control select2" id="medio" placeholder="" style="width: 100%;" required>
                              <option value="">- Seleccione -</option>
                              <?php
                              try {
                                $sql = "
                              SELECT m.id_medio, m.nombre
                              FROM medios_pago m
                              WHERE m.estado=1";
                                $tuplas = $db->query($sql);
                              } catch (Exception $e) {
                                echo "Error: " . $e->getMessage();
                              }

                              while ($medio = $tuplas->fetch_assoc()) {
                              ?>
                                <option value="<?php echo $medio['id_medio']; ?>" ><?php echo $medio['nombre']; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>

                        </div>

                        <div class="form-group col-sm-4">
                          <label for="importe" class="col-sm-6 control-label">Importe abonado *</label>
                          <div class="col-sm-12">
                            <input name="importe" type="number" step="0.01" class="form-control" id="importe" placeholder="" required>
                          </div>
                        </div>

                        <div class="form-group col-sm-4">
                          <label for="fecha_pago" class="col-sm-5 control-label">Fecha de pago *</label>
                          <div class="col-sm-12">
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="fecha_pago" required>
                            </div>
                          </div>
                        </div>
                        
                      </div>

                      <div class="form-group col-sm-12">
                
                          <div class="col-sm-12">
                          <label for="">Formatos permitidos: "PDF", "JPG", "PNG", "JPEG".</label>
                          <input type='file' name='file' id='file' class='form-control' required><br>
                          <input type="hidden" name="cargar-comprobante" value="1">
                          <input type="hidden" id="input_participante" name="participante">
                          <input type="hidden" id="input_evento" name="id_evento">
                          </div>
                          
                      </div>      
                      

                      <div class="form-group col-sm-12">
                          <label for="comentario" class="col-sm-2 control-label">Comentario sobre el pago</label>
                          <div class="col-sm-12">
                            <input name="comentario" type="text" class="form-control" id="comentario" placeholder="">
                          </div>
                      </div>      


                      <legend class="col-form-label col-sm-12">Facturación <span style="font-weight: 300; font-size:15px">(completar sólo en caso de requerir facturación)</span></legend>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="iva" class="col-sm-2 control-label">Condición de IVA</label>
                          <div class="col-sm-12">
                            <input name="iva" type="text" class="form-control" id="iva" placeholder="">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="cuit" class="col-sm-2 control-label">CUIT</label>
                          <div class="col-sm-12">
                            <input name="cuit" type="number" class="form-control" id="cuit" placeholder="" style="width: 50%;">
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-6">
                          <label for="nombre_factura" class="col-sm-2 control-label">Nombre en factura</label>
                          <div class="col-sm-12">
                            <input name="nombre_factura" type="text" class="form-control" id="nombre_factura" placeholder="">
                          </div>
                      </div>
                      <div class="form-group col-sm-12">
                          <label for="conceptos" class="col-sm-2 control-label">Conceptos adicionales a facturar</label>
                          <div class="col-sm-12">
                            <input name="conceptos" type="text" class="form-control" id="conceptos" placeholder="">
                          </div>
                      </div>
                      <div class="form-group col-sm-12">
                        <button type="submit" class='btn btn-info pull-right'>Cargar</button>
                      </div>
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</section>
<!--seccion-->


<!-- =============================================== -->

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts-footer.php';
?>

<!-- =============================================== -->