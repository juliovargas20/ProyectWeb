const btnModal = document.querySelector("#ModalEntriesProduct");
const ModalOpenEntries = new bootstrap.Modal(btnModal);
const selectSearchProduct = $(".select2");

const tagifyBasicEl = document.querySelector("#NSerieProducts");
const TagifyBasic = new Tagify(tagifyBasicEl);

const AddEntries = document.querySelector("#btnEntriesProducts");
const FrmEntriesProducts = document.querySelector("#FrmEntriesProduct");

const btnModalNSerie = document.querySelector("#ModalSerieProduct");
const ModalOpenNseries = new bootstrap.Modal(btnModalNSerie);

let TblEntriesProducts_data;
document.addEventListener("DOMContentLoaded", function () {
  TblEntriesProducts_data = $(".datatables-EntriesProducts").DataTable({
    ajax: {
      url: base_url + "Logistica/AllEntriesProducts",
      dataSrc: "",
    },
    columns: [
      { data: "", className: "text-center" },
      { data: "ENT_BOLETA", className: "text-center" },
      { data: "ENT_FECHA", className: "text-center" },
      { data: "ENT_PRO_CODIGO", className: "text-center" },
      { data: "NOMBRE", className: "" },
      { data: "ENT_CANTIDAD", className: "text-center" },
      { data: "UNIDADES", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    columnDefs: [
      {
        // For Responsive
        className: "control",
        searchable: false,
        orderable: false,
        responsivePriority: 2,
        targets: 0,
        render: function (data, type, full, meta) {
          return "";
        },
      },
    ],
    order: [2, "asc"], //set any columns order asc/desc
    dom:
      '<"card-header d-flex border-top rounded-0 flex-wrap py-md-0"' +
      '<"me-5 ms-n2"f>' +
      '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center mb-3 mb-sm-0 gap-3"lB>>' +
      ">t" +
      '<"row mx-1"' +
      '<"col-sm-12 col-md-6"i>' +
      '<"col-sm-12 col-md-6"p>' +
      ">",
    lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
      sLengthMenu: "_MENU_",
      search: "",
      searchPlaceholder: "Buscar Productos",
    },
    // Buttons with Dropdown
    buttons: [
      {
        text: '<i class="mdi mdi-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Agregar Entradas </span>',
        className:
          "add-new btn btn-primary ms-n1 waves-effect waves-light mx-2",
        action: function () {
          ModalOpenEntries.show();
        },
      },
    ],
    // For responsive popup
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return "Detalles de " + data["DESCRIPCION"];
          },
        }),
        type: "column",
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data
            ? $('<table class="table"/><tbody />').append(data)
            : false;
        },
      },
    },
  });

  selectSearchProduct.each(function () {
    var $this = $(this);
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: "Seleccionar Producto",
      dropdownParent: $this.parent(),
    });
  });

  AddEntries.addEventListener("click", function (e) {
    e.preventDefault();

    const search = document.getElementById("SearchProduct").value;
    const quant = document.getElementById("QuantProduct").value;
    const quantInt = parseInt(quant, 10);
    const unid = document.getElementById("UnidProduct").value;
    const invoce = document.getElementById("NBoleProduct").value;

    if (
      search == "" ||
      quantInt == 0 ||
      unid == "" ||
      invoce == "" ||
      TagifyBasic.value.length === 0 ||
      quant == ""
    ) {
      Swal.fire({
        icon: "warning",
        title: "Campos Vacíos",
        showConfirmButton: true,
        timer: 2000,
      });
    } else {
      if (TagifyBasic.value.length === quantInt) {
        RegisterEntries(search, quantInt, invoce);
      } else {
        Swal.fire({
          icon: "warning",
          title:
            "La cantidad de numero de Serie debe ser igual a la cantidad ingresada",
          showConfirmButton: true,
          timer: 3000,
        });
      }
    }
  });
});

function onChangUnid() {
  const cod = document.getElementById("SearchProduct").value;
  if (cod == "") {
    document.getElementById("UnidProduct").value = "";
  } else {

    fetch(base_url + "Logistica/UnidProductsSearch/" + cod)
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error de red: ${response.status}`);
      }
      return response.json(response);
    })
    .then(data => {
      document.getElementById("UnidProduct").value = data.UNIDADES;
    })
    .catch(error => {
      console.log("Error:", error);
    })

  }
}

function onChange(e) {
  // outputs a String
  //console.log(e.target.value)
  const val = e.target.value;
  const etiquetas = val.split(","); // Suponiendo que las etiquetas están separadas por comas
  const cantidadEtiquetas = etiquetas.length;
  console.log(`La cantidad de etiquetas es: ${cantidadEtiquetas}`);
}

function RegisterEntries() {

  let frmData = new FormData();
  frmData.append("id_producto", document.getElementById("SearchProduct").value);
  frmData.append("serie", document.getElementById("QuantProduct").value);

  fetch(base_url + "Logistica/RegisterProductsEntries", {

  })

}

function DeleteEntries(id) {
  const url = base_url + "Logistica/DeleteEntriesByID/" + id;
  Eliminar(
    "Deseas Eliminar la Entrada Agregada",
    "La Entrada será eliminado del sistema",
    "Sí",
    url,
    TblEntriesProducts_data
  );
}