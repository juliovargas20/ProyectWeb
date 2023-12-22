const Frm = document.querySelector("#FrmAddProducts");
const btnSubmit = document.querySelector("#btnAddProduct");

const bsOffcanvas = new bootstrap.Offcanvas("#offcanvasAddProduct");

let TblProductos_data;
document.addEventListener("DOMContentLoaded", function () {
  TblProductos_data = $(".datatables-products").DataTable({
    ajax: {
      url: base_url + "Logistica/AllProducts",
      dataSrc: "",
    },
    columns: [
      { data: "", className: "text-center" },
      { data: "CODIGO_PRODUCTO", className: "text-center" },
      { data: "DESCRIPCION", className: "" },
      { data: "UNIDADES", className: "text-center" },
      { data: "SEDE", className: "text-center" },
      { data: "AREA", className: "text-center" },
      { data: "STOCK_MINIMO", className: "text-center" },
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
      {
        // Product name and product_brand
        targets: 2,
        responsivePriority: 1,
        render: function (data, type, full, meta) {
          var $name = full["NOMBRE"],
            $product_brand = full["DESCRIPCION"];
          // Creates full output for Product name and product_brand
          var $row_output =
            '<div class="d-flex justify-content-start align-items-center">' +
            '<div class="d-flex flex-column gap-1">' +
            '<h6 class="mb-0">' +
            $name +
            "</h6>" +
            '<small class="text-truncate text-muted">' +
            $product_brand +
            "</small>" +
            "</div>" +
            "</div>";
          return $row_output;
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
        text: '<i class="mdi mdi-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Agregar</span>',
        className:
          "add-new btn btn-primary ms-n1 waves-effect waves-light mx-2",
        action: function () {
          bsOffcanvas.show();
          Frm.classList.remove("was-validated");
          Frm.reset();
        },
      },
      {
        text: '<i class="mdi mdi-package-variant-closed-check me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Entradas</span>',
        className:
          "add-new btn btn-success ms-n1 waves-effect waves-light mx-2",
        action: function () {
          window.location.href = base_url + "Logistica/entradas_lima";
        },
      },
      {
        text: '<i class="mdi mdi-package-variant-closed-remove me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Salidas</span>',
        className: "add-new btn btn-danger ms-n1 waves-effect waves-light mx-2",
        action: function () {
          window.location.href = "";
        },
      },
      {
        text: '<i class="mdi mdi-file-document-multiple-outline me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Resumen</span>',
        className:
          "add-new btn btn-secondary ms-n1 waves-effect waves-light mx-2",
        action: function () {
          window.location.href = "";
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

  Frm.addEventListener("submit", handleFrmProduct, false);
});

function handleFrmProduct(event) {
  event.preventDefault();
  const FrmProduct = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmProduct.checkValidity()) {
    event.stopPropagation();
  } else {
    btnSubmit.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnSubmit.disabled = true;

    const frmData = new FormData(FrmProduct);

    fetch(base_url + "Logistica/InsertProductLima", {
      method: "POST",
      body: frmData,
    })
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error de red: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      Swal.fire({
        icon: data.tipo,
        title: data.mensaje,
        showConfirmButton: true,
        timer: 3000,
        didClose: () => {
          if (data.tipo == "success") {
            FrmProduct.reset();
            FrmProduct.classList.remove("was-validated");
            btnSubmit.innerHTML = "Guardar";
            btnSubmit.disabled = false;
            TblProductos_data.ajax.reload();
            bsOffcanvas.hide();
          } else if (data.tipo == "warning") {
            btnSubmit.innerHTML = "Guardar";
            btnSubmit.disabled = false;
          } else {
            // Restaurar el contenido original del botón
            btnSubmit.innerHTML = "Guardar";
            btnSubmit.disabled = false;
          }
        },
      });
    })
    .catch(error => {
      console.log('Error:', error.mensaje);
    })
  }
  FrmProduct.classList.add("was-validated");
}

function SimpleProducts(id) {
  fetch(base_url + "Logistica/SImpleProduct/" + id)
  .then(response => {
    if (!response.ok) {
      throw new Error(`Error de red: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
      Frm.ProID.value = data.ID_PRODUCTO;
      Frm.CodProduct.value = data.CODIGO_PRODUCTO;
      Frm.NameProduct.value = data.NOMBRE;
      Frm.DesProduct.value = data.DESCRIPCION;
      Frm.UnidProduct.value = data.UNIDADES;
      Frm.AreaProduct.value = data.AREA;
      Frm.StockProduct.value = data.STOCK_MINIMO;
      bsOffcanvas.show();
  })
  .catch(error => {
    console.log('Error:', error);
  })
}

function DeleteProduct(id){
  const url = base_url + "Logistica/DeleteProduct/" + id;
  Eliminar(
    "Deseas Eliminar el Producto",
    "El Producto será eliminado del sistema",
    "Sí",
    url,
    TblProductos_data
  );
}