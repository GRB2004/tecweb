$(document).ready(function() {

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
    edit = false;
    console.log(edit)
    $('#product-result').hide();
    //$('.btn btn-success my-2 my-sm-0').click(buscarProducto);

    // Al cargar el documento
    $(document).ready(function() {
        // Vincula el evento keyup al campo de búsqueda
        $('#search').on('keyup', function() {
            // Puedes añadir un retraso para evitar muchas peticiones
            clearTimeout(this.timer);
            this.timer = setTimeout(function() {
                buscarProducto();
            }, 300); // 300ms de retraso para evitar peticiones en cada pulsación
        });
        
        // Mantén el submit para cuando alguien presione Enter
        $('nav form').submit(function(e) {
            e.preventDefault();
            buscarProducto();
        });
    });
    
    // Modifica la función para que no requiera el evento
function buscarProducto() {
    if($('#search').val()) {
        let search = $('#search').val().trim();
    
        // Verificamos que el campo no esté vacío
        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search: search },
            dataType: 'json',
            success: function(productos) {
                let template = '';
                let template_bar = '';
                
                if (productos.length > 0) {
                    $.each(productos, function(i, producto) {
                        // Construir una lista con la descripción del producto
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                        
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td>
                                    <ul>${descripcion}</ul>
                                </td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                        
                        template_bar += `<li>${producto.nombre}</li>`;
                    });
                    
                    // Actualizar la visibilidad del contenedor de resultados
                    $("#product-result").attr("class", "card my-4 d-block");
                    $("#container").html(template_bar);
                    $("#products").html(template);
                } else {
                    // Manejar cuando no hay resultados
                    $("#product-result").attr("class", "card my-4 d-block");
                    $("#container").html("<li>No se encontraron productos</li>");
                    $("#products").html("");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                $("#product-result").attr("class", "card my-4 d-block");
                $("#container").html("<li>Error al buscar productos</li>");
            }
        });
    } else {
        // Si el campo está vacío, puedes mostrar todos los productos o limpiar resultados
        $("#product-result").attr("class", "card my-4 d-none");
        $("#container").html("");
        $("#products").html("");
        // O si prefieres, cargar todos los productos:
        listarProductos();
    }
}


// Define la imagen por defecto
const imagenPorDefecto = "https://via.placeholder.com/150";

// Funciones de validación
function validarNombre() {
    const nombre = $("#name").val().trim();
    const errorLabel = $("#nameError");

    if (nombre === '') {
        $('#name').css('border', '1px solid red');
        errorLabel.text('El campo nombre es obligatorio').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        $('#name').css('border', '1px solid green');
        errorLabel.addClass('hidden');
        return true;
    }
}


