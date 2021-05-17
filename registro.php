<?php include_once 'includes/templates/header.php'; ?>
<?php include_once 'includes/funciones/redirection.php'; ?>

<section class="seccion contenedor">
  <h2> Registro </h2>
  <h3>Valor de inscripción</h3>

  <!-- Formulario -->
  <div class="box-body">
    <!-- CUERPO -->
    <div class="">
      <!-- /.box-header -->
      <!-- form start -->
      <form class="form-horizontal" name="nuevo-registro" id="nuevo-registro" method="post" action="usuario/control-user.php">
      

        <div id="paquetes" class="paquetes">
          <p>Seleccione la categoría correspondiente a la cual pertenece.</p>
          <ul class="lista-precios clearfix">
            <?php
            try {
              $sql = "
                              SELECT c.id_categoria, cp.nombre, c.tarifa
                              FROM categoria_participante cp INNER JOIN cat_asociadas c ON cp.id_categoria=c.id_categoria
                              WHERE c.id_evento=" . $id_evento . " and cp.autoreg=1";
              $tuplas = $db->query($sql);
            } catch (Exception $e) {
              echo "Error: " . $e->getMessage();
            }

            if ($tuplas){
              while ($cat = $tuplas->fetch_assoc()) {
                ?>
                  <li>
                    <div class="tabla-precio">
                      <h3><?php echo $cat['nombre']; ?></h3>
                      <p class="numero">$<?php echo $cat['tarifa']; ?></p>
                      <ul>
                      </ul>
                      <div class="orden">
                        <input type="radio" name="id_categoria" size="3" value="<?php echo $cat['id_categoria']; ?>" required>
                      </div>
                    </div>
                  </li>
                <?php
                }
            }
            ?>

          </ul>
        </div><!-- #paquetes-->

        <p>Descargue el siguiente PDF con las indicaciones para realizar el pago, en caso de corresponder.</p>
        <div class="centrar-contenido">
          <button type="button" id="info-pago" data-id="<?php echo $id_evento;?>" class="button transparente"><i class="fa fa-download"></i> Información de pago</button>
        </div>


        <div class="box-body">
            <h3>Datos de alojamiento</h3>
            <p style="text-align: start;">(Complete en caso de no ser de Mar del Plata.)</p>
          <div class="form-group col-sm-12">
            <label for="hotel" class="col-sm-3 control-label">Hotel / lugar de alojamiento</label>
            <div class="col-sm-12">
              <input name="hotel" type="text" class="form-control" id="hotel" placeholder="" style="width: 50%;">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-sm-4">
              <label for="arribo" class="col-sm-12 control-label">Fecha de arribo</label>
              <div class="col-sm-12">
                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" name="arribo">
                </div>
              </div>
            </div>
            <div class="form-group col-sm-4">
              <label for="partida" class="col-sm-12 control-label">Fecha de partida</label>
              <div class="col-sm-12">
                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" name="partida">
                </div>
              </div>
            </div>
            <div class="form-group col-sm-4">
              <label for="traslado" class="col-sm-2 control-label">Forma de traslado</label>
              <div class="col-sm-12">
                <input name="traslado" type="text" class="form-control" id="traslado" placeholder="">
              </div>
            </div>
          </div>


          <div id="error"></div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <input type="hidden" name="nuevo-registro" value="1">
          <input type="hidden" name="id_evento" value="<?php echo $id_evento ?>">
          
          <input id="btnRegistro" type="submit" class="button transparente" value="REGISTRARSE">
        </div>
        <!-- /.box-footer -->
      </form>
      <input type="hidden" value="<?php echo isset($_SESSION['id_user']);?>" id="sesion">
    </div>
  </div>
  <!-- /.box-body -->

</section>
<!--seccion-->

<?php include_once 'includes/templates/footer.php'; ?>