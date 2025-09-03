<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="card">
        <h1>Formulario de Producto</h1>
        <form id="formProducts">
            <div class="row">
                <div class="column">
                    <div class="form-group">
                        <label for="code">Código:</label>
                        <input type="text" id="code" name="code">
                    </div>

                    <div class="form-group">
                        <label for="store">Bodega:</label>
                        <select id="store" name="store">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="coins">Moneda:</label>
                        <select id="coins" name="coins">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="column">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="branch">Sucursal:</label>
                        <select id="branch" name="branch">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Precio:</label>
                        <input type="text" id="price" name="price">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Material del Producto:</label>
                <div class="checkboxes" id="materials">
                </div>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>

            <button type="button" id="saveBtn">Guardar Producto</button>
        </form>
    </div>

    <script src="javascript/javascript.js"></script>
</body>

</html>