function validarMarca() {
    const marca = $("#marca").val();
    const errorLabel = $("#marcaError");
    if (marca === '') {
        $('#marca').css('border', '1px solid red');
        errorLabel.text('El campo marca es obligatorio').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        $('#marca').css('border', '1px solid green');
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarModelo() {
    const modelo = $("#modelo").val().trim();
    const regex = /^[a-zA-Z0-9]+$/;
    const errorLabel = $("#modeloError");

    if (modelo === '' || !regex.test(modelo)) {
        $('#modelo').css('border', '1px solid red');
        errorLabel.text('El campo modelo es obligatorio y debe ser alfánumerico').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        $('#modelo').css('border', '1px solid green');
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarPrecio() {
    const precio = parseFloat($("#precio").val());
    const errorLabel = $("#precioError");
    if (isNaN(precio) || precio <= 99.99) {
        $('#precio').css('border', '1px solid red');
        errorLabel.text('El campo nombre es obligatorio y debe ser mayor a 99.99').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        $('#precio').css('border', '1px solid green');
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarDetalles() {
    const detalles = $("#description").val().trim();
    const errorLabel = $("#detallesError");
    if (detalles.length > 250) {
        $('#description').css('border', '1px solid red');
        errorLabel.text('No debe ser mayor a 250 caracteres').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        $('#description').css('border', '1px solid green');
        errorLabel.addClass('hidden');
        return true;
    }
}

function validarUnidades() {
    const unidades = parseInt($("#unidades").val());
    const errorLabel = $("#unidadesError");
    if (isNaN(unidades) || unidades < 0) {
        $('#unidades').css('border', '1px solid red');
        errorLabel.text('El campo nombre es obligatorio').removeClass('hidden').css('color', 'red');
        return false;
    } else {
        $('#unidades').css('border', '1px solid green');
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

$(document).ready(function() {
    // Asignamos la función buscarProducto al evento keyup del input
    //$('#search').on('keyup', buscarProducto);
    $('nav form').submit(buscarProducto);
    // Agregar Productos
    $('#product-form').submit(function(e) {
        e.preventDefault();
        
        try {

            const datosProducto = {
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
                
                let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
            console.log(url);

            $.ajax({
                url: url,
                type: 'POST',
                data: datosProducto,
                dataType: 'json'
            })
            .done(function(respuesta) {
                // Mostrar notificación
                console.log(respuesta);
                const template = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                    <li style="list-style: none;">status: Validación exitosa</li>
                `;
                
                $('#product-result')
                    .removeClass('d-none')
                    .addClass('card my-4 d-block')
                    .find('#container').html(template);
                
                listarProductos();
                $('#product-form').trigger('reset');
                $('button.btn-primary').text("Agregar Producto");
                edit = false;
            })
            .fail(function(xhr) {
                const error = xhr.responseJSON || { status: 'error', message: 'Error en el servidor' };
                $('#container').html(`
                    <li style="list-style: none;">status: ${error.status}</li>
                    <li style="list-style: none;">message: ${error.message}</li>
                    
                `);
                $('#product-result').addClass('d-block');
            });
                
            } else {
                $('#container').html(`
                <li style="list-style: none;">status: error</li>
                <li style="list-style: none;">message: Error en la validación</li>
                `);
                $('#product-result').addClass('d-block');
            }
            
        } catch (error) {
            // Manejar errores de validación/parseo
            
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
                                setTimeout(function() {
                                    $('#suggestions').addClass('hidden');
                                }, 1000); 
                                
                            } else {
                                template += `<li class="suggestion-item" style="color: black;">El nombre ya existe</li>`;
                            }
                        });
                        template += '</ul>';
                        $('#suggestions').html(template).removeClass('hidden');

                        $('#suggestions ul').css('list-style', 'none');
                    } else {
                        $('#suggestions').html('<p style="color: black;">Sin coincidencias</p>').removeClass('hidden');

                        // Opcionalmente, puedes ocultar el mensaje después de un tiempo
                    setTimeout(function() {
                        $('#suggestions').addClass('hidden');
                    }, 1000); 
                    }
                }
            }
        });
    });

    // Eliminar productos
    $(document).on('click', '.product-delete', function () {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            let element = $(this).closest('tr');
            let id = element.attr('productId');
    
            $.get('./backend/product-delete.php', { id: id }, function (response) {
                // Convertir la respuesta a objeto JSON (necesario si el servidor no envía cabeceras JSON)
                let respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                
                // Crear plantilla para la barra de estado
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                
                // Mostrar la barra de estado y actualizar contenido
                $('#product-result')
                    .removeClass('d-none')
                    .addClass('card my-4 d-block');
                
                $('#container').html(template_bar);
                
                // Actualizar lista de productos
                listarProductos();
            }, 'json') // Forzar jQuery a interpretar la respuesta como JSON
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud:", textStatus, errorThrown);
            });
        }
    });

    $(document).on('click', '.product-item', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
        $.post('./backend/product-single.php', {id}, function(response) {
            const product = JSON.parse(response);
            // Actualiza estos selectores según tu interfaz
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
            edit = true;
            console.log(edit);
        });
    });
    
});
    

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function (response) {
                let products = JSON.parse(response);
                let template = '';
                products.forEach(product => {
                    template += `
                        <tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>
                                <a href="#" class="product-item">${product.nombre}</a>
                            </td>
                            <td>${product.detalles}</td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `
                });
                $('#products').html(template);
            }
        });
    }

    
});