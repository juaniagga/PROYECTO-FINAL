$(document).ready(function(){
    
    $('#crear-admin').on('submit',function(e){
        e.preventDefault();

        let datos= $(this).serializeArray();
        console.log("ENTRO");
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                console.log("ENTRO");
                var resultado= data;
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
            }
        })
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
});