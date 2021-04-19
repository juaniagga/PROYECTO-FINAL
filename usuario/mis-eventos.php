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
                      WHERE p.id_user=" . $id_user . "
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
              <a href="">
                <button type="button" class="btn  btn-success">Ver más</button>
              </a>
              <button type="button" id="cargar_comprobante" data-toggle="modal" data-target="#uploadModal" data-id="<?php echo $evento['id_participante'] ?>" class="btn  btn-default"><i class="fa fa-upload"></i> Cargar comprobante de pago</button>

              <button type="button" id="baja" data-id="<?php echo $evento['id_participante']; ?>" class="btn  btn-danger"><i class="fa fa-trash"></i> Darme de baja</button>
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
          <h5 class="modal-title" id="">Cargar comprobante de pago</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form -->
          <form id='upload' method='post' action='control-user.php' enctype="multipart/form-data">
          <label for="">Formatos permitidos: "PDF", "JPG", "PNG", "JPEG".</label>
            <input type='file' name='file' id='file' class='form-control' required><br>
            <input type="hidden" name="cargar-comprobante" value="1">
            <input type="hidden" id="input_participante" name="participante">
            <button type="submit" class='btn btn-info'>Cargar</button>
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