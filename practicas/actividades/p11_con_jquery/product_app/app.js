$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    // Define la imagen por defecto
const imagenPorDefecto = "https://via.placeholder.com/150";

// Funciones de validación
function validarNombre() {
    const nombre = $("#name").val().trim();
    const errorLabel = $("#nameError");

    if (nombre === '') {
        errorLabel.text('El campo nombre es obligatorio').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        errorLabel.addClass('hidden');
        return true;
    }
}


function validarMarca() {
    const marca = $("#marca").val();
    const errorLabel = $("#marcaError");
    if (marca === '') {
        errorLabel.text('El campo marca es obligatorio').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarModelo() {
    const modelo = $("#modelo").val().trim();
    const regex = /^[a-zA-Z0-9]+$/;
    const errorLabel = $("#marcaError");

    if (modelo === '' || !regex.test(modelo)) {
        errorLabel.text('El campo modelo es obligatorio y debe ser alfánumerico').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarPrecio() {
    const precio = parseFloat($("#precio").val());
    const errorLabel = $("#precioError");
    if (isNaN(precio) || precio <= 99.99) {
        errorLabel.text('El campo nombre es obligatorio y debe ser mayor a 99.99').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarDetalles() {
    const detalles = $("#description").val().trim();
    const errorLabel = $("#detallesError");
    if (detalles.length > 250) {
        errorLabel.text('No debe ser mayor a 250 caracteres').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarUnidades() {
    const unidades = parseInt($("#unidades").val());
    const errorLabel = $("#unidadesError");
    if (isNaN(unidades) || unidades < 0) {
        errorLabel.text('El campo nombre es obligatorio').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        errorLabel.addClass('hidden');
        return true;
    }
}

// Validaciones al perder el foco
$("#name").blur(validarNombre);
$("#marca").blur(validarMarca);
$("#modelo").blur(validarModelo);
$("#precio").blur(validarPrecio);
$("#description").blur(validarDetalles);
$("#unidades").blur(validarUnidades);

// Evento submit
$('#product-form').submit(e => {
    e.preventDefault();

    const postData = {
        nombre: $('#name').val(),
        id: $('#productId').val(),
        marca: $('#marca').val(),
        modelo: $('#modelo').val(),
        precio: $('#precio').val(),
        unidades: $('#unidades').val(),
        imagen: $('#imagen').val(),
        detalles: $('#description').val()
    };

    // Cada vez que se hace click en el campo "nombre", se ejecuta su validación
    $('#name').on('click', function() {
        validarNombre();
    });

    // Validar el campo "marca" al hacer click
    $('#marca').on('click', function() {
        validarMarca();
    });

    // Validar el campo "modelo" al hacer click
    $('#modelo').on('click', function() {
        validarModelo();
    });

    // Validar el campo "precio" al hacer click
    $('#precio').on('click', function() {
        validarPrecio();
    });

    // Validar el campo "detalles" o descripción al hacer click
    $('#description').on('click', function() {
        validarDetalles();
    });

    // Validar el campo "unidades" al hacer click
    $('#unidades').on('click', function() {
        validarUnidades();
    });


    // Validaciones
    const nombreValido = validarNombre();
    const marcaValida = validarMarca();
    const modeloValido = validarModelo();
    const precioValido = validarPrecio();
    const detallesValidos = validarDetalles();
    const unidadesValidas = validarUnidades();

    if (nombreValido && marcaValida && modeloValido && precioValido && detallesValidos && unidadesValidas) {
        console.log("Producto validado correctamente. Enviando a la base de datos...");

        const imagenRuta = $("#imagen").val().trim() || imagenPorDefecto;
        
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
    
        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
            
            // Reiniciar formulario
            $('#name').val('');
            $('#marca').val('');
            $('#modelo').val('');
            $('#precio').val('');
            $('#unidades').val('');
            $('#imagen').val('');
            $('#description').val('');
            
            $('#product-result').show();
            $('#container').html(template_bar);
            $('button.btn-primary').text("Agregar Producto");
            listarProductos();
            edit = false;
        });
    } else {
        alert("Verifica los campos a llenar");
    }
});

    //Para mostrar los nombres que fueron agregados anteriormente
    $(document).on('input', '#name', function () {
        let searchQuery = $(this).val().trim();
        
        if (searchQuery.length === 0) {
            $('#suggestions').html('').addClass('hidden');
            return;
        }

        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search: searchQuery },
            success: function (response) {
                if (!response.error) {
                    const productos = JSON.parse(response);
                    let template = '';
                    nombre_insertado = $("#name").val()
                    if (productos.length > 0) {
                        template += '<ul>';
                        productos.forEach(producto => {
                            if (producto.nombre != nombre_insertado) {
                                template += `<li class="suggestion-item" style="color: black;">${producto.nombre}</li>`;
                            } else {
                                template += `<li class="suggestion-item" style="color: black;">El nombre ya existe</li>`;
                            }
                        });
                        template += '</ul>';
                        $('#suggestions').html(template).removeClass('hidden');

                        $('#suggestions ul').css('list-style', 'none');
                    } else {
                        $('#suggestions').html('<p>Sin resultados</p>').removeClass('hidden');
                    }
                }
            }
        });
    });

    // Ocultar sugerencias si el usuario hace clic fuera
    $(document).click(function (e) {
        if (!$(e.target).closest('#name, #suggestions').length) {
            $('#suggestions').addClass('hidden');
        }
    });

    

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id);
            // Se inserta la marca en el campo
            $('#marca').val(product.marca);
            // Se inserta el modelo en el campo
            $('#modelo').val(product.modelo);
            // Se inserta el precio en el campo
            $('#precio').val(product.precio);
            // Se inserta las unidades en el campo
            $('#unidades').val(product.unidades);
            // Se inserta la imagen en el campo
            $('#imagen').val(product.imagen);
            // Se inserta los detalles en el campo
            $('#description').val(product.detalles);
            // SE ELIMINA nombre, eliminado E id PARA PODER MOSTRAR EL JSON EN EL <textarea>
            //delete(product.nombre);
            //delete(product.eliminado);
            //delete(product.id);

            // SE CONVIERTE EL OBJETO JSON EN STRING
            //let JsonString = JSON.stringify(product,null,2);
            // SE MUESTRA STRING EN EL <textarea>
            //$('#description').val(JsonString);
            
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
            console.log(edit);
        });
        e.preventDefault();
    });    
});