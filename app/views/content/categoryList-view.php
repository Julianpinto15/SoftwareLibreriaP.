<div class="container">
    <div class="position-contenido">
        <div class="position-buttom">
            <button class="btn-registrar btn btn-primary mb-4" onclick="abrirModalRegistroCategoria()">
                Registrar Nueva Categoría
            </button>
        </div>

        <div class="search-container-buscador">
            <div class="search-group-buscador">
                    <i class="bi bi-search search-icon-buscador"></i>
                    <input type="text" id="buscador-categoria" class="search-input-buscador" placeholder="Buscar categoría por nombre o ubicación...">
            </div>
        </div>

        <div class="content-name">
            <div class="container-fluid mb-4">
                <h1 class="text-titulo">Categorías</h1>
                <h2 class="h5 text-muted">Gestión de Categorías</h2>
            </div>
        </div>
    </div>

    <!-- Lista de Categorías -->
    <div id="lista-categorias" class="mt-4">
        <!-- Aquí se cargará la lista de categorías -->
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registroCategoriaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-model_title">Registrar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-registro-categoria">
                        <input type="hidden" name="modulo_categoria" value="registrar">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Nombre</label>
                            <input class="form-control text-model_input" type="text" name="categoria_nombre" 
                                   pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Ubicación</label>
                            <input class="form-control text-model_input" type="text" name="categoria_ubicacion" 
                                   pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary text-model" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success text-model">Registrar Categoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Actualización -->
    <div id="modal-editar-categoria" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-model_title">Actualizar Categoría</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="cerrarModalEditarCategoria()"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-edicion-categoria" method="POST">
                        <input type="hidden" name="modulo_categoria" value="actualizar">
                        <input type="hidden" id="categoria_id" name="categoria_id">

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-model">Nombre</label>
                            <input id="edit_categoria_nombre" class="form-control form-control-lg text-model_input" 
                                   type="text" name="categoria_nombre" 
                                   pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-model">Ubicación</label>
                            <input id="edit_categoria_ubicacion" class="form-control form-control-lg text-model_input" 
                                   type="text" name="categoria_ubicacion" 
                                   pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-lg px-4 text-model">Actualizar Categoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para abrir el Modal de Registro de Categoría
    function abrirModalRegistroCategoria() {
        var modal = new bootstrap.Modal(document.getElementById('registroCategoriaModal'));
        modal.show();
    }

    // Función para cerrar el Modal de Registro de Categoría
    function cerrarModalRegistroCategoria() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('registroCategoriaModal'));
        modal.hide();
        document.getElementById('form-registro-categoria').reset();
    }

    // Función para abrir el Modal de Edición de Categoría
    function abrirModalEditarCategoria(categoria) {
        document.getElementById('categoria_id').value = categoria.categoria_id;
        document.getElementById('edit_categoria_nombre').value = categoria.categoria_nombre;
        document.getElementById('edit_categoria_ubicacion').value = categoria.categoria_ubicacion;

        var modal = new bootstrap.Modal(document.getElementById('modal-editar-categoria'));
        modal.show();
    }

    // Función para cerrar el Modal de Edición de Categoría
    function cerrarModalEditarCategoria() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('modal-editar-categoria'));
        modal.hide();
        $('#form-edicion-categoria')[0].reset();
    }

    // Función para cargar la lista de categorías
   // Función para cargar la lista de categorías con soporte para paginación y búsqueda
function cargarCategorias(pagina = 1, busqueda = '') {
    $.ajax({
        url: '<?= APP_URL ?>app/ajax/categoriaAjax.php',
        type: 'POST',
        data: {
            modulo_categoria: 'listar',
            pagina: pagina,
            registros: 10,
            url: 'categoria', // O la URL base que uses para la paginación
            busqueda: busqueda
        },
        success: function(response) {
            $('#lista-categorias').html(response);
            
            // Agregar eventos a los enlaces de paginación
            $('.pagination .page-link').on('click', function(e) {
                e.preventDefault();
                if ($(this).attr('aria-disabled') !== 'true') {
                    const href = $(this).attr('href');
                    // Extraer el número de página de la URL (formato: url/{pagina}/)
                    const match = href.match(/\/(\d+)\//);
                    if (match && match[1]) {
                        cargarCategorias(parseInt(match[1]), busqueda);
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error cargando categorías:", error);
            $('#lista-categorias').html('<div class="alert alert-danger">Error al cargar las categorías</div>');
        }
    });
}

    // Manejador para el formulario de registro
    $('#form-registro-categoria').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= APP_URL ?>app/ajax/categoriaAjax.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                const resp = JSON.parse(response);
                if (resp.tipo === "limpiar") {
                    cerrarModalRegistroCategoria();
                    cargarCategorias();
                    
                    Swal.fire({
                        icon: resp.icono || 'info',
                        title: resp.titulo,
                        text: resp.texto,
                        width: '400px',
                        padding: '2em',
                        customClass: {
                            title: 'fs-4',
                            htmlContainer: 'fs-4',
                            confirmButton: 'fs-5'
                        },
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            }
        });
    });

    // Manejador para el formulario de edición
    $('#form-edicion-categoria').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize() + "&modulo_categoria=actualizar";
        
        $.ajax({
            url: '<?= APP_URL ?>app/ajax/categoriaAjax.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const resp = JSON.parse(response);
                if (resp.tipo === "recargar") {
                    cerrarModalEditarCategoria();
                    cargarCategorias();
                    
                    Swal.fire({
                        icon: resp.icono || 'info',
                        title: resp.titulo,
                        text: resp.texto,
                        width: '400px',
                        padding: '2em',
                        customClass: {
                            title: 'fs-4',
                            htmlContainer: 'fs-5',
                            confirmButton: 'fs-5'
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la categoría. Por favor, intente nuevamente.'
                });
            }
        });
    });

    // Función para eliminar una categoría
    function eliminarCategoria(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea eliminar esta categoría?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            width: '400px',
            padding: '2em',
            customClass: {
                title: 'fs-4',
                htmlContainer: 'fs-5',
                confirmButton: 'fs-5',
                cancelButton: 'fs-5',
                popup: 'custom-popup'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= APP_URL ?>app/ajax/categoriaAjax.php',
                    type: 'POST',
                    data: {
                        modulo_categoria: 'eliminar',
                        categoria_id: id
                    },
                    success: function(response) {
                        const resp = JSON.parse(response);
                        Swal.fire({
                            icon: resp.icono || 'info',
                            title: resp.titulo,
                            text: resp.texto,
                            width: '400px',
                            padding: '2em',
                            customClass: {
                                title: 'fs-4',
                                htmlContainer: 'fs-5',
                                confirmButton: 'fs-5'
                            }
                        }).then(() => {
                            if (resp.tipo === "recargar") {
                                cargarCategorias();
                            }
                        });
                    }
                });
            }
        });
    }

    // Cargar la lista de categorías al cargar la página
    $(document).ready(function() {
        cargarCategorias();
    });

    // Buscador en tiempo real para categorías
$("#buscador-categoria").on("keyup", function() {
    var valor = $(this).val().toLowerCase();
    $("#lista-categorias table tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
    });
});
</script>
