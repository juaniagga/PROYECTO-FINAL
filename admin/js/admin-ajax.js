$(document).ready(function(){

    const nombre_evento= 'Fiesa';   //OBTENER EL NOMBRE DEL EVENTO DE LA URL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    $('#crear-admin').on('submit', actualizar);

    $('#crear-actividad').on('submit', actualizar);

    $('#editar-actividad').on('submit', actualizar);

    $('#editar-admin').on('submit', actualizar);

    $('#editar-evento').on('submit', actualizar);

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
                complete: function(data){
                    console.log(data);
                    try{
                        resultado= JSON.parse(data);
                        console.log("try");
                    }catch{
                        resultado=data;
                        console.log("catch");
                    }
                    console.log(resultado);
                    if (data.statusText== 'OK'){
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
                    /* if (resultado.respuesta == 'exito'){
                        swal.fire(
                            'Añadido!',
                            'Se ha creado el administrador correctamente',
                            'success'
                          )
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Usuario no disponible',
                          })
                    } */
                }/* ,
                error: function(data){
                    console.log("Error: " + data);
                } */
                
                
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
            complete: function(data){
                console.log('adentro');
                var resultado= data;
                if (data.statusText== 'OK'){
                    swal.fire(
                        'Bienvenido!',
                        '',//'Administrador creado correctamente',
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


    $('#btn-pago').on('click', function(e){
        e.preventDefault();

        const accion= $(this).attr('data');

        $.ajax({
            type: 'POST',
            data:{
                medios: 1,
                accion: accion,
            },
            url: 'control-evento.php',
            dataType: 'json',
            success: function(data){
                console.log(data);
            },
            error: function(data){
                console.log(data);
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