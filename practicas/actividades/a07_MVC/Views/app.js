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
            // Si el campo está vacío, limpiar inmediatamente
            if (!$(this).val().trim()) {
                buscarProducto();
                return;
            }
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
    
    function buscarProducto() {
        const searchTerm = $('#search').val().trim();
        
        // Limpiar resultados inmediatamente al vaciar el campo
        if (!searchTerm) {
            $('#product-result').addClass('d-none');
            $('#products').html('');
            listarProductos(); // Forzar recarga de todos los productos
            return; // Salir de la función
        }
    
        // Solo hacer la petición si hay término de búsqueda
        $.ajax({
            url: './../Controller/product-search.php',
            type: 'GET',
            data: { search: searchTerm },
            success: function(html) {
                const $results = $(html);
                // Actualizar solo si el término coincide con la búsqueda actual
                if (searchTerm === $('#search').val().trim()) {
                    $('#product-result').replaceWith($results.filter('#product-result'));
                    $('#products').html($results.filter('#products').html());
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                $('#product-result').removeClass('d-none')
                    .find('#container')
                    .html("<li>Error al buscar productos</li>");
            }
        });
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
    // Asignamos la función mostrarProducto al evento keyup del input
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
                
                let url = edit === false ? './../Controller/product-add.php' : './../Controller/product-edit.php';
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: datosProducto,
                    dataType: 'json'
                })
                .done(function(respuesta) {
                    if (respuesta.html) {
                        $('#product-result')
                            .removeClass('d-none')
                            .addClass('card my-4 d-block')
                            .find('#container').html(respuesta.html);
                        
                        listarProductos();
                        $('#product-form').trigger('reset');
                        $('button.btn-primary').text("Agregar Producto").removeClass('btn-warning').addClass('btn-success');
                        edit = false;
                    }
                })
                .fail(function(xhr) {
                    console.error('Error en la petición:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        readyState: xhr.readyState
                    });
                    
                    let errorMessage = 'Error desconocido';
                    let errorHTML = '';
                    
                    try {
                        const errorResponse = JSON.parse(xhr.responseText);
                        errorMessage = errorResponse.message || errorResponse.html || 'Error en el servidor';
                        
                        errorHTML = `
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">ERROR (${errorResponse.status})</h4>
                            <p class="mb-0">${errorMessage}</p>
                            ${errorResponse.debug ? `
                            <hr>
                            <div class="text-muted small">
                                <p>Código error: ${errorResponse.error_code || 'N/A'}</p>
                                <p>Timestamp: ${errorResponse.debug.timestamp || 'N/A'}</p>
                            </div>
                            ` : ''}
                        </div>`;
                        
                    } catch (e) {
                        errorMessage = `${xhr.statusText} (${xhr.status})`;
                        errorHTML = `
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">ERROR CRÍTICO</h4>
                            <p class="mb-0">${errorMessage}</p>
                            <pre class="mt-2 small">${xhr.responseText}</pre>
                        </div>`;
                    }
                    
                    $('#container').html(errorHTML);
                    $('#product-result').removeClass('d-none').addClass('d-block');
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
                $('#container').html(`
                <li style="list-style: none;">status: error</li>
                <li style="list-style: none;">message: ${error.message || 'Error en la validación'}</li>
                `);
                $('#product-result')
                    .removeClass('d-none')
                    .addClass('card my-4 d-block');
            }
        });

    //Para mostrar los nombre que fueron agregados anteriormente

    $(document).on('input', '#name', function() {
        const $input = $(this);
        const searchQuery = $input.val().trim();
        
        if(searchQuery.length === 0) {
            $('#suggestions').html('').addClass('hidden');
            return;
        }
    
        $.ajax({
            url: './../Controller/product-sugerencias.php',
            type: 'GET',
            data: { 
                search: searchQuery,
                current_name: searchQuery // Enviar nombre actual para validación
            },
            success: function(html) {
                $('#suggestions')
                    .html(html)
                    .removeClass('hidden')
                    .css({
                        'position': 'absolute',
                        'z-index': '1000',
                        'background': 'white',
                        'width': $input.outerWidth() + 'px'
                    });
                
                // Ocultar después de 1 segundo sin interacción
                let timer = setTimeout(() => {
                    $('#suggestions').addClass('hidden');
                }, 1000);
                
                $('#suggestions').hover(
                    () => clearTimeout(timer),
                    () => timer = setTimeout(() => $('#suggestions').addClass('hidden'), 500)
                );
            },
            error: function(xhr) {
                $('#suggestions').html('<div class="text-danger">Error cargando sugerencias</div>');
            }
        });
    });
    
    // Seleccionar sugerencia
    $(document).on('click', '.suggestion-item', function() {
        $('#name').val($(this).text().replace('El nombre ya existe', '').trim());
        $('#suggestions').addClass('hidden');
    });

    // Eliminar productos
    $(document).on('click', '.product-delete', function () {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            let element = $(this).closest('tr');
            let id = element.attr('productId');
    
            $.get('./../Controller/product-delete.php', { id: id }, function (respuesta) {
                $('#product-result')
                    .removeClass('d-none')
                    .addClass('card my-4 d-block');
                
                // Usar el HTML generado desde el servidor
                $('#container').html(respuesta.html);
                
                // Actualizar lista de productos
                listarProductos();
            }, 'json');
        }
    });

    $(document).on('click', '.product-item', function() {
        let element = $(this)[0].parentElement.parentElement;
        let elementName = $(this)[0].parentElement;
        let id = $(element).attr('productId');
        let name = $(elementName).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
        console.log(id);
        $.post('./../Controller/product-single.php', {id}, function(response) {
            try {
                // Buscar el elemento con el JSON dentro de la respuesta HTML
                const jsonElement = $(response).find('#single-product-data');
                
                if (jsonElement.length === 0) {
                    console.error('Elemento #single-product-data no encontrado en la respuesta');
                    return;
                }
                
                const jsonString = jsonElement.html();
                const productData = JSON.parse(jsonString);
                
                // Actualiza la interfaz con los datos recibidos
                $('#name').val(productData.nombre);
                $('#productId').val(productData.id);
                $('#marca').val(productData.marca);
                $('#modelo').val(productData.modelo);
                $('#precio').val(productData.precio);
                $('#unidades').val(productData.unidades);
                $('#imagen').val(productData.imagen);
                $('#description').val(productData.detalles);
                edit = true;
                console.log(edit);
                console.log('Producto cargado correctamente:', productData);
            } catch (error) {
                console.error('Error al procesar la respuesta:', error);
                console.log('Respuesta recibida:', response);
            }
        });
    });
    
});
    

function listarProductos() {
    $.ajax({
        url: './../Controller/product-list.php',
        type: 'GET',
        dataType: 'html', // Esperamos HTML pero verificamos si es JSON en caso de error
        success: function(response) {
            try {
                // Intenta parsear como JSON solo si hay error
                if (typeof response === 'string' && response.startsWith('{')) {
                    const data = JSON.parse(response);
                    throw new Error(data.message);
                }
                
                // Actualizar solo el cuerpo de la tabla
                $('#products').html(response);
                $('#product-result').addClass('d-none');
            } catch (e) {
                console.error("Error procesando respuesta:", e);
                mostrarError(e.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error de red:", error);
            mostrarError("Error de conexión: " + error);
        }
    });
}

function mostrarError(mensaje) {
    const errorHTML = `
    <div class="alert alert-danger">
        <h4 class="alert-heading">ERROR</h4>
        <p class="mb-0">${mensaje}</p>
    </div>`;
    
    $('#product-result')
        .removeClass('d-none')
        .addClass('card my-4 d-block')
        .html(errorHTML);
}

    
});