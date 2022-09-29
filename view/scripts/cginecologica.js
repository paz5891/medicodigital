var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	});
 

    $.post("../controller/cginecologica.php?op=selectPaciente", function (r) {
        $("#idpaciente").html(r);
        //$('#idunidad').selectpicker('refresh');

    });
 
    $.post("../controller/cginecologica.php?op=selectSeguro", function (r) {
        $("#idseguro").html(r);
        //$('#idunidad').selectpicker('refresh');

    });
}
//Función limpiar
function limpiar()
{
    $("#idcginecologica").val("");
    $("#idpaciente").val("").trigger("change");
    $("#idseguro").val("").trigger("change");
    $("#mc").val("");
    $("#historia").val("");
    $("#peso").val("");
    $("#fur").val("");
    $("#temperatura").val("");
    $("#pa").val("");
    $("#fc").val("");
    $("#fr").val("");
    $("#examenmamas").val("");
    $("#examenginec").val("");
    $("#examenfisico").val("");

    $("#descripcionresexadiag").val("");
    $("#usgpelv").val("");
    $("#ic").val("");
    $("#tx").val("");
    $("#ordenexadiag").val("");
    $("#proximacita").val("");
    $("#montoacobrar").val("");
    $("#observaciones").val("");


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
                        title: 'Historia Clinica'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Historia Clinica'
                    },
		        ],
		"ajax":
				{
					url: '../controller/cginecologica.php?op=listar',
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
        url: "../controller/cginecologica.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            if (datos == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Consulta ginecológica registrada',
                    showConfirmButton: false,
                    timer: 1500
                })

            } else if (datos == 3) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Consulta ginecológica actualizada',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (datos == 4) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Consulta ginecológica no se pudo actualizar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else if (datos == 2) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se pudo registrar la Consulta ginecológica',
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

function mostrar(idcginecologica)
{
	$.post("../controller/cginecologica.php?op=mostrar",{idcginecologica : idcginecologica}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
        $("#idcginecologica").val(data.idcginecologica);
        $("#idpaciente").val(data.idpaciente).trigger("change");
        $("#idseguro").val(data.idseguro).trigger("change");
		$("#mc").val(data.mc);
		$("#historia").val(data.historia);
        $("#peso").val(data.peso);
        $("#fur").val(data.fur);
        $("#temperatura").val(data.temperatura);
        $("#pa").val(data.pa);
        $("#fc").val(data.fc);
        $("#fr").val(data.fr);
        $("#examenmamas").val(data.examenmamas);
        $("#examenginec").val(data.examenginec);
        $("#examenfisico").val(data.examenfisico);




        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("value", "../files/examendiagnosticoginecologica/" + data.resexadiag);
        $("#imagenactual").val(data.resexadiag);



        $("#descripcionresexadiag").val(data.descripcionresexadiag);
        $("#usgpelv").val(data.usgpelv);
        $("#ic").val(data.ic);
        $("#tx").val(data.tx);
        $("#ordenexadiag").val(data.ordenexadiag);
        $("#proximacita").val(data.proximacita);
        $("#montoacobrar").val(data.montoacobrar);
        $("#observaciones").val(data.observaciones);
     
        
 	})
}

//Función para desactivar registros
function desactivar(idcginecologica) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'DESACTIVAR CONSULTA GINECOLÓGICA',
        text: "Esta acción influye sobre los datos del Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Desactivar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/cginecologica.php?op=desactivar", {
                idcginecologica: idcginecologica
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
function activar(idcginecologica) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ACTIVAR CONSULTA GINECOLÓGICA',
        text: "Esta acción influye sobre los datos Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Activar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../controller/cginecologica.php?op=activar", {
                idcginecologica: idcginecologica
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
