
var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	//Cargamos los items al select cliente
}


//Función Listar
function listar()
{
 
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
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
                        title: 'Total C. Ginecológica'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Total C. Ginecológica'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'DESCARGAR EXCEL',
                        title: 'Total C. Ginecológica'
                    },
		        ],

	
		"ajax":
				{
					url: '../controller/cmedico.php?op=totalGinecologica',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
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
        


init();


