const formularios_ajax = document.querySelectorAll(".formularioAjax");

formularios_ajax.forEach((formularios) => {
  formularios.addEventListener("submit", function (e) {
    e.preventDefault();
    // Alerta
    Swal.fire({
      title: "¿Estas seguro?",
      text: "Confirmar los cambios",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let encabezados = new Headers();

        let config = {
          method,
          headers: encabezados,
          mode: "cors",
          cache: "no-cache",
          body: data,
        };
        fetch(action, config)
          .then((respuesta) => respuesta.json())
          .then((respuesta) => {
            return alertas_ajax(respuesta);
          });
      }
    });
  });
});

function alertas_ajax(alerta) {
  if (alerta.tipo == "simple") {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      icon: alerta.icon,
      confirmButtonText: "Aceptar",
    });
  } else if (alerta.tipo == "recargar") {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      icon: alerta.icon,
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.isConfirmed) {
        location.reload();
      }
    });
  } else if (alerta.tipo == "limpiar") {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      icon: alerta.icon,
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector(".formularioAjax").reset();
      }
    });
  } else if (alerta.tipo == "redireccionar") {
    window.location.href = alerta.url;
  }
}

//Boton para cerrar sesion

let btn_exit = document.getElementById("btn_exit");

btn_exit.addEventListener("click", function (e) {
  e.preventDefault();

  // Alerta
  Swal.fire({
    title: "¿Cerrar sesion?",
    text: "Estas por cerrar sesion y saldras del sistema",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, salir",
    cancelButtonText: "No, regresar",
  }).then((result) => {
    if (result.isConfirmed) {
      let url = this.getAttribute("href");
      window.location.href = url;
    }
  });
});
