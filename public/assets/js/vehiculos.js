document.addEventListener("DOMContentLoaded", () => {
    cargarVehiculos();
});

function cargarVehiculos() {
    let estado = document.getElementById("filtroEstado").value;
    let url = "api/vehiculos.php";
    if (estado) {
        url += "?estado=" + encodeURIComponent(estado);
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById("cuerpoTabla");
            tbody.innerHTML = "";

            data.forEach(auto => {
                let tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${auto.id}</td>
                    <td>${auto.modelo}</td>
                    <td>${auto.marca}</td>
                    <td>${auto.anio}</td>
                    <td>${auto.fecha_ingreso}</td>
                    <td>${auto.fecha_salida || 'No registrada'}</td>
                    <td>${auto.estado}</td>
                    <td>
                        <button onclick="eliminarVehiculo(${auto.id})">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => console.error("Error al cargar vehículos:", error));
}

function toggleFormulario() {
    let sec = document.getElementById("seccionFormulario");
    sec.style.display = sec.style.display === "none" ? "block" : "none";
}

function guardarVehiculo(event) {
    event.preventDefault();
    // Aquí puedes enviar los datos por fetch POST al controlador PHP
}

function eliminarVehiculo(id) {
    if (confirm("¿Estás seguro de eliminar este auto?")) {
        // Lógica para eliminar mediante fetch al backend
    }
}