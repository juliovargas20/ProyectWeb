const select = $("#Lideres");
const select2 = $("#Apoyo")
const flatpickrRange = document.querySelector('#flatpickr-range');

document.addEventListener("DOMContentLoaded", function () {

  if (select.length) {
    select.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: "Select value",
        dropdownParent: $this.parent(),
      });
    });
  }

  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: "Select value",
        dropdownParent: $this.parent(),
      });
    });
  }

  if (typeof flatpickrRange != undefined) {
    flatpickrRange.flatpickr({
      mode: 'range',
      rangeSeparator: ' hasta '
    });
  }


});

function Prueba() {
    const fecha = document.getElementById("flatpickr-range").value
    console.log(fecha);
}
