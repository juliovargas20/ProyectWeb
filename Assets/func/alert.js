function AlertaPerzonalizada(type, mensaje) {
  Swal.fire({
    icon: type,
    title: mensaje,
    showConfirmButton: true,
    timer: 2000,
  });
}

function Eliminar(title, text, accion, url, tbl) {
  Swal.fire({
    title: title,
    text: text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: accion,
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          AlertaPerzonalizada(res.tipo, res.mensaje);
          tbl.ajax.reload();
        }
      };
    }
  });
}

// Función para obtener la velocidad de descarga actual en Mbps
function getDownloadSpeedMbps() {
  if (navigator.connection && navigator.connection.downlink) {
    // El valor de downlink es la velocidad en Mbps
    return navigator.connection.downlink;
  } else {
    // Valor por defecto si la información de velocidad no está disponible
    return 1; // 5 Mbps (puedes ajustar este valor según tus necesidades)
  }
}

// Función para calcular el tiempo de espera en función de la velocidad de descarga
function calculateTimeoutDuration(downloadSpeedMbps) {
  // Ajusta el tiempo de espera de acuerdo a tu preferencia.
  // Puedes multiplicar el tiempo base por un factor para obtener un tiempo de espera más adecuado.
  const baseTimeoutDuration = 1000; // Tiempo base de espera en milisegundos (2 segundos)
  const factor = 10; // Factor de ajuste (puedes cambiar este valor según tus necesidades)

  // Calcula el tiempo de espera multiplicando el tiempo base por el inverso de la velocidad de descarga.
  // Esto significa que cuanto mayor sea la velocidad de descarga, menor será el tiempo de espera.
  const timeoutDuration =
    baseTimeoutDuration * (1 / downloadSpeedMbps) * factor;

  return timeoutDuration;
}

