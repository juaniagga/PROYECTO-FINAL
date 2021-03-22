<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
$permiso = $_SESSION['permiso'];
$id_evento = $_SESSION['id_evento'];

?>


<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <?php
    include_once 'templates/barra.php';
    ?>

    <!-- =============================================== -->
    <?php
    include_once 'templates/navegacion.php';
    ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Añadir inscripto
          <!-- <small>Completá el formulario para crear el administrador</small> -->
        </h1>
      </section>

      <div class="centrar-contenido">
        <!-- Main content -->
        <div class="row col-sm-9 main">
          <section class="content">

            <!-- admin-sistema box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Complete el formulario <span style="font-size: 15px;">( * campo obligatorio )</span></h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <!-- CUERPO -->
                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="crear-inscripto" id="crear-inscripto" method="post" action="control-evento.php">
                    <div class="box-body">
                      <legend class="col-form-label col-sm-12">Datos personales</legend>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="nombre" class="col-sm-2 control-label">Nombre *</label>
                          <div class="col-sm-12">
                            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="apellido" class="col-sm-2 control-label">Apellido *</label>
                          <div class="col-sm-12">
                            <input name="apellido" type="text" class="form-control" id="apellido" placeholder="" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="pais" class="col-sm-2 control-label">País *</label>
                          <div class="col-sm-12">
                            <input name="pais" type="text" class="form-control" id="pais" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="provincia" class="col-sm-3 control-label">Provincia *</label>
                          <div class="col-sm-12">
                            <input name="provincia" type="text" class="form-control" id="provincia" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="ciudad" class="col-sm-2 control-label">Ciudad *</label>
                          <div class="col-sm-12">
                            <input name="ciudad" type="text" class="form-control" id="ciudad" placeholder="" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-12">
                          <label for="dni" class="col-sm-3 control-label">DNI/pasaporte *</label>
                          <div class="col-sm-12">
                            <input name="dni" type="number" class="form-control" id="dni" placeholder="" style="width: 30%;" required>
                          </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-3">
                          <label for="calle" class="col-sm-2 control-label">Calle *</label>
                          <div class="col-sm-12">
                            <input name="calle" type="text" class="form-control" id="calle" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-3">
                          <label for="numero" class="col-sm-2 control-label">Número *</label>
                          <div class="col-sm-12">
                            <input name="numero" type="number" class="form-control" id="numero" placeholder="" style="width: 50%;" required>
                          </div>
                        </div>
                      </div>

                      <p class="col-sm-12" style="margin-top:1rem;"> <b>--- Si NO es de Mar del Plata: --- </b></p>
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
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" name="arribo">
                              </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="partida" class="col-sm-12 control-label">Fecha de partida</label>
                            <div class="col-sm-12">
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
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
                      <p class="col-sm-12"> <b>- - - - - - - - - - - - - - - - - - - - - - - - </b></p>



                      <legend class="col-form-label col-sm-12">Datos de contacto</legend>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="email" class="col-sm-1 control-label">Email *</label>
                          <div class="col-sm-12 ">
                            <input name="email" type="email" class="form-control" id="email" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="telefono" class="col-sm-2 control-label">Teléfono *</label>
                          <div class="col-sm-12">
                            <input name="telefono" type="number" class="form-control" id="telefono" placeholder="Número de teléfono celular" style="width: 50%;" required>
                          </div>
                        </div>
                      </div>


                      <legend class="col-form-label col-sm-12">Datos institucionales</legend>
                      <div class="form-group col-sm-12">
                        <label for="medio" class="col-sm-3 control-label">Categoría del participante *</label>
                        <div class="col-sm-12">
                          <select name="categoria" class="form-control select2" id="categoria" placeholder="" style="width: 20%;" required>
                            <option value="0">- Seleccione -</option>
                            <?php
                            try {
                              $sql = "
                              SELECT c.id_categoria, cp.nombre
                              FROM categoria_participante cp, cat_asociadas c
                              WHERE c.id_evento=" . $id_evento . " and cp.id_categoria=c.id_categoria";
                              $tuplas = $db->query($sql);
                            } catch (Exception $e) {
                              echo "Error: " . $e->getMessage();
                            }

                            while ($cat = $tuplas->fetch_assoc()) {
                            ?>
                              <option value="<?php echo $cat['id_categoria']; ?>"><?php echo $cat['nombre']; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>

                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="institucion" class="col-sm-2 control-label">Institución</label>
                          <div class="col-sm-12">
                            <input name="institucion" type="text" class="form-control" id="institucion" placeholder="">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="cargo" class="col-sm-1 control-label">Cargo</label>
                          <div class="col-sm-12">
                            <input name="cargo" type="text" class="form-control" id="cargo" placeholder="">
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-sm-6">
                        <label class="col-sm-2 control-label">Tiene trabajos científicos</label>
                          <div class="radio col-sm-1">
                            <label>
                              <input type="radio" name="trabajo" id="trabajo1" value="1">
                              <b>Si</b>
                            </label>
                          </div>
                          <div class="radio col-sm-1">
                            <label>
                              <input type="radio" name="trabajo" id="trabajo0" value="0" checked>
                              <b>No</b>
                            </label>
                          </div>
                      </div>

                      <legend class="col-form-label col-sm-12">Información de pago<span style="font-weight: 300; font-size:15px"> (completar sólo si debe abonar una tarifa)</span></legend>
                      
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="medio" class="col-sm-5 control-label">Medio de pago</label>
                          <div class="col-sm-12">
                            <select name="medio" class="form-control select2" id="medio" placeholder="" style="width: 100%;">
                              <option value="0">- Seleccione -</option>
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
                                <option value="<?php echo $medio['id_medio']; ?>"><?php echo $medio['nombre']; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>

                        </div>

                        <div class="form-group col-sm-4">
                          <label for="importe" class="col-sm-6 control-label">Importe abonado</label>
                          <div class="col-sm-12">
                            <input name="importe" type="number" class="form-control" id="importe" placeholder="">
                          </div>
                        </div>

                        <div class="form-group col-sm-4">
                          <label for="fecha_pago" class="col-sm-5 control-label">Fecha de pago</label>
                          <div class="col-sm-12">
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="fecha_pago">
                            </div>
                          </div>
                        </div>
                        
                      </div>

                      <div class="form-group col-sm-6">
                        <label class="col-sm-2 control-label">Exento de pago</label>
                          <div class="radio col-sm-1">
                            <label>
                              <input type="radio" name="exento" id="exento1" value="1">
                              <b>Si</b>
                            </label>
                          </div>
                          <div class="radio col-sm-1">
                            <label>
                              <input type="radio" name="exento" id="exento0" value="0" checked>
                              <b>No</b>
                            </label>
                          </div>
                      </div>
                      <div class="form-group col-sm-12" style="margin-left: 1rem;">
                        <label for="pdf">Comprobante de pago</label>
                        <input type="file" id="pdf" name="pdf">
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

                      <div id="error"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="crear-inscripto" value="1">
                      <button type="submit" class="btn btn-info pull-right">Añadir</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->


          </section>
          <!-- /.content -->
        </div> <!-- row -->
      </div>


    </div>
    <!-- /.content-wrapper -->

    <?php
    include_once 'templates/footer.php';
    ?>