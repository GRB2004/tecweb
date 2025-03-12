// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
    
}

$(document).ready(function() {

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
    edit = false;
    console.log(edit)
    $('#product-result').hide();
    $('.btn btn-success my-2 my-sm-0').click(buscarProducto);
    function buscarProducto(e) {
        e.preventDefault();
        
        let search = $('#search').val().trim();
        
        // Verificamos que el campo no esté vacío
            $.ajax({
                url: './backend/product-search.php',
                type: 'GET',
                data: { search: search },
                dataType: 'json', // jQuery parsea el JSON automáticamente
                success: function(productos) {
                    // Verificar que se hayan recibido productos
                        let template = '';
                        let template_bar = '';
                        
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
                },
                error: function(xhr, status, error) {
                    console.error("Error en la petición AJAX:", error);
                }
            });
       
    }

$(document).ready(function() {
    // Asignamos la función buscarProducto al evento keyup del input
    //$('#search').on('keyup', buscarProducto);
    $('nav form').submit(buscarProducto);
    // Agregar Productos
    $('#product-form').submit(function(e) {
        e.preventDefault();
        
        try {
            // Validar y construir el objeto correctamente
            const nombre = $('#name').val().trim();
            const descripcion = $('#description').val().trim();
            const datosProducto = JSON.parse(descripcion);
            datosProducto.nombre = nombre;
            datosProducto.productId = $('#productId').val(); // Se lo agregas al objeto
            if (!nombre) throw new Error('El nombre es requerido');
            if (!descripcion) throw new Error('La descripción es requerida');

            let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
            console.log(url);

            $.ajax({
                url: url,
                type: 'POST',
                contentType: 'application/json', // Habilitado
                data: JSON.stringify(datosProducto),
                dataType: 'json',
                product: $('#productId').val()
            })
            .done(function(respuesta) {
                // Mostrar notificación
                console.log(respuesta);
                const template = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                
                $('#product-result')
                    .removeClass('d-none')
                    .addClass('card my-4 d-block')
                    .find('#container').html(template);
                
                listarProductos();
                $('#product-form').trigger('reset');
                edit = false;
                init()
            })
            .fail(function(xhr) {
                const error = xhr.responseJSON || { status: 'error', message: 'Error en el servidor' };
                $('#container').html(`
                    <li style="list-style: none;">status: ${error.status}</li>
                    <li style="list-style: none;">message: ${error.message}</li>
                `);
                $('#product-result').addClass('d-block');
            });
            
        } catch (error) {
            // Manejar errores de validación/parseo
            $('#container').html(`
                <li style="list-style: none;">status: error</li>
                <li style="list-style: none;">message: ${error.message}</li>
            `);
            $('#product-result').addClass('d-block');
        }
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
        $.post('./backend/product-single.php', {id}, function(response) {
            const product = JSON.parse(response);
            // Actualiza estos selectores según tu interfaz
            $('#name').val(product.nombre);
            $('#description').val(JSON.stringify(product.json, null, 2));
            $('#productId').val(product.id);
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