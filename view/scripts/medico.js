var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

    $.post("../controller/medico.php?op=selectUsuario", function (r) {
        $("#idusuario").html(r);
        //$('#idunidad').selectpicker('refresh');

    });
    $.post("../controller/medico.php?op=selectEspecialidad", function (r) {
        $("#idespecialidad").html(r);
        //$('#idunidad').selectpicker('refresh');

    });
}

//Función limpiar
function limpiar()
{
	$("#idmedico").val("");
    $("#idusuario").val("");
	$("#idespecialidad").val("");
    $("#nombre").val("");
    $("#apellido").val("");
    $("#direccion").val("");
    $("#movil").val("");
    $("#sexo").val("");
    $("#fechanac").val("");
    $("#numero_documento").val("");
    $("#numcolegiatura").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
    tabla = $('#tbllistado').dataTable({
        /*"scrollY": 200,  navegar en el datatable
        "scrollX": true, */
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,

        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        lengthMenu: [
            [ 5, 10, 25, 50, -1 ],
            [ '5 filas','10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: [
                  {
                        extend: 'pageLength',
                        text: 'Longitud de la página',
                   },
                    {
                        extend: 'print',
                        text: 'IMPRIMIR',
                        title: 'Médico CIEG'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Médico CIEG'
                    },
		        ],
		"ajax":
				{
					url: '../controller/medico.php?op=listar',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
                "bDestroy": true,
                "iDisplayLength": 20, //Paginación
                "order": [[0, "desc"]], //Ordenar (columna,orden)
                language: {
                    zeroRecords: 'No hay registros para mostrar.',
                    info: "Mostrando página _PAGE_ de _PAGES_ páginas",
                    search: 'BUSCAR',
                    emptyTable: 'La tabla está vacia.',
                    "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Ultimo",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior",
                    }
                }
            }).DataTable();
        }
        
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controller/medico.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            if (datos == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Médico registrado',
                    showConfirmButton: false,
                    timer: 1500
                })

            } else if (datos == 3) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Médico actualizado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (datos == 4) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Médico no se pudo actualizar',
                    showConfirmButton: false,
                    timer: 2500
                })
            }else if (datos == 2) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se pudo registrar el Médico, asigne un usuario correcto',
                    showConfirmButton: false,
                    timer: 2500
                })
            }
            mostrarform(false);
            tabla.ajax.reload();
        }

    });
	limpiar();
}

function mostrar(idmedico)
{
	$.post("../controller/medico.php?op=mostrar",{idmedico : idmedico}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
        $("#idmedico").val(data.idmedico);
        $("#idusuario").val(data.idusuario).trigger("change");
        $("#idespecialidad").val(data.idespecialidad).trigger("change");
		$("#nombre").val(data.nombre);
        $("#apellido").val(data.apellido);
        $("#direccion").val(data.direccion);
        $("#movil").val(data.movil);
        $("#sexo").val(data.sexo).trigger("change");
        $("#fechanac").val(data.fechanac);
        $("#numero_documento").val(data.numero_documento);
        $("#numcolegiatura").val(data.numcolegiatura);

 	})
}

//Función para desactivar registros
function desactivar(idmedico) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'DESACTIVAR MÉDICO',
        text: "Esta acción influye sobre los datos del Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Desactivar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/medico.php?op=desactivar", {
                idmedico: idmedico
            }, function (e) {
                tabla.ajax.reload();
            });
            swalWithBootstrapButtons.fire(
                'Mensaje!',
                'Desactivado con exito.',
                'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'CANCELAR',
                'Se cancelo la desactivación',
                'error'
            )
        }
    })

}


//Función para activar registros
function activar(idmedico) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ACTIVAR MÉDICO',
        text: "Esta acción influye sobre los datos Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Activar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../controller/medico.php?op=activar", {
                idmedico: idmedico
            }, function (e) {
                tabla.ajax.reload();
            });
            swalWithBootstrapButtons.fire(
                'Mensaje!',
                'Activado con exito.',
                'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'CANCELAR',
                'Se cancelo la activación',
                'error'
            )
        }
    })
}


init();
