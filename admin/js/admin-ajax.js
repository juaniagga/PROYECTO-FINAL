$(document).ready(function(){

    const nombre_evento= 'Fiesa';   //OBTENER EL NOMBRE DEL EVENTO DE LA URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    $('#crear-admin').on('submit', actualizar);

    $('#crear-actividad').on('submit', actualizar);

    $('#crear-categoria').on('submit', actualizar);

    $('#editar-actividad').on('submit', actualizar);

    $('#editar-admin').on('submit', actualizar);

    $('#nueva-clave').on('submit', actualizar);

    $('#editar-evento').on('submit', actualizarFiles);

    $('#editar-tarifa').on('submit', actualizar);

    $('#editar-categoria').on('submit', actualizar);

    $('#agregar-categoria').on('submit', actualizar);

    $('#crear-orador').on('submit', actualizarFiles);
    
    $('#editar-orador').on('submit', actualizarFiles);

    $('#crear-pago').on('submit', actualizarFiles);

    $('#crear-inscripto').on('submit', altaInscripto);

    $('.box-body #acreditar').on('click', acreditar);

    $('.box-body #validar-pago').on('click', validarPago);

    $('.box-body #comprobante').on('click', descargarComprobante);

    $('#exportar').on('click', exportarInscriptos);

    $('#cargar-certificados').on('submit', enviarCertificados);

    $('#guia-user').on('click', guia);

    function actualizar(e){
        e.preventDefault();
        let datos= $(this).serializeArray();
        var error= document.getElementById('error');
        const origen=$(this).attr('id'); 
        console.log(datos);

            $.ajax({
                type: $(this).attr('method'),
                data: datos,
                url: $(this).attr('action'),
                //async: false,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if (data.respuesta=="exito"){
                        swal.fire(
                            'La operación se realizó con éxito',
                            '',
                            'success'
                          )
                    } else {
                        var mensaje;
                        switch (origen){
                            case 'crear-admin':
                            case 'nueva-clave':
                            case 'crear-actividad':
                            case 'crear-categoria':
                            case 'crear-orador':
                            case 'crear-pago':
                                if (data.respuesta!=""){
                                    mensaje= data.respuesta;
                                }else
                                    mensaje='Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.';
                                swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    text: mensaje,
                                });
                            break; 
                            default:
                                if (data.respuesta!=''){
                                    msj= data.respuesta;
                                    swal.fire({
                                        icon: 'error',
                                        title: '¡Error!',
                                        text: msj,
                                      })
                                }else {
                                    swal.fire(
                                        'La operación se realizó con éxito',
                                        '',
                                        'success'
                                      )
                                }
                            break;
                        }
                        
                    }
                },
                error: function(XHR,status){
                    console.log(XHR);
                    console.log(status);
                }
                
                
                /* function(XMLHttpRequest, textStatus, errorThrown) {
                    //console.log(XMLHttpRequest.responseText);
                    console.log("Status: " + textStatus, "Error: " + errorThrown);
                } */
            });
        
    }

    function actualizarFiles(e){
        e.preventDefault();
        let datos= new FormData(this); //Para usar files
        var error= document.getElementById('error');
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
                            'La operación se realizó con éxito',
                            '',
                            'success'
                          )
                    } else {
                        var msj;
                        if (data.respuesta!=''){
                            msj= data.respuesta;
                            swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: msj,
                              })
                        }else {
                            swal.fire(
                                'La operación se realizó con éxito',
                                '',
                                'success'
                              )
                        }
                        
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
                        'La operación se realizó con éxito',
                        '',
                        'success'
                    )
                } else {
                    var msj;
                    if (data.respuesta!=''){
                        msj= data.respuesta;
                    }else {
                        msj= "Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.";
                    }
                    swal.fire({
                        icon: 'error',
                        title: '¡Error!',
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

    function acreditar(e){
        e.preventDefault();
        const id= $(this).attr('data-id');
        const tipo= $(this).attr('data-tipo');
        console.log(id);
        $.ajax({
            type: 'post',
            data: {
                id: id,
                acreditar: 1,
                tipo: tipo,
            },
            url: 'control-evento.php',
            dataType: 'json',
            success: function(data){
                console.log(data);
                if (data.respuesta=="exito"){
                    swal.fire(
                        'La operación se realizó con éxito',
                        '',
                        'success'
                      )
                    setTimeout(function(){
                        if (tipo=="add"){
                            jQuery('[data-id="'+ id +'"]').parents('tr').find('#acreditar').html('<i class="fa  fa-close"></i> Desacreditar');
                            jQuery('[data-id="'+ id +'"]').parents('tr').find('#acreditar').attr('data-tipo','remove');
                            jQuery('[data-id="'+ id +'"]').parents('tr').find("#acreditado").replaceWith('<span class="badge bg-green">Acreditado</span>');
                        } else{
                            jQuery('[data-id="'+ id +'"]').parents('tr').find('#acreditar').html('<i class="fa  fa-check"></i> Acreditar');
                            jQuery('[data-id="'+ id +'"]').parents('tr').find('#acreditar').attr('data-tipo','add');
                            jQuery('[data-id="'+ id +'"]').parents('tr').find("#acreditado").replaceWith('<span class="badge bg-red">No acreditado</span>');
                        }
                        
                    },1000);
                } else {
                    var msj;
                    if (data.respuesta!=''){
                        msj= data.respuesta;
                    }else {
                        msj="Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.";
                    }
                    swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: msj,
                    })
                }
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }
        });
    }

    function validarPago(e){
        e.preventDefault();
        const id= $(this).attr('data-id');
        console.log(id);
        $.ajax({
            type: 'post',
            data: {
                id: id,
                validar: 1
            },
            url: 'control-evento.php',
            dataType: 'json',
            success: function(data){
                console.log(data);
                if (data.respuesta=="exito"){
                    swal.fire(
                        'La operación se realizó con éxito',
                        '',
                        'success'
                      )
                    setTimeout(function(){
                        jQuery('[data-id="'+ id +'"]').parents('tr').find("#pago-confirmado").replaceWith('<span class="badge bg-green">Confirmado</span>');
                    },1000);
                } else {
                    var msj;
                    if (data.respuesta!=''){
                        msj= data.respuesta;
                        swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: msj,
                            })
                    }else {
                        swal.fire(
                            'La operación se realizó con éxito',
                            '',
                            'success'
                            )
                    }
                }
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }
        });
    }

    function descargarComprobante(e){
        e.preventDefault();
        const id= $(this).attr('data-id');
        console.log(id);
        $.ajax({
            type: 'post',
            data: {
                id: id,
                descargar: 1
            },
            url: 'control-evento.php',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data){
                console.log(data);
                if (data!=null){
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'pago_'+id+'.pdf';
                    a.click();
                    window.URL.revokeObjectURL(url);
                }
            },
            error: function(XHR,status){
                swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'No se ha encontrado el comprobante.',
                  })
            }
        });
    }

   
    function enviarCertificados(e){
        e.preventDefault();
        let datos= new FormData(this); //Para usar files
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
                        'La operación se realizó con éxito',
                        'Envíe un mail a los participantes acreditados informando que ya tienen el certificado disponible para su descarga desde su panel de usuario.',
                        'success'
                        )
                } else {
                    var msj;
                    if (data.respuesta!=''){
                        msj= data.respuesta;
                    }else {
                        msj='Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.';
                    }
                    swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: msj,
                    })
                    
                }
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }
        });
        
    }

    function exportarInscriptos(e){
        e.preventDefault();
        const id= $(this).attr('data-id');
        const tabla= $('#dtHorizontalVerticalExample').prop('outerHTML');
        console.log(tabla);
        $.ajax({
            type: 'post',
            data: {
                tabla: tabla
            },
            url: 'exportar-inscriptos.php?id='+id,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data){
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'planilla_inscriptos.xlsx';
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }
        });
    }

    function guia(e){
        e.preventDefault();
        $.ajax({
            type: 'post',
            data: {
                guia: 1
            },
            url: 'control-evento.php',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data){
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'guia_usuario.pdf';
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
            }
        });
    }

    $('#login-admin').on('submit', logeo);
    
    function logeo(e){
        e.preventDefault();

        var datos= $(this).serializeArray();

        const tipo= $(this).attr('data-tipo');    //admin o admin-sistema.. no se usa por ahora

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
                        window.location.href= 'base-admin.php';
                        //window.location.href= 'base-'+ tipo +'.php';
                    },2000);
                } else {
                    let msj= data.respuesta;
                    swal.fire({
                        icon: 'error',
                        title: '¡Error!',
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
        let usuario=$('#usuario').val();
        if (usuario!="")
            $.ajax({
                type: 'post',
                data: {
                    forgotpass: 1,
                    usuario: usuario,
                },
                url: 'control-login-admin.php',
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
                text: 'Debe ingresar el usuario.',
            })
        }
    }

    $('.borrar-registro').on('click', function(e){
        e.preventDefault();
        const tipo= $(this).attr('data-tipo');  //admin o admin-sistema .. no se usa
        const id= $(this).attr('data-id');
        const url= $(this).attr('url');
        var titulo;
        if (tipo=="sin-confirmar"){
            titulo= "¿Está seguro que desea eliminarlos?"
            texto= "No podrá recuperarlos";
        }else{
            titulo= "¿Está seguro que desea eliminarlo?"
            texto= "No podrá recuperarlo";
        }
        swal.fire({
            title: titulo,
            text: texto,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    data:{
                        id: id,
                        tipo: tipo,
                        eliminar: 1
                    },
                    url: url,
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        if (data.respuesta== 'exito'){
                            swal.fire(
                                'Eliminado!',
                                '',
                                'success'
                            )
                            if (tipo=="sin-confirmar"){
                                setTimeout(function(){
                                    location.reload();
                                },1000);    
                            } else{
                                setTimeout(function(){
                                    jQuery('[data-id="'+ id +'"]').parents('tr').remove();
                                },1000);
                            }
                            
                        } else {
                            if (data.respuesta!=""){
                                mensaje= data.respuesta;
                            }else
                                mensaje='Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.';
                            swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: mensaje,
                            });
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
            success: function(data){
                if (data.respuesta== 'exito'){
                    setTimeout(function(){
                        window.location.href= 'medios-pago.php';
                    },500);
                } else{
                    if (data.respuesta!=""){
                        mensaje= data.respuesta;
                    }else
                        mensaje='Ha ocurrido un error inesperado. Recargue la página y vuelva a intentarlo más tarde.';
                    swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: mensaje,
                    });
                }
            },
            error: function(XHR,status){
                console.log(XHR);
                console.log(status);
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