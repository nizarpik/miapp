<?php /* Formulario principal */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="wrap">
        <h1>Formulario de Producto</h1>
        <form id="formProducto" autocomplete="off">
            <div class="grid">
                <div class="field">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" placeholder="Ej: PROD01K">
                </div>
                <div class="field">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Set Comedor">
                </div>

                <div class="field">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
                <div class="field">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option value="">Seleccione...</option>
                    </select>
                </div>

                <div class="field">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
                <div class="field">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio" placeholder="Ej: 1500 o 1500.50">
                </div>
            </div>

            <div class="field block">
                <span class="lbl">Material del Producto</span>
                <div class="checks">
                    <label><input type="checkbox" name="material[]" value="Plástico"> Plástico</label>
                    <label><input type="checkbox" name="material[]" value="Metal"> Metal</label>
                    <label><input type="checkbox" name="material[]" value="Madera"> Madera</label>
                    <label><input type="checkbox" name="material[]" value="Vidrio"> Vidrio</label>
                    <label><input type="checkbox" name="material[]" value="Textil"> Textil</label>
                </div>
            </div>

            <div class="field block">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    placeholder="Describe el producto (10 a 1000 caracteres)"></textarea>
            </div>

            <div class="actions">
                <button type="submit" id="btnGuardar">Guardar Producto</button>
            </div>
        </form>
    </div>
</body>
</html>
