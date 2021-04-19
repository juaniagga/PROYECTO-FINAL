$(document).ready(function(){

    const nombre_evento= 'Fiesa';   //OBTENER EL NOMBRE DEL EVENTO DE LA URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    $('#crear-user').on('submit', actualizar);

    $('#info-pago').on('click', infoPago);

    $('#nuevo-registro').on('submit', registro);

    $('#upload').on('submit', actualizarFiles);

    $('#cargar_comprobante').on('click', function(){
        var id_comprobante= $(this).attr('data-id');
        $('#input_participante').val(id_comprobante);
    });

    function registro(e){
        e.preventDefault();
        let datos= $(this).serializeArray();
        var error= document.getElementById('error');

        const origen=$(this).attr('id'); 

        console.log(datos);

        console.log($('#sesion').val());
        if ($('#sesion').val()){ //si tiene la sesion iniciada
            if (datos[0].name=="id_categoria"){
                error.style.display='none';
                $.ajax({
                    type: $(this).attr('method'),
                    data: datos,
                    url: $(this).attr('action'),
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        if (data.respuesta=="exito"){
                            setTimeout(function(){
                                window.location.href= 'registro-exitoso.php#seccion';
                            },1000);
                        } else {
                            var mensaje;
                            if (data.respuesta=="usuario duplicado"){
                                mensaje="Ya estas registrado en este evento."
                            }else{
                                mensaje= "Ha ocurrido un error, vuelva a intetarlo.";
                            }
                            error.style.display="block";
                            error.innerHTML=mensaje;
                        }
                    },
                    error: function(XHR,status){
                        console.log(XHR);
                        console.log(status);
                        error.style.display="block";
                        error.innerHTML="Ha ocurrido un error, vuelva a intetarlo.";
                    }
                    
                });
            }else{
                error.style.display="block";
                error.innerHTML="* Debe seleccionar una categoría.";
            }
        }else {
            setTimeout(function () {
                window.location.href = 'usuario/login-user.php';
            }, 500);
        }
    }

    function actualizar(e) {
        e.preventDefault();
        let datos= $(this).serializeArray();
        var error= document.getElementById('error');
        const origen=$(this).attr('id');
        datosAux= camposVacios(datos);
        error.style.display = 'none';
        $.ajax({
            type: $(this).attr('method'),
            data: datosAux,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.respuesta == 'exito') {
                    swal.fire(
                        'Hecho!',
                        '',
                        'success'
                    )
                    switch (origen){
                        case 'crear-user':
                            setTimeout(function () {
                                window.location.href = 'mis-eventos.php';
                            }, 2000);
                    }
                } else {
                    var mensaje;
                        switch (origen){
                            case 'crear-user':
                                if (data.respuesta=="email duplicado"){
                                    mensaje='El email ingresado ya se encuentra registrado.'
                                }else{
                                    mensaje='Ha ocurrido un error. Vuelva a intentarlo más tarde.'
                                };
                        }
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: mensaje,
                        })
                }
            },
            error: function (XHR, status) {
                console.log(XHR);
                console.log(status);
            }
        });

    }


    function actualizarFiles(e){
        e.preventDefault();
        var datos= new FormData(this); //Para usar files
        let campos= $(this).serializeArray();
        console.log(campos);

            $.ajax({
                type: $(this).attr('method'),
                data: datos,
                url: $(this).attr('action'),
                dataType: 'json',
                /* Para trabajar con files: */
                contentType: false,
                processData: false,
                async: true,
                cache:false,
                success: function(data){
                    console.log(data);
                    if (data.respuesta=='exito'){
                        swal.fire(
                            'Hecho!',
                            '',
                            'success'
                          )
                        $('#uploadModal').modal('toggle');
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Documento ya cargado.',
                          })
                          $('#uploadModal').modal('toggle');
                    }
                },
                error: function(XHR,status){
                    console.log(XHR);
                    console.log(status);
                }
            });
        
    }

    function altaInscripto(e) {
        e.preventDefault();
        let datos = new FormData(this); //Para usar files
        var error = document.getElementById('error');
        let campos= $(this).serializeArray();
        console.log(campos);
        datosAux= camposVacios(datos);
        console.log(campos);
        error.style.display = 'none';
        $.ajax({
            type: $(this).attr('method'),
            data: datosAux,
            url: $(this).attr('action'),
            dataType: 'json',
            /* Para trabajar con files: */
            contentType: false,
            processData: false,
            async: true,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data.respuesta == 'exito') {
                    swal.fire(
                        'Hecho!',
                        '',
                        'success'
                    )
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Usuario no disponible',
                    })
                }
            },
            error: function (XHR, status) {
                console.log(XHR);
                console.log(status);
            }
        });

    }


    function infoPago(e){
        e.preventDefault();
        $.ajax({
            type: 'post',
            data: {
                infoPago: 1
            },
            url: 'usuario/panel.php',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data){
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'info_pago.pdf';
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }
        });
    }


    $('#login-user').on('submit', logeo);
    
    function logeo(e){
        e.preventDefault();

        var datos= $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                console.log('adentro');
                var resultado= data;
                if (data.respuesta== 'exito'){
                    swal.fire(
                        'Bienvenido!',
                        '',
                        'success'
                      )
                    setTimeout(function(){
                        window.history.back();
                    },2000);
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Usuario o contraseña incorrectos',
                      })
                }
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }

        })
    }


    $('.box-body #baja').on('click', function(e){
        e.preventDefault();
        const id= $(this).attr('data-id');
        swal.fire({
            title: '¿Está seguro que desea darse de baja del evento?',
            text: "No podrá deshacer esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Darme de baja',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    data:{
                        id: id,
                        baja: 1
                    },
                    url: 'control-user.php',
                    dataType: 'json',
                    complete: function(data){
                        console.log(data);
                        if (data.statusText== 'OK'){

                            swal.fire(
                                'Hecho!',
                                '',//'Administrador creado correctamente',
                                'success'
                            )
                            setTimeout(function(){
                                jQuery('[data-id="'+ id +'"]').parents('tr').remove();
                            },1000);
                        } else {
                            swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: '',
                            })
                        }
                    }
                })
            }
        })

    });

    //activar/desactivar pagos
    $('.content #btn-pago').on('click', function(e){
        e.preventDefault();

        const accion= $(this).attr('data');
        const id= $(this).attr('data-id');

        $.ajax({
            type: 'POST',
            data:{
                medios: 1,
                id: id,
                accion: accion,
            },
            url: 'control-evento.php',
            dataType: 'json',
            complete: function(data){
                if (data.statusText== 'OK'){
                    setTimeout(function(){
                        window.location.href= 'medios-pago.php';
                    },500);
                }
            }
        })
    
    });

    

    $('.content #usuario').keypress(function(tecla){
      if(tecla.charCode == 32){
         return false;
      }
    });

    $('.recordarme').on('checkbox', function(){
        $('login-admin #user').attr('autocomplete','on');
        $('login-admin #pass').attr('autocomplete','on');
    });

    function validarcampos(datos){
        var i=0;
        while ((i < datos.length) && (datos[i].value!='')){
            i++;
        };
        if (i < datos.length){
            return 0;   //hay un campo en blanco
        }else{
            return 1;
        }
    }

    function camposVacios(datos){
        var i=0;
        while (i < datos.length){
            if (datos[i]==null){
                datos[i]="";
            }
            i++;
        };
        return datos;
    }
});