const ModalPrF = document.querySelector("#ModalProcesoFin");
const ModalOpenPrF = new bootstrap.Modal(ModalPrF);

let TblFinalizadosData;

document.addEventListener("DOMContentLoaded", function () {
  $("#TblProcesosMS tbody, #TblProcesosMI tbody, #TblProcesosE tbody").on(
    "click",
    "tr",
    function () {
      const codigo = $(this).find("td:first").text();
      redirectToHistorial(codigo);
    }
  );

  TblFinalizadosData = $("#TblFinalizados").DataTable({
    ajax: {
      url: base_url + `Historial/ListFinal`,
      dataSrc: "",
    },
    columns: [
      { data: "ID", className: "text-center" },
      { data: "ID_PACIENTE", className: "text-center" },
      { data: "NOMBRES" },
      { data: "SUB_TRAB", className: "text-center" },
    ],
    columnDefs: [
      {
        // Total Invoice Amount
        targets: 0,
        visible: false,
      },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
    },
  });

  $("#TblFinalizados tbody").on("click", "tr", function () {
    // Obtiene los datos de la fila en la que se hizo clic
    var data = TblFinalizadosData.row(this).data();

    // Puedes acceder a los datos de la fila haciendo referencia a las columnas por nombre o índice
    var id = data.ID;
    window.location.href = base_url + "Historial/historial/" + id;
  });

});

function redirectToHistorial(codigo) {
  window.location.href = base_url + `Historial/listado/${codigo}`;
}

function AbrirProceso() {
  ModalOpenPrF.show();
}
