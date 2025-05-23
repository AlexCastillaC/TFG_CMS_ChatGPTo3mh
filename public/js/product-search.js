$(document).ready(function(){
    $('#product-search-form').on('submit', function(e){
        e.preventDefault();
        console.log("Ejecutando búsqueda...");
        let query = $('#search-input').val();
        $('#search-results').html('<p>Cargando...</p>');
        $.ajax({
            url: '/api/productos/buscar',
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(data){
                console.log("Resultados de búsqueda:", data);
                let html = '';
                if(data.length > 0){
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
                } else {
                    html = '<p>No se encontraron productos.</p>';
                }
                $('#search-results').html(html);
            },
            error: function(xhr, status, error){
                console.error("Error en la búsqueda:", error);
                $('#search-results').html('<p>Error al buscar productos.</p>');
            }
        });
    });
});
