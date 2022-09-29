var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

    $.post("../controller/cita.php?op=selectMedico", function (r) {
        $("#idmedico").html(r);
        //$('#idunidad').selectpicker('refresh');

    });

    $.post("../controller/cita.php?op=selectPaciente", function (r) {
        $("#pacienteovisitador").html(r);
        //$('#idunidad').selectpicker('refresh');

    });

    $.post("../controller/cita.php?op=selectSeguro", function (r) {
        $("#idseguro").html(r);
        //$('#idunidad').selectpicker('refresh');

    });

}

//Función limpiar
function limpiar()
{
	$("#idcita").val("");
    $("#idseguro").val("").trigger("change");
    $("#idmedico").val("").trigger("change");
    $("#tipocita").val("").trigger("change");
    $("#pacienteovisitador").val("").trigger("change");
	$("#visitador").val("");
	$("#asunto").val("");
	$("#telefono").val("");
	$("#fecha").val("");
    $("#hora").val("").trigger("hora");
    $("#estadocita").val("").trigger("estadocita");
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
                        title: 'Cita del Sistema  Clinica Génesis'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Cita del Sistema Clinica Génesis'
                    },
		        ],
		"ajax":
				{
					url: '../controller/cita.php?op=listar',
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
        url: "../controller/cita.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            if (datos == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cita registrada',
                    showConfirmButton: false,
                    timer: 2500
                })

            } else if (datos == 3) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cita actualizada',
                    showConfirmButton: false,
                    timer: 2500
                })
            } else if (datos == 4) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Ya existe una cita en este horario',
                    showConfirmButton: false,
                    timer: 2500
                })
            }else if (datos == 2) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Ya existe una cita en este horario',
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

function mostrar(idcita)
{
	$.post("../controller/cita.php?op=mostrar",{idcita : idcita}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

        $("#tipocita").val(data.tipocita).trigger("change");
        $("#idseguro").val(data.idseguro).trigger("change");
        $("#idmedico").val(data.idmedico).trigger("change");
        $("#pacienteovisitador").val(data.pacienteovisitador).trigger("change");
		$("#visitador").val(data.visitador);
		$("#asunto").val(data.asunto);
		$("#telefono").val(data.telefono);
		$("#fecha").val(data.fecha);
        $("#hora").val(data.hora).trigger("change");
        $("#estadocita").val(data.estadocita).trigger("change");
 		$("#idcita").val(data.idcita);

 	})
}

//Función para desactivar registros
function desactivar(idcita) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ELIMINAR CITA',
        text: "Esta acción influye sobre los datos del Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/cita.php?op=desactivar", {
                idcita: idcita
            }, function (e) {
                tabla.ajax.reload();
            });
            swalWithBootstrapButtons.fire(
                'Mensaje!',
                'Eliminada con exito.',
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
