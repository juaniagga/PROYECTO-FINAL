$(document).ready(function(){

    const nombre_evento= 'Fiesa';   //OBTENER EL NOMBRE DEL EVENTO DE LA URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    $('#crear-user').on('submit', actualizar);

    $('#editar-user').on('submit', actualizar);
    
    $('#nueva-clave').on('submit', actualizar);

    $('#info-pago').on('click', infoPago);

    $('#nuevo-registro').on('submit', registro);

    $('#upload').on('submit', actualizarFiles);

    $('#certificado').on('click', descargarCertificado);

    $('#cargar_comprobante').on('click', function(){
        var id_comprobante= $(this).attr('data-id');
        $('#input_participante').val(id_comprobante);
        var id_comprobante_e= $(this).attr('data-evento');
        $('#input_evento').val(id_comprobante_e);
    });

    function registro(e){
        e.preventDefault();
        let datos= $(this).serializeArray();
        var error= document.getElementById('error');
        const origen=$(this).attr('id'); 
        const id_url=$('#id-evento').attr('value');
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
                                window.location.href= 'registro-exitoso.php?id='+ id_url +'#seccion';
                            },500);
                        } else {
                            var mensaje;
                            if (data.respuesta==""){
                                mensaje="Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.";
                            }else
                                mensaje=data.respuesta;
                            swal.fire({
                                title: 'Error!',
                                text: mensaje,
                                icon: 'error',                                      
                            })
                                            
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
                        case 'editar-user':
                        case 'nueva-clave':
                            setTimeout(function () {
                                window.location.href = 'ajustes.php';
                            }, 2000);
                        break;
                    }
                } else {
                    var msj;
                    if (data.respuesta==""){
                        msj="Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde."
                    }else{
                        msj= data.respuesta;
                    }
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: msj,
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
                        var msj;
                        if (data.respuesta=='Extensión incorrecta'){
                            msj= "Formato de archivo incorrecto. Revise los formatos permitidos."
                        } else{
                            if (data.respuesta!=''){
                                msj= "Ha ocurrido un error. Recargue la página y vuelva a intentarlo más tarde. Referencia: " + data.respuesta;
                            }else {
                                msj= "Ha ocurrido un error. Recargue la página y vuelva a intentarlo más tarde.";
                            }
                        }
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msj,
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


    function infoPago(e){
        e.preventDefault();
        var id_evento= $(this).attr('data-id');
        $.ajax({
            type: 'post',
            data: {
                infoPago: 1,
                id_evento:id_evento,
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

    function descargarCertificado(e){
        e.preventDefault();
        let id_evento= $(this).attr('evento');
        let id_participante= $(this).attr('data-id');
        $.ajax({
            type: 'post',
            data: {
                certificado: 1,
                id_evento: id_evento,
                id_participante: id_participante,
            },
            url: 'control-user.php',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data){
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'certificado_'+id_participante+'.pdf';
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function(XHR,status){
                swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: "El certificado no está disponible para su descarga.",
                })
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
                    let msj= data.respuesta;
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: msj,
                    })
                }
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }

        })
    }

    $('#forgotpass').on('click', forgotPass);
    
    function forgotPass(e){
        e.preventDefault();
        let email=$('#email').val();
        if (email!="")
            $.ajax({
                type: 'post',
                data: {
                    forgotpass: 1,
                    email: email,
                },
                url: 'control-login-user.php',
                dataType: 'json',
                success: function(data){
                    
                    if (data.respuesta== 'exito'){
                        swal.fire(
                            'Bienvenido!',
                            "Se ha enviado un mail a su casilla de correo con su nueva contraseña.",
                            'success'
                        )
                    } else {
                        let msj;
                        if (data.respuesta!="")
                            msj= data.respuesta;
                        else
                            msj="Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.";
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msj,
                        })
                    }
                },
                error: function(XHR,status){
                    console.log(XHR);
                    console.log(status);
                }

            })
        else{
            swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Debe ingresar el email.',
            })
        }
    }

    $('.box-body #baja').on('click', function(e){
        e.preventDefault();
        const id= $(this).attr('data-id');
        const id_evento= $(this).attr('data-evento');
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
                    type: 'post',
                    data:{
                        id: id,
                        baja: 1,
                        id_evento: id_evento,
                    },
                    url: 'control-user.php',
                    dataType: 'json',
                    success: function(data){
                        console.log(data.respuesta);  
                        if (data.respuesta=="exito"){
                            swal.fire(
                                'Hecho!',
                                '',//'Administrador creado correctamente',
                                'success'
                            )
                            setTimeout(function(){
                                jQuery('[data-id="'+ id +'"]').parents('tr').remove();
                            },1000);
                        } else {
                            var msj;
                            if (data.respuesta!=""){
                                msj= data.respuesta;
                            }else {
                                msj="Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.";
                            }
                            swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: msj,
                            })
                        }
                    },
                    error: function(XHR,status){
                        console.log(XHR);
                        console.log(status);
                    }
                })
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