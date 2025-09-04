document.addEventListener("DOMContentLoaded", () => {
    cargarBodegas();
    cargarMonedas();

    const bodegaSel = document.getElementById("bodega");
    bodegaSel.addEventListener("change", cargarSucursales);

    document.getElementById("formProducto").addEventListener("submit", (e) => {
        e.preventDefault();
        if (validarFormulario()) {
            guardarProducto();
        }
    });
});

// Validaciones por JavaScript
function validarFormulario() {
    const codigo = document.getElementById("codigo").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const bodega = document.getElementById("bodega").value;
    const sucursal = document.getElementById("sucursal").value;
    const moneda = document.getElementById("moneda").value;
    const precio = document.getElementById("precio").value.trim();
    const materiales = document.querySelectorAll("input[name='material[]']:checked");
    const descripcion = document.getElementById("descripcion").value.trim();

    const regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/; // letras y números, 5-15
    const regexPrecio = /^(?:0|[1-9]\d*)(?:\.\d{1,2})?$/; // positivo con hasta 2 decimales

    if (codigo === "") { alert("El código del producto no puede estar en blanco."); return false; }
    if (!regexCodigo.test(codigo)) {
        // Cubrimos formato y longitud con el mismo regex
        alert("El código del producto debe contener letras y números y tener entre 5 y 15 caracteres.");
        return false;
    }

    if (nombre === "") { alert("El nombre del producto no puede estar en blanco."); return false; }
    if (nombre.length < 2 || nombre.length > 50) {
        alert("El nombre del producto debe tener entre 2 y 50 caracteres."); return false;
    }

    if (bodega === "") { alert("Debe seleccionar una bodega."); return false; }
    if (sucursal === "") { alert("Debe seleccionar una sucursal para la bodega seleccionada."); return false; }
    if (moneda === "") { alert("Debe seleccionar una moneda para el producto."); return false; }

    if (precio === "") { alert("El precio del producto no puede estar en blanco."); return false; }
    if (!regexPrecio.test(precio)) {
        alert("El precio del producto debe ser un número positivo con hasta dos decimales."); return false;
    }

    if (materiales.length < 2) { alert("Debe seleccionar al menos dos materiales para el producto."); return false; }

    if (descripcion === "") { alert("La descripción del producto no puede estar en blanco."); return false; }
    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert("La descripción del producto debe tener entre 10 y 1000 caracteres."); return false;
    }
    return true;
}

function guardarProducto() {
    const form = document.getElementById("formProducto");
    const formData = new FormData(form);

    fetch("guardar.php", { method: "POST", body: formData })
        .then(r => r.text())
        .then(msg => {
            alert(msg);
            if (msg.includes("éxito") || msg.includes("exito") || msg.includes("éxito")) {
                form.reset();
                // Dejar selects con su opción en blanco
                document.getElementById("sucursal").innerHTML = '<option value="">Seleccione...</option>';
            }
        })
        .catch(() => alert("Ocurrió un error de red al guardar."));
}

// Cargas dinámicas
function cargarBodegas() {
    fetch("obtener_bodegas.php")
        .then(r => r.json())
        .then(data => {
            const sel = document.getElementById("bodega");
            sel.innerHTML = '<option value="">Seleccione...</option>';
            data.forEach(b => sel.innerHTML += `<option value="${b.id}">${b.nombre}</option>`);
        })
        .catch(() => {});
}

function cargarSucursales() {
    const bodegaId = document.getElementById("bodega").value || "";
    const sel = document.getElementById("sucursal");
    sel.innerHTML = '<option value="">Seleccione...</option>';
    if (!bodegaId) return;

    fetch("obtener_sucursales.php?bodega_id=" + encodeURIComponent(bodegaId))
        .then(r => r.json())
        .then(data => {
            sel.innerHTML = '<option value="">Seleccione...</option>';
            data.forEach(s => sel.innerHTML += `<option value="${s.id}">${s.nombre}</option>`);
        })
        .catch(() => {});
}

function cargarMonedas() {
    fetch("obtener_monedas.php")
        .then(r => r.json())
        .then(data => {
            const sel = document.getElementById("moneda");
            sel.innerHTML = '<option value="">Seleccione...</option>';
            data.forEach(m => sel.innerHTML += `<option value="${m.id}">${m.nombre}</option>`);
        })
        .catch(() => {});
}
