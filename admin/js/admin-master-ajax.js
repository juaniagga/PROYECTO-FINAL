$(document).ready(function(){

    /* $('#crear-admin submit').crossDomain */
    
    $('#crear-admin').on('submit',function(e){
        e.preventDefault();

        let datos= $(this).serializeArray();
        console.log(datos);
        /* var email= $('#email').val(),
                usuario= $('#usuario').val(),
                password= $('#password').val();
        var datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('email', email);
        datos.append('password', password); */
        
        /* const email= $('#email').val(),
                nombre= $('#nombre').val(),
                password= $('password').val();

        const datos = new FormData();
        datos.append('email', email);
        datos.append('nombre', nombre);
        datos.append('password', password);

        var auxUrl= $(this).attr('action');
        
        xhr= new XMLHttpRequest();

        xhr.open('POST', auxUrl, true);

        xhr.onload= function(){
            if (this.status === 200){
                const resultado = JSON.parse(xhr.responseText);

                if (resultado.respuesta == 'exito'){
                    Swal.fire(
                        'Añadido!',
                        'Se ha creado el administrador correctamente',
                        'success'
                      );
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Usuario no disponible',
                      });
                }
            }
        }
        xhr.send(datos); */
    //});

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: datos,
            async: false,
            dataType: 'json',
            success: function(data){
                console.log("ENTRO");
                var resultado= $.parseJSON(data);
                if (resultado.respuesta == 'exito'){
                    Swal.fire(
                        'Añadido!',
                        'Se ha creado el administrador correctamente',
                        'success'
                      )
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Usuario no disponible',
                      })
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus, "Error: " + errorThrown);
            }
        });
    });

    $('#login-admin').on('submit',function(e){
        e.preventDefault();

        var datos= $(this).serializeArray();
        console.log("ENTRO");
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                var resultado= data;
                if (resultado.resputa == 'exito'){
                    Swal.fire(
                        'Añadido!',
                        'Se ha creado el administrador correctamente',
                        'success'
                      )
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Usuario no disponible',
                      })
                }
            }
        })
    });

    $('.recordarme').on('checkbox', function(){
        $('login-admin #user').attr('autocomplete','on');
        $('login-admin #pass').attr('autocomplete','on');
    });
});