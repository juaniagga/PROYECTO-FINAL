<?php include_once 'includes/header.php';
$id_user = $_SESSION['id_user'];
?>
<!-- ----------------------------------------------------------------------------- -->
<section id="mis-certificados" class="seccion contenedor min-altura margin-barra">
  <h2> Mis certificados </h2>

  <div class="box-body table-responsive">
    <table id="registros" class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>Evento</th>
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
                      WHERE p.id_user=" . $id_user . " and p.acreditado=1
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
              <button id="certificado" evento="<?php echo $evento['id_evento']?>" data-id="<?php echo $evento['id_participante']?>" type="button" class="btn  btn-default"><i class="fa fa-download"></i> Descargar certificado</button>
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
</section>
<!--seccion-->


<!-- =============================================== -->

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts-footer.php';
?>

<!-- =============================================== -->