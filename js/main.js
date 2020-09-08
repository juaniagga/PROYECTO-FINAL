(function() {
    "use strict";

    document.addEventListener('DOMContentLoaded',function(){
        if (document.querySelector('#mapa')){
            var map = L.map('mapa').setView([-38.00042, -57.5562], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
    
            L.marker([-38.00522, -57.5708]).addTo(map)
                .bindPopup('UNMdP')
                .openPopup();
        }
        


       //campos datos usuario
        var nombre = document.getElementById('nombre');
        var apellido= document.getElementById('apellido');
        var email= document.getElementById('email');

       //campos pases
        var pase_dia=document.getElementById('pase_dia');
        var pase_dosdias=document.getElementById('pase_dosdias');
        var pase_completo=document.getElementById('pase_completo');

        //botones y divs

        
        var calcular=document.getElementById('calcular');
        var botonRegistro=document.getElementById('btnRegistro');
        var errorDiv=document.getElementById('error');
        var resultado=document.getElementById('lista-productos');


        if (nombre){
            nombre.addEventListener('blur',validarCampos);
            apellido.addEventListener('blur',validarCampos);
            email.addEventListener('blur',validarCampos);
            email.addEventListener('blur',validarMail);
        }
        

        function validarCampos(){
            if(this.value==''){
                errorDiv.style.display='block';
                errorDiv.innerHTML="Este campo es obligatorio";
                this.style.border='1px solid red';
                errorDiv.style.border = '1px solid red';
            }
            else{
                errorDiv.style.display='none';
                this.style.border = '1px solid #cccccc';
            }
        }   
        function validarMail(){
            if(this.value,indexOf("@")>-1) {
                errorDiv.style.display='none';
                this.style.border='1px solid #cccccc';
            }else{
                errorDiv.style.display='block';
                errorDiv.innerHTML="Debe tener un @";
                this.style.border='1px solid red';
                errorDiv.style.border = '1px solid red';
            }
        }

    }); // DOM CONTENT LOADED
})();

$(function() {

    //Fijar barra

    let alturaWindow= $(window).height();
    let alturaBarra= $('.barra').innerHeight();

    $(window).scroll(function(){
        let scroll= $(window).scrollTop();
        if (scroll >alturaWindow){
            $('.barra').addClass('fixed');
            $('body').css({'margin-top': alturaBarra+'px'});
        }
        else{
            $('.barra').removeClass('fixed');
            $('body').css({'margin-top': '0px'});
        }
    })


    // CSS navegacion para pagina activa
    $('body .index .navegacion-principal a:contains("Evento")').addClass('activo');
    $('body .calendario .navegacion-principal a:contains("Programa")').addClass('activo');
    $('body .oradores .navegacion-principal a:contains("Oradores")').addClass('activo');
    $('body .galeria .navegacion-principal a:contains("Galería")').addClass('activo');


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

    $('.cuenta-regresiva').countdown('2020/12/10 09:00:00', function(event){
        $('#dias').html(event.strftime('%D'));
        $('#horas').html(event.strftime('%H'));
        $('#minutos').html(event.strftime('%M'));
        $('#segundos').html(event.strftime('%S'));
    });

    //Colorbox ORADORES
    $('.invitado-info').colorbox({inline:true,width:"50%"});

    /* $('.invitado a').on('click',function(){
        $('#orador_hidden').css({display:"block"});
    }) */

});