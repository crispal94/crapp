let tiporecurso;
let fechadesde1, fechahasta1;
$("#rangodefechas").daterangepicker(
    {
        startDate: new Date(),
        endDate: new Date()
    },
    function(start, end, label) {
        fechadesde1 = start.format("YYYY-MM-DD");
        fechahasta1 = end.format("YYYY-MM-DD");
    }
);

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
            targets: [7],
            visible: false
        }
        // {
        //     targets: [10],
        //     visible: false
        // }
    ]
});

let ftodos = false;
let flag = 0;

$("#ctodos").change(function() {
    if ($(this).is(":checked")) {
        $("#rangodefechas").prop("disabled", true);
        ftodos = true;
        flag = 1;
    } else {
        $("#rangodefechas").prop("disabled", false);
        ftodos = false;
        flag = 0;
    }
});

let adatai = [];
let fechadesde, fechahasta;
function consultar() {
    console.log("a");
    if (ftodos == false) {
        fechadesde = $("#rangodefechas")
            .data("daterangepicker")
            .startDate.format("YYYY-MM-DD");
        fechahasta = $("#rangodefechas")
            .data("daterangepicker")
            .endDate.format("YYYY-MM-DD");
    } else {
        fechadesde = "";
        fechahasta = "";
    }

    // if ($("#gtrabajo").val() == "N" && $("#usuario").val() == "N") {
    //     console.log("a");
    //     tiporecurso = "";
    // } else if ($("#gtrabajo").val() == "N" && $("#usuario").val() != "N") {
    //     tiporecurso = "u";
    // } else if ($("#gtrabajo").val() != "N" && $("#usuario").val() == "N") {
    //     tiporecurso = "gt";
    // } else {
    //     tiporecurso = "am";
    // }
    //let supervisor = $("#supervisor").val();
    let usuario = $("#usuario").val();
    let estado = $("#estado").val();

    let table = $("#actividades").DataTable();
    table.clear().draw();

    $.get(
        pathname + "/getactividades",
        {
            flag: flag,
            fechadesde: fechadesde,
            fechahasta: fechahasta,
            usuario: usuario,
            estado: estado
        },
        function() {}
    ).done(function(data) {
        let table = $("#actividades").DataTable();
        if (data.consulta.length > 0) {
            adatai = JSON.stringify(data.consulta);
            $("#adatai").val(adatai);
            table.rows.add(data.consulta); // Add new data
            table.columns.adjust().draw();
        }
    });
}

$("#proyectos tbody").on("click", "#seguimiento", function(event) {
    let table = $("#proyectos").DataTable();
    let $row = $(this).closest("tr");
    let data = table.row($row).data();
    let id = data[9];

    window.open(pathname + "/seguimiento/" + id, "_self");
});
