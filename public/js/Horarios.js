$(document).ready(function() {
    let timetable = new Timetable();
    timetable.setScope(0, 23);

    $.get(pathname + "/gethorarios", function() {}).done(function(data) {
        timetable.addLocations(data.responsables);
        data.horarios.forEach(function(element) {
            let fechainicio = moment(element.fechainicio);
            let fechafin = moment(element.fechafin);
            let options = {
                data: {
                    id: element.id
                },
                onClick: function(event, timetable, clickEvent) {
                    getHorarioIndex(event, timetable, clickEvent);
                }
            };
            timetable.addEvent(
                element.lugar,
                element.name,
                fechainicio.toDate(),
                fechafin.toDate(),
                options
            );
        });
        let renderer = new Timetable.Renderer(timetable);
        renderer.draw(".timetable");
    });
});

$("#rangodefechas").daterangepicker(
    {
        startDate: new Date(),
        endDate: new Date(),
        drops: "up",
        timePicker: true,
        minDate: moment().startOf("day"),
        maxDate: moment().endOf("day"),
        locale: {
            format: "YYYY-MM-DD hh:mm A"
        }
    },
    function(start, end, label) {
        fechadesde1 = start.format("YYYY-MM-DD HH:mm:ss");
        fechahasta1 = end.format("YYYY-MM-DD HH:mm:ss");
    }
);

let id_responsable,
    id_tipoactividad,
    lugar,
    descripcion,
    fechainicio,
    fechafin,
    idHorario;
const ingresarhorarios = function() {
    id_responsable = $("#id_responsable").val();
    id_tipoactividad = $("#id_tipoactividad").val();
    lugar = $("#lugar").val();
    descripcion = $("#descripcion").val();
    fechainicio = $("#rangodefechas")
        .data("daterangepicker")
        .startDate.format("YYYY-MM-DD HH:mm");
    fechafin = $("#rangodefechas")
        .data("daterangepicker")
        .endDate.format("YYYY-MM-DD HH:mm");

    $.post(
        pathname + "/ingresarhorario",
        {
            id_responsable: id_responsable,
            id_tipoactividad: id_tipoactividad,
            lugar: lugar,
            descripcion: descripcion,
            fechainicio: fechainicio,
            fechafin: fechafin
        },
        function() {}
    ).done(function(data) {
        if (data.flag == 2) {
            $(".timetable").empty();
            let timetable = new Timetable();
            timetable.setScope(6, 23);
            timetable.addLocations(data.responsables);
            data.horarios.forEach(function(element) {
                let fechainicio = moment(element.fechainicio);
                let fechafin = moment(element.fechafin);
                let options = {
                    data: {
                        id: element.id
                    },
                    onClick: function(event, timetable, clickEvent) {
                        getHorarioIndex(event, timetable, clickEvent);
                    }
                };
                timetable.addEvent(
                    element.lugar,
                    element.name,
                    fechainicio.toDate(),
                    fechafin.toDate(),
                    options
                );
            });
            let renderer = new Timetable.Renderer(timetable);
            renderer.draw(".timetable");
            $("#posdet").animatescroll({
                padding: 200
            });
            $("#acontenido").empty();
            $("#actividadModal").modal();
            $("#acontenido").append(data.mensaje);
        }
    });
};

const getHorarioIndex = function(event, timetable, clickEvent) {
    $("#posdet2").animatescroll({
        padding: 100
    });
    console.log(event.options.data.id);
    $.get(
        pathname + "/getHorarioId",
        { id: event.options.data.id },
        function() {}
    ).done(function(data) {
        if (data.flag == 2) {
            $("#id_tipoactividad")
                .val(data.horario[0].idtactividad)
                .trigger("change");
            $("#id_responsable")
                .val(data.horario[0].iduser)
                .trigger("change");
            $("#lugar").val(data.horario[0].lugar);
            $("#descripcion").val(data.horario[0].descripcion);
            $("#rangodefechas")
                .data("daterangepicker")
                .setStartDate(moment(data.horario[0].fechainicio));
            $("#rangodefechas")
                .data("daterangepicker")
                .setEndDate(moment(data.horario[0].fechafin));
            $("#ingresar").prop("disabled", true);
            $("#actualizar").prop("disabled", false);
            $("#eliminar").prop("disabled", false);
            $("#idHorario").val(data.horario[0].idhorario);
        }
    });
};

const editarhorarios = function() {
    id_responsable = $("#id_responsable").val();
    id_tipoactividad = $("#id_tipoactividad").val();
    lugar = $("#lugar").val();
    descripcion = $("#descripcion").val();
    fechainicio = $("#rangodefechas")
        .data("daterangepicker")
        .startDate.format("YYYY-MM-DD HH:mm");
    fechafin = $("#rangodefechas")
        .data("daterangepicker")
        .endDate.format("YYYY-MM-DD HH:mm");
    idHorario = $("#idHorario").val();
    $.post(
        pathname + "/editarhorario",
        {
            id_responsable: id_responsable,
            id_tipoactividad: id_tipoactividad,
            lugar: lugar,
            descripcion: descripcion,
            fechainicio: fechainicio,
            fechafin: fechafin,
            idHorario: idHorario
        },
        function() {}
    ).done(function(data) {
        if (data.flag == 2) {
            $(".timetable").empty();
            let timetable = new Timetable();
            timetable.setScope(0, 23);
            timetable.addLocations(data.responsables);
            data.horarios.forEach(function(element) {
                let fechainicio = moment(element.fechainicio);
                let fechafin = moment(element.fechafin);
                let options = {
                    data: {
                        id: element.id
                    },
                    onClick: function(event, timetable, clickEvent) {
                        getHorarioIndex(event, timetable, clickEvent);
                    }
                };
                timetable.addEvent(
                    element.lugar,
                    element.name,
                    fechainicio.toDate(),
                    fechafin.toDate(),
                    options
                );
            });
            let renderer = new Timetable.Renderer(timetable);
            renderer.draw(".timetable");
            $("#posdet").animatescroll({
                padding: 200
            });
            cleanElements();
            $("#acontenido").empty();
            $("#actividadModal").modal();
            $("#acontenido").append(data.mensaje);
        }
    });
};

const eliminarhorarios = function() {
    idHorario = $("#idHorario").val();
    $.post(
        pathname + "/eliminarhorario",
        {
            idHorario: idHorario
        },
        function() {}
    ).done(function(data) {
        if (data.flag == 2) {
            $(".timetable").empty();
            let timetable = new Timetable();
            timetable.setScope(0, 23);
            timetable.addLocations(data.responsables);
            data.horarios.forEach(function(element) {
                let fechainicio = moment(element.fechainicio);
                let fechafin = moment(element.fechafin);
                let options = {
                    data: {
                        id: element.id
                    },
                    onClick: function(event, timetable, clickEvent) {
                        getHorarioIndex(event, timetable, clickEvent);
                    }
                };
                timetable.addEvent(
                    element.lugar,
                    element.name,
                    fechainicio.toDate(),
                    fechafin.toDate(),
                    options
                );
            });
            let renderer = new Timetable.Renderer(timetable);
            renderer.draw(".timetable");
            $("#posdet").animatescroll({
                padding: 200
            });
            cleanElements();
            $("#acontenido").empty();
            $("#actividadModal").modal();
            $("#acontenido").append(data.mensaje);
        }
    });
};

const cleanElements = function() {
    $("#lugar").val("");
    $("#descripcion").val("");
    $("#rangodefechas")
        .data("daterangepicker")
        .setStartDate(moment());
    $("#rangodefechas")
        .data("daterangepicker")
        .setEndDate(moment());
};
