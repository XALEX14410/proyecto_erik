document.addEventListener("DOMContentLoaded", function() {
    // Función para manejar el toggle del estado
    function toggleEstatusAsistencia(boton) {
        const id = boton.getAttribute("data-id");
        const estadoActual = boton.getAttribute("data-estado");
        
        // Si el elemento ya votó
        // if (estadoActual === "Votó") {
        //     Swal.fire({
        //         title: "Estatus actual: Votó",
        //         text: "Esta persona ya tiene registrado su voto. ¿Deseas cambiar el estatus a 'Sin votar'?",
        //         icon: "question",
        //         showCancelButton: true,
        //         confirmButtonText: "Cambiar a Sin votar",
        //         cancelButtonText: "Cancelar",
        //         reverseButtons: true
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             procesarCambioEstatus(id, "Sin votar");
        //         }
        //     });
        // } 
        if (estadoActual === "Votó") {
            Swal.fire({
            title: "Ya está confirmado su voto",
            text: "Esta persona ya tiene registrado su voto. No es posible cambiar el estatus.",
            icon: "info",
            confirmButtonText: "Aceptar"
            });
        } 
        // Si el elemento no ha votado
        else {
            Swal.fire({
                title: "Voto sin confirmar",
                text: "¿Estás seguro de confirmar su voto?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Confirmar su voto",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    procesarCambioEstatus(id, "Votó");
                }
            });
        }
    }

    // Función para procesar el cambio de estatus
    function procesarCambioEstatus(id, nuevoEstatus) {
        // Mostrar loader mientras se procesa
        Swal.fire({
            title: "Actualizando...",
            html: "Por favor espere",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Llamada AJAX para actualizar el estado
        fetch('/coordinadores_y_testigos/controladores/update/confirmacion_de_voto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `idAsistencia=${id}&nuevoEstatus=${encodeURIComponent(nuevoEstatus)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            
            if (data.success) {
                // Mostrar mensaje de éxito
                Swal.fire({
                    title: "¡Éxito!",
                    text: data.message,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Recargar la página para ver cambios
                    location.reload();
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                text: error.message,
                icon: "error"
            });
            console.error("Error:", error);
        });
    }

    // Asignar eventos a todos los botones de estatus
    const botonesEstatus = document.querySelectorAll("[id^='btnEstatusAsistencia-']");
    botonesEstatus.forEach(boton => {
        boton.addEventListener("click", function(e) {
            e.preventDefault();
            toggleEstatusAsistencia(this);
        });
    });
});