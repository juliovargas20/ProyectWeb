
const frm = document.querySelector("#FrmOT");

document.addEventListener('DOMContentLoaded', function () {
    frm.addEventListener('submit', handleFrmOT, false);
});

function handleFrmOT(event) {
    event.preventDefault();
    const FrmOT = event.target;
    const bsValidationForms = document.querySelectorAll(".needs-validation");
  
    if (!FrmOT.checkValidity()) {
      event.stopPropagation();
    } else {
      
    }
    FrmOT.classList.add("was-validated");
  }