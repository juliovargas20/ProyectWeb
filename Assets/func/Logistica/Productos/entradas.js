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
    const url = base_url + "Logistica/UnidProductsSearch/" + cod;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
      if (http.readyState == 4 && http.status == 200) {
        const res = JSON.parse(this.responseText);

        document.getElementById("UnidProduct").value = res.UNIDADES;
      }
    };
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

function RegisterEntries(search, quantInt, invoce) {
  const url = base_url + "Logistica/InsertEntriesProducts";
  const http = new XMLHttpRequest();
  let frm = new FormData();
  http.open("POST", url, true);
  frm.append("SearchProduct", search);
  frm.append("NBoleProduct", invoce);
  frm.append("QuantProduct", quantInt);
  http.send(frm);
  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo == "success") {
        RegisterNSerieProducts(res.id, search);
      }
    }
  };
}

function RegisterNSerieProducts(id_entries, search) {
  AddEntries.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
  AddEntries.disabled = true;

  const valuesArray = TagifyBasic.value.map((tag) => tag.value);
  const url = base_url + "Logistica/InsertSerieProducts";
  const http = new XMLHttpRequest();
  let frm = new FormData();
  http.open("POST", url, true);
  frm.append("SearchProduct", search);
  frm.append("NSerieProducts", JSON.stringify(valuesArray));
  frm.append("id_entriesINT", id_entries);
  http.send(frm);
  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      const res = JSON.parse(this.responseText);
      Swal.fire({
        icon: res.tipo,
        title: res.mensaje,
        showConfirmButton: true,
        timer: 3000,
        didClose: () => {
          if (res.tipo == "success") {
            AddEntries.innerHTML = `Agregar Entradas`;
            AddEntries.disabled = false;
            FrmEntriesProducts.reset();
            ModalOpenEntries.hide();
            TblEntriesProducts_data.ajax.reload();
          } else {
            // Restaurar el contenido original del botón
            AddEntries.innerHTML = "Guardar";
            btnSAddEntriesubmit.disabled = false;
          }
        },
      });
    }
  };
}

function NSerieView(id) {
  const url = base_url + "Logistica/AllSerieProductCod/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${row['NOMBRE']} - ${row['NSERIE']}
                <span class="badge rounded-pill bg-label-success">
                  <i class="mdi mdi-check-decagram"></i>
                </span>
            </li>
          `;
      });
      document.querySelector("#listSerieProducts").innerHTML = html;
      ModalOpenNseries.show();
    }
  };
  
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