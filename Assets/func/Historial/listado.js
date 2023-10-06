let TblProceso;
var tableRows = document.querySelectorAll("#TblPr tbody tr");
document.addEventListener("DOMContentLoaded", function () {
  
  const cod = $("#url").val();
  TblProceso = $("#TblPr").DataTable({
    ajax: {
      url: base_url + `Historial/Listar${cod}`,
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

  //if (TblProceso.rows().data().length > 0) {
    $("#TblPr tbody").on("click", "tr", function () {
      // Obtiene los datos de la fila en la que se hizo clic
      var data = TblProceso.row(this).data();

      // Puedes acceder a los datos de la fila haciendo referencia a las columnas por nombre o índice
      var id = data.ID;
      window.location.href = base_url + "Historial/historial/" + id;
    });
  //}


  tableRows.forEach(function (row) {
    row.style.cursor = "pointer";
  });
});


