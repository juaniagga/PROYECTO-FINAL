<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

$permiso = $_SESSION['permiso'];
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
          Editar evento
        </h1>
      </section>
      <div class="row centrar-contenido">
        <!-- Main content -->
        <div class="col-lg-7">
          <section class="content">

            <!-- Default box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Edite la información <span style="font-size: 15px;">( * campo obligatorio )</span></h3>
              </div>
              <div class="box-body">
                <!-- CUERPO -->
                <?php
                try {
                  include_once 'funciones/funciones.php';
                  $sql = "
                      SELECT e.id_evento, e.nombre, e.fecha_inicio, e.fecha_fin, e.descripcion, e.organizador, e.ubicacion, e.estado, e.limite, e.imagen
                      FROM evento e
                      WHERE e.id_evento=" . $_SESSION['id_evento'];
                  $tupla = $db->query($sql);
                  $evento = $tupla->fetch_assoc();
                } catch (Exception $e) {
                  echo "Error: " . $e->getMessage();
                }
                ?>

                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="editar-evento" id="editar-evento" method="post" action="control-evento.php">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nombre" class="control-label">Nombre del evento *</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre de nombre" required value="<?php echo $evento['nombre'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="descripcion" class="control-label">Descripción del evento *</label>
                        <textarea name="descripcion" type="text" class="form-control" rows="3" id="descripcion" required placeholder="Descripción del evento"><?php echo $evento['descripcion'] ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="organizador" class="control-label">Organizador *</label>
                        <input name="organizador" type="text" class="form-control" id="organizador" required placeholder="Organizador del evento" value="<?php echo $evento['organizador'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="ubicacion" class="control-label">Ubicación (En caso de ser virtual colocar "Evento virtual") *</label>
                        <input name="ubicacion" type="text" class="form-control" id="ubicacion" required placeholder="Ubicación" value="<?php echo $evento['ubicacion'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="nombre" class="control-label">Fecha inicio *</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker" name="fecha_inicio" required value="<?php echo date_format(date_create($evento['fecha_inicio']), 'd/m/Y'); ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nombre" class="control-label">Fecha fin *</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker" name="fecha_fin" required value="<?php echo date_format(date_create($evento['fecha_fin']), 'd/m/Y'); ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="limite" class="control-label">Limite de participantes *</label>
                        <input name="limite" type="text" class="form-control" id="limite" placeholder="" required value="<?php echo $evento['limite'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="">Foto actual del evento</label>
                        <br>
                        <img src="../img/<?php echo "evento_". $evento['id_evento'] . "/" . $evento['imagen']?>" width="40%" alt=" Foto del evento">
                      </div>
                      <div class="form-group">
                        <label for="imagen">Actualizar foto <span style="font-weight:300">(Formatos permitidos: .JPG, .JPEG, .PNG)</span></label>
                        <?php if($evento['imagen']!=""){?>
                          <input type="file" id="imagen" name="imagen">
                        <?php
                        }else{?>
                            <input type="file" id="imagen" name="imagen" required>
                        <?php
                        }
                        ?>
                        
                      </div>
                      <div class="form-group">
                        <label for="" class="control-label">Estado *</label>
                        <?php
                        if ($evento['estado']) {
                        ?>
                          <div class="radio">
                            <label>
                              <input type="radio" name="estado" id="estado1" value="1" checked>
                              <b>ACTIVADO</b>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="estado" id="estado0" value="0">
                              <b>DESACTIVADO</b>
                            </label>
                          </div>
                        <?php
                        } else {
                        ?>
                          <div class="radio">
                            <label>
                              <input type="radio" name="estado" id="estado1" value="1">
                              <b>ACTIVADO</b>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="estado" id="estado0" value="0" checked>
                              <b>DESACTIVADO</b>
                            </label>
                          </div>
                        <?php
                        }
                        ?>

                      </div>
                      <div class="form-group">
                        <label for="pdf">Documento con información de pago. IMPORTANTE: debe ser PDF. </label>
                        <input type="file" id="pdf" name="pdf">
                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="editar-evento" value="1">
                      <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento'] ?>">
                      <button type="submit" class="btn btn-info pull-right">Guardar</button>
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