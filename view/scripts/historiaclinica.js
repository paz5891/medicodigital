var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	});

    $.post("../controller/historiaclinica.php?op=selectPaciente", function (r) {
        $("#idpaciente").html(r);
        //$('#idunidad').selectpicker('refresh');

    });

    $.post("../controller/historiaclinica.php?op=vacunas&id=", function (r) {
        $("#vacunas").html(r);
    });
}
//Función limpiar
function limpiar()
{
	$("#idhistoriaclinica").val("");
	$("#idpaciente").val("");
    $("#enfermedadingreso").val("");
    $("#antecedentesmedicos").val("");
    $("#antecedentesgin").val("");
    $("#antecedentesquir").val("");
    $("#antecedentesfam").val("");
    $("#alergias").val("");
    $("#medicamentos").val("");
    $("#habitos").val("");
    $("#observaciones").val("");
    $("#email").val("");
    $("#observaciones").val("");
    $("#nencargado").val("");
    $("#parentesco").val("");
    $("#tel_referencia").val("");
    $("#antecedentespren").val("");
    $("#gestas").val("");
    $("#hv").val("");
    $("#hm").val("");
    $("#fup").val("");
    $("#fupap").val("");
    $("#ciclos").val("");
    $("#planfam").val("");
    $("#infecciones").val("");
    $("#observaciones").val("");   
    $("#estatura").val("");


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
					url: '../controller/historiaclinica.php?op=listar',
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
        url: "../controller/historiaclinica.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            if (datos == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Historia Clinica registrada',
                    showConfirmButton: false,
                    timer: 1500
                })

            } else if (datos == 3) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Historia Clinica actualizada',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (datos == 4) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Historia Clinica no se pudo actualizar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else if (datos == 2) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se pudo registrar la Historia Clinica',
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

function mostrar(idhistoriaclinica)
{
	$.post("../controller/historiaclinica.php?op=mostrar",{idhistoriaclinica : idhistoriaclinica}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
        $("#idhistoriaclinica").val(data.idhistoriaclinica);
        $("#idpaciente").val(data.idpaciente).trigger("change");
        $("#enfermedadingreso").val(data.enfermedadingreso);
        $("#antecedentesmedicos").val(data.antecedentesmedicos);
        $("#antecedentesgin").val(data.antecedentesgin);
        $("#antecedentesquir").val(data.antecedentesquir);
        $("#antecedentespren").val(data.antecedentespren);
        $("#antecedentesfam").val(data.antecedentesfam);
        $("#alergias").val(data.alergias);
        $("#medicamentos").val(data.medicamentos);
    
        $("#habitos").val(data.habitos);
        $("#observaciones").val(data.observaciones);

        $("#gestas").val(data.gestas);
        $("#hv").val(data.hv);
        $("#hm").val(data.hm);
        $("#fup").val(data.fup);
        $("#fupap").val(data.fupap);
        $("#estatura").val(data.estatura);
        $("#ciclos").val(data.ciclos);
        $("#planfam").val(data.planfam);
        $("#infecciones").val(data.infecciones);
        $("#observacionesg").val(data.observacionesg);

        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("value", "../files/pdfhistorialantes/" + data.espediente);
        $("#imagenactual").val(data.espediente);
 	});

     $.post("../controller/historiaclinica.php?op=vacunas&id=" + idhistoriaclinica, function (r) {
        $("#vacunas").html(r);
    });


}

//Función para desactivar registros
function desactivar(idhistoriaclinica) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'DESACTIVAR HISTORIA CLINICA',
        text: "Esta acción influye sobre los datos del Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Desactivar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/historiaclinica.php?op=desactivar", {
                idhistoriaclinica: idhistoriaclinica
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
function activar(idhistoriaclinica) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ACTIVAR HISTORIA CLINICA',
        text: "Esta acción influye sobre los datos Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Activar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../controller/historiaclinica.php?op=activar", {
                idhistoriaclinica: idhistoriaclinica
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
