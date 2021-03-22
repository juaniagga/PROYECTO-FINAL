  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="info">
          <p><?php echo $_SESSION['nombre']; ?></p>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu de administración</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>



        <!-- ADMIN de EVENTO -->
        <?php
        if (!$permiso) {
        ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bookmark"></i>
              <span>Evento</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="editar-evento.php"><i class="fa fa-pencil"></i>Editar información</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-calendar"></i>
              <span>Categorías participante</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="categorias-evento.php"><i class="fa fa-list-alt"></i>Ver todas</a></li>
              <li><a href="agregar-categoria.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-calendar"></i>
              <span>Actividades</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-actividades.php"><i class="fa fa-list-alt"></i>Ver todas</a></li>
              <li><a href="crear-actividad.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
          <!-- <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Categorías Actividades</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-list-alt"></i>Ver todas</a></li>
              <li><a href="#"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li> -->
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Oradores</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-oradores.php"><i class="fa fa-list-alt"></i>Ver todos</a></li>
              <li><a href="crear-orador.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-id-card"></i>
              <span>Inscriptos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-inscriptos.php"><i class="fa fa-list-alt"></i>Ver todos</a></li>
              <li><a href="crear-inscripto.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
          <li class="treeview">
            <li>
            <a href="estadisticas-evento.php">
              <i class="fa fa-id-card"></i>
              <span>Estadísticas</span>
            </a>
            </li>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-wrench"></i>
              <span>Administradores</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-admin.php"><i class="fa fa-list-alt"></i>Ver todos</a></li>
              <li><a href="crear-admin.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>


          <!-- ADMIN SISTEMA -->
        <?php
        } else {
        ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bookmark"></i> <span>Eventos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-eventos.php"><i class="fa fa-list-alt"></i> Ver todos </a></li>
              <li><a href="crear-admin.php"><i class="fa fa-plus"></i>Nuevo evento</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-calendar"></i>
              <span>Categorías participante</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-categorias.php"><i class="fa fa-list-alt"></i>Ver todas</a></li>
              <li><a href="crear-categoria.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-credit-card"></i> <span>Medios de pago</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="medios-pago.php"><i class="fa fa-list-alt"></i> Ver todos </a></li>
              <li><a href="crear-pago.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-wrench"></i>
              <span>Admin eventos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-admin.php"><i class="fa fa-list-alt"></i>Ver todos</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-wrench"></i>
              <span>Admin sistema</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="lista-admin-sistema.php"><i class="fa fa-list-alt"></i>Ver todos</a></li>
              <li><a href="crear-admin-sistema.php"><i class="fa fa-plus"></i>Agregar</a></li>
            </ul>
          </li>
        <?php
        }
        ?>


        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-quote-right"></i>
            <span>Testimoniales</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-list-alt"></i>Ver todos</a></li>
            <li><a href="#"><i class="fa fa-plus"></i>Agregar</a></li>
          </ul>
        </li> -->


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>