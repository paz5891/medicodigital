var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select categoria
	$.post("../controller/articulo.php?op=selectCategoria", function(r){
	            $("#idcategoria").html(r);
	});
    
	$.post("../controller/articulo.php?op=selectUbicacion", function(r){
	            $("#idubicacion").html(r);
	});
  
	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
    $("#idcategoria").val("").trigger("change");
    $("#idubicacion").val("").trigger("change");

	$("#nombre").val("");
	$("#descripcion").val("");
    $("#medida").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");
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
                        title: 'Artículo'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Artículo'
                    },
		        ],
		"ajax":
				{
					url: '../controller/articulo.php?op=listar',
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
        url: "../controller/articulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            if (datos == 1) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Artículo registrado',
                    showConfirmButton: false,
                    timer: 1500
                })

            } else if (datos == 3) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Artículo actualizado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (datos == 4) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Artículo no se pudo actualizar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else if (datos == 2) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se pudo registrar el Artículo',
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




function mostrar(idarticulo)
{
	$.post("../controller/articulo.php?op=mostrar",{idarticulo : idarticulo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
        $("#idcategoria").val(data.idcategoria).trigger("change");
        $("#idubicacion").val(data.idubicacion).trigger("change");

        $("#medida").val(data.medida);
		$("#nombre").val(data.nombre);
		$("#descripcion").val(data.descripcion);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
		$("#imagenactual").val(data.imagen);
 		$("#idarticulo").val(data.idarticulo);
 	

 	})
}
//Función para desactivar registros
function desactivar(idarticulo) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'DESACTIVAR ARTÍCULO',
        text: "Esta acción influye sobre los datos del Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Desactivar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/articulo.php?op=desactivar", {
                idarticulo: idarticulo
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
function activar(idarticulo) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ACTIVAR ARTÍCULO ',
        text: "Esta acción influye sobre los datos Sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Activar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../controller/articulo.php?op=activar", {
                idarticulo: idarticulo
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


//función para generar el código de barras


//Función para imprimir el Código de barras


init();