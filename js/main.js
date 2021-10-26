$(function() {

    //Fijar barra

    let alturaWindow= $(window).height();
    let alturaBarra= $('.barra').innerHeight();

    $(window).scroll(function(){
        let scroll= $(window).scrollTop();
        if (scroll >(alturaWindow-alturaBarra)){
            $('.barra').addClass('fixed');
            $('body').css({'margin-top': alturaBarra+'px'});
        }
        else{
            $('.barra').removeClass('fixed');
            $('body').css({'margin-top': '0px'});
        }
    })


    // CSS navegacion para pagina activa
    $('body.index .navegacion-principal a:contains("Evento")').addClass('activo');
    $('body.calendario .navegacion-principal a:contains("Programa")').addClass('activo');
    $('body.oradores .navegacion-principal a:contains("Oradores")').addClass('activo');
    $('body.galeria .navegacion-principal a:contains("Galería")').addClass('activo');
    $('body.registro .navegacion-principal a:contains("Inscripción")').addClass('activo');


    //Navegacion menu
    $('.menu-movil').on('click', function(){
        $('.navegacion-principal').slideToggle();
    });


    //Programa de charlas/stands
    
    $('.programa-evento .info-curso:first').show();  //agarra "charlas"
    $('.menu-programa a:first').addClass('activo');  //que el primero "charlas" se ponga en activo
    $('.menu-programa a').on('click',function(){
        $('.menu-programa a').removeClass('activo');   //para que solo se muestren activos los que estan siendo cliqueados en el momento y no todos
        $(this).addClass('activo');
        $('.ocultar').hide();
        var enlace = $(this).attr('href');
        $(enlace).fadeIn(1000);
        return false;
    });


    //Animaciones para los numeros
    $('.resumen-evento li:nth-child(1) p').animateNumber({ number: 2000 }, 1200);
    $('.resumen-evento li:nth-child(2) p').animateNumber({ number: 150 }, 1200);
    $('.resumen-evento li:nth-child(3) p').animateNumber({ number: 3 }, 500);
    $('.resumen-evento li:nth-child(4) p').animateNumber({ number: 80 }, 1200);

    //Cuenta regresiva
    const tiempo= $('.cuenta-regresiva').attr('data-time');
    console.log(tiempo);
    $('.cuenta-regresiva').countdown(tiempo, function(event){
        $('#dias').html(event.strftime('%D'));
        $('#horas').html(event.strftime('%H'));
        $('#minutos').html(event.strftime('%M'));
        $('#segundos').html(event.strftime('%S'));
    });

    //Colorbox ORADORES
    $('.invitado-info').colorbox({inline:true,width:"50%"});
    $('.boton_newsletter').colorbox({inline:true,width:"50%"});

});