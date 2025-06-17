<div class="container">
    <div class="position-contenido">
        <div class="position-buttom">
            <button class="btn-registrar btn btn-primary mb-4" onclick="abrirModalRegistroCaja()">
                Registrar Nueva Caja
            </button>
        </div>

        <div class="search-container-buscador">
            <div class="search-group-buscador">
                    <i class="bi bi-search search-icon-buscador"></i>
                    <input type="text" id="buscador-caja" class="search-input-buscador" placeholder="Buscar...">
            </div>
        </div>

        <div class="content-name">
            <div class="container-fluid mb-4">
                <h1 class="text-titulo">Caja</h1>
                <h2 class="h5 text-muted">Gestión de Cajas</h2>
            </div>
        </div>
    </div>


    <!-- Lista de Cajas -->
    <div id="lista-cajas" class="mt-4">
        <!-- Aquí se cargará la lista de cajas -->
    </div>
    

    <!-- Modal de Registro -->
    <div class="modal fade" id="registroCajaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-model_title">Registrar Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-registro-caja">
                        <input type="hidden" name="modulo_caja" value="registrar">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Número de Caja</label>
                            <input class="form-control text-model_input" type="text" name="caja_numero" pattern="[0-9]{1,5}" maxlength="5" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Nombre</label>
                            <input class="form-control text-model_input" type="text" name="caja_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}" maxlength="70" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Efectivo</label>
                            <input class="form-control text-model_input" type="text" name="caja_efectivo" pattern="[0-9.]{1,25}" maxlength="25" value="0.00" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary text-model" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success text-model">Registrar Caja</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Actualización -->
<div id="modal-editar-caja" class="modal fade" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-model_title" id="modalEditarLabel">Actualizar Caja</h5>
                <button type="button" class="btn-close" aria-label="Close" onclick="cerrarModalEditarCaja()"></button>
            </div>
            <div class="modal-body p-4">
                <form id="form-edicion-caja" method="POST">
                    <input type="hidden" name="modulo_caja" value="actualizar">
                    <input type="hidden" id="caja_id" name="caja_id">

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-model">Número de Caja</label>
                        <input id="edit_caja_numero" class="form-control form-control-lg text-model_input" type="text" 
                               name="caja_numero" pattern="[0-9]{1,5}" maxlength="5" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-model">Nombre</label>
                        <input id="edit_caja_nombre" class="form-control form-control-lg text-model_input" type="text" 
                               name="caja_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}" maxlength="70" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-model">Efectivo</label>
                        <input id="edit_caja_efectivo" class="form-control form-control-lg text-model_input" type="text" 
                               name="caja_efectivo" pattern="[0-9.]{1,25}" maxlength="25" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-lg px-4 text-model">Actualizar Caja</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Función para abrir el Modal de Registro de Caja
    function abrirModalRegistroCaja() {
        var modal = new bootstrap.Modal(document.getElementById('registroCajaModal'));
        modal.show();
    }

    // Función para cerrar el Modal de Registro de Caja
    function cerrarModalRegistroCaja() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('registroCajaModal'));
        modal.hide();
        document.getElementById('form-registro-caja').reset();
    }

    // Función para abrir el Modal de Edición de Caja
    function abrirModalEditarCaja(caja) {
        document.getElementById('caja_id').value = caja.caja_id;
        document.getElementById('edit_caja_numero').value = caja.caja_numero;
        document.getElementById('edit_caja_nombre').value = caja.caja_nombre;
        document.getElementById('edit_caja_efectivo').value = caja.caja_efectivo;

        var modal = new bootstrap.Modal(document.getElementById('modal-editar-caja'));
        modal.show();
    }

    function cerrarModalEditarCaja() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('modal-editar-caja'));
        modal.hide();
        $('#form-edicion-caja')[0].reset();
    }

    // Función para cargar la lista de cajas
    function cargarCajas(pagina = 1, busqueda = '') {
        $.ajax({
            url: '<?= APP_URL ?>app/ajax/cajaAjax.php',
            type: 'POST',
            data: {
                modulo_caja: 'listar',
                pagina: pagina,
                registros: 10,
                url: 'categoria', 
                busqueda: busqueda
            },
            success: function(response) {
                $('#lista-cajas').html(response);

                 // Agregar eventos a los enlaces de paginación
            $('.pagination .page-link').on('click', function(e) {
                e.preventDefault();
                if ($(this).attr('aria-disabled') !== 'true') {
                    const href = $(this).attr('href');
                    // Extraer el número de página de la URL (formato: url/{pagina}/)
                    const match = href.match(/\/(\d+)\//);
                    if (match && match[1]) {
                        cargarCajas(parseInt(match[1]), busqueda);
                    }
                }
            });
            },
            error: function(xhr, status, error) {
                console.error("Error cargando categorías:", error);
                $('#lista-cajas').html('<div class="alert alert-danger">Error al cargar las cajas</div>');
            }
        });
    }

    // Manejador para el formulario de registro
    $('#form-registro-caja').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= APP_URL ?>app/ajax/cajaAjax.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                const resp = JSON.parse(response);
                if (resp.tipo === "limpiar") {
                    cerrarModalRegistroCaja();
                    cargarCajas();
                    
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
    $('#form-edicion-caja').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize() + "&modulo_caja=actualizar";
        
        $.ajax({
            url: '<?= APP_URL ?>app/ajax/cajaAjax.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const resp = JSON.parse(response);
                if (resp.tipo === "recargar") {
                    cerrarModalEditarCaja();
                    cargarCajas();
                    
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
                    text: 'Error al actualizar la caja. Por favor, intente nuevamente.'
                });
            }
        });
    });

    // Función para eliminar una caja
    function eliminarCaja(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea eliminar esta caja?",
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
                    url: '<?= APP_URL ?>app/ajax/cajaAjax.php',
                    type: 'POST',
                    data: {
                        modulo_caja: 'eliminar',
                        caja_id: id
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
                                cargarCajas();
                            }
                        });
                    }
                });
            }
        });
    }

    // Cargar la lista de cajas al cargar la página
    $(document).ready(function() {
        cargarCajas();
    });

    // Buscador en tiempo real para cajas
$("#buscador-caja").on("keyup", function() {
    var valor = $(this).val().toLowerCase();
    $("#lista-cajas table tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
    });
});
</script>