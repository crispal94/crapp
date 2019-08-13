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
                targets: [8],
                visible: false
            }
        ]
    });
});

$("#actividades tbody").on("click", "#eliminar", function(event) {
    let table = $("#actividades").DataTable();
    let $row = $(this).closest("tr");
    let data = table.row($row).data();
    let id = data[8];
    $("#ccontenido").empty();
    $("#idactividad").val(id);
    $("#ccontenido").append("Desea eliminar esta actividad?");
    $("#confirmarmodal").modal();
});

$("#actividades tbody").on("click", "#finalizar", function(event) {
    var table = $("#actividades").DataTable();
    var $row = $(this).closest("tr");
    var data = table.row($row).data();
    var id = data[8];
    $("#ccontenidof").empty();
    $("#idactividadf").val(id);
    var mensaje = `<div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                    <label>Observación</label>
                                    <textarea name="observacion" id="observacion" rows="2" placeholder="..." class="form-control"></textarea>
                            </div>
                        </div>
                    </div>`;
    $("#ccontenidof").append("Desea finalizar esta actividad?");
    $("#ccontenidof").append(mensaje);
    $("#confirmarmodalf").modal();
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

function finalizaractividad() {
    let idactividad = $("#idactividadf").val();
    let observacion = $("#observacion").val();
    $.post(
        pathname + "/finalizaractividad",
        { idactividad: idactividad, observacion: observacion },
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
    $("#confirmarmodalf").modal("hide");
});

$("#exitomodal").on("hidden.bs.modal", function(e) {
    location.reload(true);
});
