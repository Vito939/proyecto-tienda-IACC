//Elementos del DOM para busqueda y filtrado de productos.
const busquedaInput = document.getElementById("producto-search");
const botonBusqueda = document.getElementById("busqueda-button");
const resultadosContainer = document.getElementById("resultados-container");
const productosContainer = document.getElementById("productos-container"); // Contenedor de productos principal

//Elementos del Dom para notificaciones.
const notificacion = document.getElementById("notificacion-container");

//funcion para buscar productos por nombre.
function searchProducts() {
    const terminoBusqueda = busquedaInput.value.toLowerCase();
    resultadosContainer.innerHTML = '';

    // Si hay un término de búsqueda, oculta los productos principales, si no, los muestra
    if (terminoBusqueda.trim() !== '') {
        productosContainer.style.display = 'none';
    } else {
        productosContainer.style.display = 'block';
        return; // No hay nada que buscar, salimos de la función
    }

    const productosFiltrados = productos.filter(producto =>
        producto.nombre.toLowerCase().includes(terminoBusqueda)
    );

    if (productosFiltrados.length > 0) {
        productosFiltrados.forEach(producto => {
            const productoDiv = document.createElement("div");
            productoDiv.className = "producto";
            productoDiv.innerHTML = `
                <img src="../img/${producto.imagen}" alt="${producto.nombre}" class="producto-img">
                <h3>${producto.nombre}</h3>
                <p>${producto.descripcion}</p>
                <p><b>Precio: $${producto.precio.toLocaleString('es-CL')}</b></p>
                <a href="../src/logic/agregar_carrito.php?id=${producto.id}" class="boton-agregar">Agregar al carrito</a>
                
                <div class="reseña-container">
                    <h4>Dejar reseña</h4>
                    <form action="../src/logic/guardar_reseña.php" method="POST">
                        <input type="hidden" name="producto_id" value="${producto.id}">
                        <input type="hidden" name="producto_nombre" value="${producto.nombre}">
                        <select name="calificacion" required>
                            <option value="">---Califica el producto---</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                        <br>
                        <textarea name="reseña" rows="3" placeholder="Tu opinion..." required></textarea>
                        <br>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
                `;
                resultadosContainer.appendChild(productoDiv);
        });
    } else {
        resultadosContainer.innerHTML = '<p>No se encontraron productos.</p>';
    }
}

//Se añade el evento al boton de busqueda.
botonBusqueda.addEventListener("click", searchProducts);

//Se añade el evento para buscar con tecla "enter" y para limpiar si se borra la búsqueda
busquedaInput.addEventListener("keyup", (event) => {
    if (event.key === "Enter") {
        searchProducts();
    }
    if (busquedaInput.value.trim() === '') {
        searchProducts(); // Llama a la función para restaurar la vista original
    }
});

//Funcion para mostrar notificaciones
function mostrarNotificacion(mensaje, duracion = 3000) {
    notificacion.textContent = mensaje;
    notificacion.classList.add('visible');
    
    setTimeout(() => {
        notificacion.classList.remove('visible');
    }, duracion);
}

//Notificacion de promocion al cargar la página.
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        mostrarNotificacion('¡Bienvenido! Aprovecha un 10% de descuento en tu primera compra.', 5000);
    }, 1000);
});



