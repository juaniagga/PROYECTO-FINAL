<?php
include_once 'funciones/sesion-admin.php';

$permiso = $_SESSION['permiso'];
if ($permiso) {
  $id_evento = urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB", "unmdp2021"));
} else {
  $id_evento = $_SESSION['id_evento'];
}
$rta;
?>
<table id="dtHorizontalVerticalExample" class="text-center table table-striped table-bordered table-sm " cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="col-xs-3">Nombre</th>
      <th class="col-xs-3">Apellido</th>
      <th class="col-xs-3">Email</th>
      <th class="col-xs-2">DNI</th>
      <th class="col-xs-2">Teléfono</th>
      <th class="col-xs-2">Acreditado</th>
      <th class="col-xs-2">Fecha registro</th>
      <th class="col-xs-2">Tarifa</th>
      <th class="col-xs-2">Categoría</th>
      <th class="col-xs-2">Comprobante de pago</th>
      <th class="col-xs-2">Forma pago</th>
      <th class="col-xs-2">Importe abonado</th>
      <th class="col-xs-2">Fecha pago</th>
      <th class="col-xs-2">Comentarios pago</th>
      <th class="col-xs-2">Pago confirmado</th>
      <th class="col-xs-2">Exento de pago</th>
      <th class="col-xs-2">Tiene trabajos científicos</th>
      <th class="col-xs-2">Domicilio</th>
      <th class="col-xs-2">Ciudad</th>
      <th class="col-xs-2">Provincia</th>
      <th class="col-xs-2">País</th>
      <th class="col-xs-2">Institución</th>
      <th class="col-xs-2">Cargo</th>
      <th class="col-xs-2">Solicita facturación</th>
      <th class="col-xs-2">Condición de IVA</th>
      <th class="col-xs-2">CUIT</th>
      <th class="col-xs-2">Conceptos adicionales a facturar</th>
      <th class="col-xs-2">Nombre en factura</th>
      <th class="col-xs-2">Alojamiento</th>
      <th class="col-xs-2">Fecha de arribo</th>
      <th class="col-xs-2">Fecha de partida</th>
      <th class="col-xs-2">Forma de traslado</th>

    </tr>
  </thead>
  <tbody>

    <?php
    try {
      include_once 'funciones/funciones.php';
      $sql = "
                    SELECT u.id_user, u.nombre, u.apellido, u.email, u.dni, u.telefono, u.calle, u.numero, u.ciudad,
                      u.provincia, u.pais, u.trabajo_cientifico, u.institucion, u.cargo, p.fecha_registro, p.acreditado,
                      p.forma_pago, p.importe_abonado, p.fecha_pago, p.comentario_pago, p.pago_confirmado, p.exento,
                      p.facturacion, p.iva, p.cuit, p.adicionales, p.nombre_factura, p.alojamiento, p.fecha_arribo,
                      p.fecha_partida, p.traslado, c.tarifa, p.comprobante, p.id_participante, p.id_categoria, cp.nombre as nombre_categoria
                    FROM (usuario u INNER JOIN participante p ON u.id_user=p.id_user) INNER JOIN cat_asociadas c
                    ON c.id_categoria=p.id_categoria INNER JOIN categoria_participante cp ON c.id_categoria=cp.id_categoria
                    WHERE p.id_evento=" . $id_evento . " and c.id_evento=" . $id_evento . "
                    ORDER BY u.apellido, u.nombre";
      $tuplas = $db->query($sql);
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }

    if ($tuplas) {
      $emails_inscriptos = "";
      $emails_sin_confirmar = "";
      $emails_acreditados = "";
      while ($user = $tuplas->fetch_assoc()) {
        $emails_inscriptos = $emails_inscriptos . $user['email'] . ",";
        if ($user['acreditado']) {
          $emails_acreditados = $emails_acreditados . $user['email'] . ",";
        }
        if (!$user['pago_confirmado']) {
          $emails_sin_confirmar = $emails_sin_confirmar . $user['email'] . ",";
        }
    ?>
        <tr>
          <td><?php echo $user['nombre']; ?></td>
          <td><?php echo $user['apellido']; ?></td>
          <td> <?php echo $user['email']; ?></td>
          <td> <?php echo $user['dni']; ?></td>
          <td><?php echo $user['telefono']; ?></td>
          <td><?php
              if ($user['acreditado']) {
                echo "<span id='acreditado' class='badge bg-green'>Acreditado</span>";
              } else {
                echo "<span id='acreditado' class='badge bg-red'>No acreditado</span>";
              }; ?></td>
          <td> <?php echo date_format(date_create($user['fecha_registro']), 'd-m-Y'); ?></td>
          <td> <?php echo $user['tarifa']; ?></td>
          <td> <?php echo $user['nombre_categoria']; ?></td>
          <td><?php echo $user['comprobante']; ?></td>
          <td> <?php echo $user['forma_pago']; ?></td>
          <td> <?php echo $user['importe_abonado']; ?></td>
          <td><?php
              if ($user['fecha_pago'] == "0000-00-00") {
                echo "";
              } else {
                echo date_format(date_create($user['fecha_pago']), 'd-m-Y');
              };
              ?></td>
          <td> <?php echo $user['comentario_pago']; ?></td>
          <td> <?php
                if ($user['pago_confirmado']) {
                  echo "<span id='pago-confirmado' class='badge bg-green'>Confirmado</span>";
                } else {
                  echo "<span id='pago-confirmado' class='badge bg-red'>Sin confirmar</span>";
                };
                ?></td>
          <td><?php
              if ($user['exento']) {
                echo "Si";
              } else {
                echo "No";
              };
              ?></td>
          <td> <?php
                if ($user['trabajo_cientifico']) {
                  echo "Si";
                } else {
                  echo "No";
                };
                ?></td>
          <td> <?php echo $user['calle'] . " " . $user['numero']; ?></td>
          <td> <?php echo $user['ciudad']; ?></td>
          <td> <?php echo $user['provincia']; ?></td>
          <td> <?php echo $user['pais']; ?></td>
          <td> <?php echo $user['institucion']; ?></td>
          <td> <?php echo $user['cargo']; ?></td>
          <td> <?php
                if ($user['facturacion']) {
                  echo "Si";
                } else {
                  echo "No";
                };
                ?></td>
          <td> <?php echo $user['iva']; ?></td>
          <td> <?php
                if ($user['cuit'] == "0") {
                  echo "";
                } else {
                  echo $user['cuit'];
                };
                ?></td>
          <td> <?php echo $user['adicionales']; ?></td>
          <td> <?php echo $user['nombre_factura']; ?></td>
          <td> <?php echo $user['alojamiento']; ?></td>
          <td> <?php
                if ($user['fecha_arribo'] == "0000-00-00") {
                  echo "";
                } else {
                  echo date_format(date_create($user['fecha_arribo']), 'd-m-Y');
                };
                ?></td>
          <td> <?php
                if ($user['fecha_partida'] == "0000-00-00") {
                  echo "";
                } else {
                  echo date_format(date_create($user['fecha_partida']), 'd-m-Y');
                };
                ?></td>
          <td> <?php echo $user['traslado']; ?></td>


        </tr>
    <?php
      }
    }
    ?>
    </tr>

    </tfoot>
</table>

<?php 
echo json_encode($rta);
?>