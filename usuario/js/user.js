$(document).ready(function() {  

        /* let alturaBarra= $('.barra').innerHeight() + 40;

        $('body').css({'margin-top': alturaBarra+'px'}); */

        // CSS navegacion para pagina activa
$('body.mis-eventos .navegacion-principal a:contains("Mis eventos")').addClass('activo');
$('body.certificados .navegacion-principal a:contains("Certificados")').addClass('activo');
$('body.ajustes .navegacion-principal a:contains("Ajustes")').addClass('activo');

    
});

