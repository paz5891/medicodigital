var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
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
        lengttxenu: [
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
                        title: 'Clientes'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Clientes'
                    },
		        ],
		"ajax":
				{
					url: '../controller/persona.php?op=listarc',
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
        url: "../controller/persona.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            if (datos == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cliente registrado',
                    showConfirmButton: false,
                    timer: 1500
                })

            } else if (datos == 3) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cliente actualizado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (datos == 4) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Cliente no se pudo actualizar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else if (datos == 2) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se pudo registrar el cliente',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            mostrarform(false);
            tabla.ajax.reload();
        }

    });
	limpiar();
}



function mostrar(idpersona)
{
	$.post("../controller/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento).trigger("change");
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);
		

 	})
}


//Función para desactivar registros
function eliminar(idpersona) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ELIMINAR CLIENTE',
        text: "Esta acción influye sobre los datos del Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/persona.php?op=eliminar", {
                idpersona: idpersona
            }, function (e) {
                tabla.ajax.reload();
            });
            swalWithBootstrapButtons.fire(
                'Mensaje!',
                'Eliminado con exito.',
                'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'CANCELAR',
                'Se cancelo la eliminación',
                'error'
            )
        }
    })

}
init();