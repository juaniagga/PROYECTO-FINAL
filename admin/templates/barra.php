<header class="main-header">
    <!-- Logo -->
    <?php if (!$permiso){?>
      <?php $encrypt= openssl_encrypt($_SESSION['id_evento'],"AES-128-ECB","unmdp2021"); ?>
      <a href="../index.php?id=<?php echo urlencode($encrypt);?>" class="logo" target="_blank">
    <?php }else{?>
      <a class="logo" target="_blank">
      <?php }?>
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="../img/favicon.png" alt=""></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b></b> Vista previa</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs" style="font-size:18px; padding-right:3rem;">¡Hola  <?php echo $_SESSION['nombre']; ?>!</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <!-- <li class="user-header">
                <p>
                  Administrador
                </p>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="editar-admin.php" class="btn btn-default btn-flat">Ajustes</a>
                </div>
                <div class="pull-right">
                  <a href="login-admin.php?out=true" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>