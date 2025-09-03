document.addEventListener('DOMContentLoaded', () => {
    inicializarMateriales();
    cargarBodegas();
    cargarMonedas();

    document.getElementById('store').addEventListener('change', (e) => {
        const idBodega = e.target.value;
        cargarSucursales(idBodega);
    });
});

// Cargar materiales desde PHP y mostrarlos como checkboxes
function inicializarMateriales() {
    fetch('php/get_materials.php')
        .then(response => response.json())
        .then(materiales => {
            const contenedor = document.getElementById('materials');
            materiales.forEach(mat => {
                const etiqueta = document.createElement('label');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'materials[]';
                checkbox.value = mat.id;
                etiqueta.appendChild(checkbox);
                etiqueta.append(` ${mat.name_materials}`);
                contenedor.appendChild(etiqueta);
            });
        });
}

// Llenar el select de bodegas
function cargarBodegas() {
    fetch('php/get_store.php')
        .then(response => response.json())
        .then(bodegas => {
            const select = document.getElementById('store');
            bodegas.forEach(bodega => {
                const opcion = document.createElement('option');
                opcion.value = bodega.id;
                opcion.textContent = bodega.name_store;
                select.appendChild(opcion);
            });
        });
}

// Mostrar sucursales según bodega seleccionada
function cargarSucursales(idBodega) {
    const sucursalSelect = document.getElementById('branch');
    sucursalSelect.innerHTML = '<option value=""></option>';

    if (!idBodega) return;

    fetch(`php/get_branches.php?store_id=${idBodega}`)
        .then(response => response.json())
        .then(sucursales => {
            sucursales.forEach(suc => {
                const opcion = document.createElement('option');
                opcion.value = suc.id;
                opcion.textContent = suc.name_branch;
                sucursalSelect.appendChild(opcion);
            });
        });
}

// Llenar el select de monedas
function cargarMonedas() {
    fetch('php/get_coin_type.php')
        .then(response => response.json())
        .then(monedas => {
            const select = document.getElementById('coins');
            monedas.forEach(moneda => {
                const opcion = document.createElement('option');
                opcion.value = moneda.id;
                opcion.textContent = moneda.name_coins;
                select.appendChild(opcion);
            });
        });
}

// Validar si el código de producto ya existe
function validarCodigoExistente(codigo) {
    return fetch(`php/validation_products.php?code=${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => data.exists);
}

// Evento al hacer clic en el botón Guardar
document.getElementById('saveBtn').addEventListener('click', async () => {
    const code = document.getElementById('code').value.trim();
    const name = document.getElementById('name').value.trim();
    const store = document.getElementById('store').value;
    const branch = document.getElementById('branch').value;
    const coins = document.getElementById('coins').value;
    const price = document.getElementById('price').value.trim();
    const description = document.getElementById('description').value.trim();
    const materials = document.querySelectorAll('input[name="materials[]"]:checked');

    // Validaciones
    if (!code) return alert("El código del producto no puede estar en blanco.");
    if (code.length < 5 || code.length > 15) return alert("El código debe tener entre 5 y 15 caracteres.");
    if (!/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/.test(code)) return alert("El código debe contener letras y números.");

    const codigoExiste = await validarCodigoExistente(code);
    if (codigoExiste) return alert("El código ya está registrado.");

    if (!name) return alert("El nombre no puede estar vacío.");
    if (name.length < 2 || name.length > 50) return alert("El nombre debe tener entre 2 y 50 caracteres.");

    if (!store) return alert("Seleccione una bodega.");
    if (!branch) return alert("Seleccione una sucursal.");
    if (!coins) return alert("Seleccione una moneda.");

    if (!price) return alert("El precio no puede estar vacío.");
    if (!/^\d+(\.\d{1,2})?$/.test(price)) return alert("El precio debe ser un número positivo con hasta dos decimales.");

    if (materials.length < 2) return alert("Seleccione al menos dos materiales.");

    if (!description) return alert("La descripción no puede estar vacía.");
    if (description.length < 10 || description.length > 1000) {
        return alert("La descripción debe tener entre 10 y 1000 caracteres.");
    }

    enviarProducto();
});

// Guardar producto en la base de datos
function enviarProducto() {
    const formData = new FormData();
    formData.append('code', document.getElementById('code').value.trim());
    formData.append('name', document.getElementById('name').value.trim());
    formData.append('store', document.getElementById('store').value);
    formData.append('branch', document.getElementById('branch').value);
    formData.append('coins', document.getElementById('coins').value);
    formData.append('price', document.getElementById('price').value.trim());
    formData.append('description', document.getElementById('description').value.trim());

    const materialesSeleccionados = document.querySelectorAll('input[name="materials[]"]:checked');
    materialesSeleccionados.forEach(mat => formData.append('materials[]', mat.value));

    fetch('php/save_product.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.success) {
            alert("Producto guardado con éxito.");
            document.getElementById('formProducts').reset();
        } else {
            alert("Error al guardar: " + respuesta.message);
        }
    })
    .catch(error => {
        console.error("Error al guardar:", error);
        alert("Ocurrió un error al guardar el producto.");
    });
}