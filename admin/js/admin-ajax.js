$(document).ready(function(){

    const nombre_evento= 'Fiesa';   //OBTENER EL NOMBRE DEL EVENTO DE LA URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    $('#crear-admin').on('submit', actualizar);

    $('#crear-actividad').on('submit', actualizar);

    $('#editar-actividad').on('submit', actualizar);

    $('#editar-admin').on('submit', actualizar);

    $('#editar-evento').on('submit', actualizar);

    $('#editar-precio').on('submit', actualizar);

    $('#editar-categoria').on('submit', actualizar);

    $('#agregar-categoria').on('submit', actualizar);

    $('#crear-orador').on('submit', actualizarFiles);
    
    $('#editar-orador').on('submit', actualizarFiles);

    $('#crear-pago').on('submit', actualizarFiles);

    function actualizar(e){
        e.preventDefault();
        let datos= $(this).serializeArray();
        /* datos.push({name:'evento', value: nombre_evento});  //no manda evento
        console.log(datos); */
        var error= document.getElementById('error');

        console.log(datos);

        if (validarcampos(datos)){
            error.style.display='none';
            $.ajax({
                type: $(this).attr('method'),
                data: datos,
                url: $(this).attr('action'),
                //async: false,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if (data.respuesta="exito"){
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
                error: function(XHR,status){
                    console.log(XHR);
                    console.log(status);
                }
                
                
                /* function(XMLHttpRequest, textStatus, errorThrown) {
                    //console.log(XMLHttpRequest.responseText);
                    console.log("Status: " + textStatus, "Error: " + errorThrown);
                } */
            });
        }else{
            error.style.display="block";
            error.innerHTML="* Todos los campos son obligatorios";
        }
        
    }

    function actualizarFiles(e){
        e.preventDefault();
        let datos= new FormData(this); //Para usar files
        var error= document.getElementById('error');

        console.log(datos);

        if (validarcampos(datos)){
            error.style.display='none';
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
                    if (data.respuesta=='exito'){
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
                error: function(XHR,status){
                    console.log(XHR);
                    console.log(status);
                }
            });
        }else{
            error.style.display="block";
            error.innerHTML="* Todos los campos son obligatorios";
        }
        
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


    $('.borrar-registro').on('click', function(e){
        e.preventDefault();
        const tipo= $(this).attr('data-tipo');  //admin o admin-sistema .. no se usa
        const id= $(this).attr('data-id');
        const url= $(this).attr('url');
        swal.fire({
            title: '¿Está seguro que desea eliminarlo?',
            text: "No podrá recuperarlo",
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
                    complete: function(data){
                        console.log(data);
                        if (data.statusText== 'OK'){

                            swal.fire(
                                'Eliminado!',
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


    /* $('.borrar-registro').on('click', function(e){
        e.preventDefault();
        const tipo= $(this).attr('data-tipo');  //admin o admin-sistema
        const user= $(this).attr('data-id');
        swal.fire({
            title: '¿Está seguro que desea eliminarlo?',
            text: "No podrá recuperarlo",
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
                        usuario: user,
                        tipo: tipo,
                        eliminar: 1
                    },
                    url: 'control-admin-sistema.php',
                    dataType: 'json',
                    complete: function(data){
                        console.log(data);
                        if (data.statusText== 'OK'){
                            JQuery('[data-id="'+ user +'"]').parents('tr').remove();
                            
                        } else {
                            swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: '',
                              });
                        }
                    }
                })
                swal.fire(
                    'Eliminado!',
                    '',
                    'success'
                );
            }
          });
        

    }); */

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
});