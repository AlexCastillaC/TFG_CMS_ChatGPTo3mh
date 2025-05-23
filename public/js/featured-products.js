$(document).ready(function(){
    console.log("Cargando productos destacados...");
    $.ajax({
        url: '/api/productos/destacados',
        method: 'GET',
        dataType: 'json',
        beforeSend: function(){
            $('#featured-products').html('<p>Cargando...</p>');
        },
        success: function(data){
            console.log("Productos destacados:", data);
            let html = '';
            $.each(data, function(i, product){
                html += `
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        ${product.image ? `<img src="/storage/${product.image}" class="card-img-top" alt="${product.name}">` : ''}
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text">${product.description}</p>
                            <p class="card-text"><strong>Precio:</strong> $${parseFloat(product.price).toFixed(2)}</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-block add-to-cart" data-id="${product.id}">Añadir al carrito</button>
                        </div>
                    </div>
                </div>`;
            });
            $('#featured-products').html(html);
        },
        error: function(xhr, status, error){
            console.error("Error cargando productos destacados:", error);
            $('#featured-products').html('<p>Error al cargar productos destacados.</p>');
        }
    });
});
