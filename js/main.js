(function() {
    "use strict";

    document.addEventListener('DOMContentLoaded',function(){
        var map = L.map('mapa').setView([51.505, -0.09], 17);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
            .openPopup();




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


        nombre.addEventListener('blur',validarCampos);
        apellido.addEventListener('blur',validarCampos);
        email.addEventListener('blur',validarCampos);
        email.addEventListener('blur',validarlMail);

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

