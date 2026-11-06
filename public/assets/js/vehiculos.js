document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.querySelector("#tabla-vehiculos tbody");
    const filtro = document.querySelector("#filtro-estado");

    async function cargar(estado = "") {
        let url = "api/vehiculos.php";
        if (estado) url += `?estado=${estado}`;
        const res = await fetch(url);
        const autos = await res.json();
        
        tabla.innerHTML = "";
        if (!Array.isArray(autos) || autos.length === 0) {
            tabla.innerHTML = `<tr><td colspan="7">Sin registros</td></tr>`;
            return;
        }

        autos.forEach(v => {
            tabla.innerHTML += `
                <tr>
                    <td>${v.id}</td>
                    <td>${v.marca}</td>
                    <td>${v.modelo}</td>
                    <td>${v.anio}</td>
                    <td>${v.fecha_ingreso}</td>
                    <td>${v.estado}</td>
                    <td>
                        <button onclick="cambiarEstado(${v.id}, '${v.estado}')">Cambiar Estado</button>
                        <button onclick="eliminar(${v.id})">Eliminar</button>
                    </td>
                </tr>`;
        });
    }

    if (filtro) filtro.addEventListener("change", e => cargar(e.target.value));
    cargar();
});

async function cambiarEstado(id, actual) {
    const nuevo = actual === "En mantenimiento" ? "reparado" : "En mantenimiento";
    const res = await fetch(`api/vehiculos.php/${id}`, {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ estado: nuevo })
    });
    if (res.ok) location.reload();
}

async function eliminar(id) {
    if (confirm("¿Eliminar vehículo?")) {
        const res = await fetch(`api/vehiculos.php/${id}`, { method: "DELETE" });
        if (res.ok) location.reload();
    }
}