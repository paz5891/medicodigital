function AbrirModalEditarContra() {
    $("#modal_editar_contra").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar_contra").modal('show');
    $("#modal_editar_contra").on('shown.bs.modal', function () {
        $("#txt_contra_actual_editar").focus();
    })
}


function AbrirModalEditarContra() {
    $("#modal_editar_contra").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar_contra").modal('show');
    $("#modal_editar_contra").on('shown.bs.modal', function () {
        $("#txt_contra_actual_editar").focus();
    })
}

function editar_contra() {
    var idusuario = $("#txtidprincipal").val();
    var contrabd = $("#txtcontra_db").val();
    var contraescrita = $("#txt_contra_actual_editar").val();
    var contranu = $("#txt_contra_nueva_editar").val();
    var contrare = $("#txt_contra_repet_editar").val();
    if (contraescrita.length == 0 || contranu.length == 0 || contrare.length == 0) {
        return Swal.fire("Mensaje de Advertencia", "Llene los campos que faltan", "warning");
    }
    if (contranu != contrare) {
        return Swal.fire("Mensaje de Advertencia", "Debes de introducir dos veces la misma clave para confirmarla", "warning");
    }

    $.ajax({
        url: '../controller/usuario/controlador_contra_modificar.php',
        type: 'POST',
        data: {
            idusuario: idusuario,
            contrabd: contrabd,
            contraescrita: contraescrita,
            contranu: contranu
        }
    }).done(function (resp) {
        alert(resp);
        if (resp > 0) {
            if (resp == 1) {
                $("#modal_editar_contra").modal('hide');
                limpiarCamposContra();
                Swal.fire("Mensaje de Confirmacion", "Datos correctos, Contraseña actualizada", "success").then((value) => {
                    //traerDatosUsuario();
                });
            } else {
                Swal.fire("Mensaje de Advertencia", "La contraseña no coicide con la que esta registrada en la base de datos", "error");
            }
        } else {
            Swal.fire("Mensaje de Advertencia", "No se pudo actualizar la Contraseña", "error");
        }
    })
}

//MODAL RESTABLECER CONTRASEÑA
function abrirModalRestablecerContra() {
    $("#modal_restablecer_contra").modal({ backdrop: 'static', keyboard: false })
    $("#modal_restablecer_contra").modal('show');
    $("#modal_restablecer_contra").on('shown.bs.modal', function () {
        $("#txt_email").focus();
    })
}
function limpiarCamposContra() {
    $("#txt_contra_actual_editar").val("");
    $("#txt_contra_nueva_editar").val("");
    $("#txt_contra_repet_editar").val("");
}

//FUNCION PARA RESTABLECER CONTRASEÑA
function restablecerContra() {
    var email = $("#txt_email").val();
    if (email.length == 0) {
        return Swal.fire("Mensaje de Error", "Ingrese un Correo", "warning");
    } else if (email.length > 0) {
        //expresion regular gmail
        var expReg = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        var valido = expReg.test(email);
        if (valido == false) {
            return Swal.fire("Mensaje de Error", "Correo Invalido", "warning");
        }
    }

    var caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
    var contrasena = "";
    for (var i = 0; i < 6; i++) {
        contrasena += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    //alert(contrasena);

    $.ajax({
        "url": "../controller/usuario/controlador_restablecer_contra.php",
        type: 'POST',
        data: {
            email: email,
            contrasena: contrasena
        }
    }).done(function (resp) {
        console.log(resp);
        if (resp > 0) {
            
            if (resp == 1) {
                limpiarrecuperarcontrasena();
                $("#modal_restablecer_contra").modal('hide');
                Swal.fire("Mensaje", "Contraseña restablecida con éxito, por favor revisa tu correo", "success");

            } else {
                Swal.fire("Mensaje de Error", "El correo ingresado no esta en nuestra base de datos", "warning");
            }
        } else {
            Swal.fire("Mensaje de Error", "No se pudo restablecer la contraseña, revisa tu conexion a internet", "warning");
        }

    })
}
//FIN DE FUNCION RESTABLECER CONTRASEÑA

function limpiarrecuperarcontrasena() {
    $("#txt_email").val("");
}