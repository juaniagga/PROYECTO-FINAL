<footer class="site-footer">
    <div class="contenedor clearfix">
      <div class="footer-informacion">
        <h3>Sobre <span>FIESA</span></h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis voluptatibus, commodi consequuntur necessitatibus quia voluptatem fuga, ut eos itaque ea odio. Id ipsum porro inventore consequuntur eum quibusdam placeat quisquam!</p>
      </div>
      <div class="ultimos-tweets">
        <h3>Últimos <span>Tweets</span></h3>
        <ul>
          <li>Lorem ipsum dolor, sit amet consectetur adipisicing elit.Eaque nam qui hic exercitationem, dicta asperiores quibusda</li>
          <li>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quos ullam similique debitis ipsam dignissimos.</li>
        </ul>
      </div>
      <div class="menu">
        <h3>Redes <span>Sociales</span></h3>
        <nav class="redes-sociales">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-pinterest-p"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </nav>
      </div>
    </div>
    <p class="copyright"> Todos los derechos reservados FIESA UNMDP 2021</p>
  </footer>


  <script src="js/vendor/modernizr-3.8.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <script src="js/main.js"></script>
  <script src="js/jquery.animateNumber.js"></script>
  <script src="js/jquery.countdown.js"></script>
  <script src="js/jquery.colorbox-min.js"></script>
  <script src="js/lightbox.js"></script>

  <?php 
    /* $archivo= basename($_SERVER['PHP_SELF']);
    $pagina= str_replace(".php","",$archivo);
    if ($pagina == 'galeria')
      echo '<script src="js/lightbox.js"></script>'; */
    /*else
       if ($pagina == 'oradores' || $pagina == 'index')
        echo '<script src="js/jquery.colorbox-min.js"></script>'; 
        SI USO ESTO TIRA ERROR LA CONSOLA EN LAS OTRAS PAGINAS*/
  ?>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('set','transport','beacon'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>