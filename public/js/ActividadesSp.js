$(document).ready(function() {
    $("#actividades").DataTable({
        scrollY: 200,
        scrollX: true,
        language: {
            lengthMenu: "Mostrar _MENU_ Registros",
            zeroRecords: "No hay registros...",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "No hay registros",
            infoFiltered: "(filtrados de _MAX_ registros totales)",
            search: "búsqueda:",
            paginate: {
                first: "First",
                last: "Last",
                next: "Sigue",
                previous: "Previo"
            }
        },
        columnDefs: [
            {
                targets: [6],
                visible: false
            }
        ]
    });
});

$("#actividades tbody").on("click", "#eliminar", function(event) {
    let table = $("#actividades").DataTable();
    let $row = $(this).closest("tr");
    let data = table.row($row).data();
    let id = data[5];
    $("#ccontenido").empty();
    $("#idactividad").val(id);
    $("#ccontenido").append("Desea eliminar esta actividad?");
    $("#confirmarmodal").modal();
});

function eliminaractividad() {
    let idactividad = $("#idactividad").val();
    $.post(
        pathname + "/eliminaractividad",
        { idactividad: idactividad },
        function() {}
    ).done(function(data) {
        if (data.flag == 2) {
            $("#econtenido").empty();
            $("#econtenido").append(data.mensaje);
            $("#exitomodal").modal();
        }
    });
}

$("#exitomodal").on("show.bs.modal", function(e) {
    $("#confirmarmodal").modal("hide");
});

$("#exitomodal").on("hidden.bs.modal", function(e) {
    location.reload(true);
});
