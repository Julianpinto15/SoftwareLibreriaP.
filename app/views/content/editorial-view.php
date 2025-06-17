<div class="container">

  <div class="position-contenido">
  <div class="position-buttom">
    <button class="btn-registrar btn btn-primary mb-4" onclick="abrirModalRegistroeditorial()">
      <i class="bi bi-plus-square"></i>
        Nueva Editorial
    </button>
  </div>

  <div class="search-container-buscador">
    <div class="search-group-buscador">
            <i class="bi bi-search search-icon-buscador"></i>
            <input type="text" id="buscador-editorial" class="search-input-buscador" placeholder="Buscar...">
    </div>
  </div>

  <div class="content-name">
      <div class="container-fluid mb-4">
          <h1 class="text-titulo">Editorial</h1>
          <h2 class="h3 text-muted">Gestión de Editorial</h2>
      </div>
  </div>
 </div>

    <!-- Listado de Editoriales -->
    <div id="lista-editoriales" class="mt-4">
        <!-- Aquí se cargará la lista de editoriales -->
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="modal-registro-editorial" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-model_title">Registrar Editorial</h5>
                    <button type="button" class="btn-close" onclick="cerrarModalRegistroeditorial()"></button>
                </div>
                <div class="modal-body">
                    <form id="form-registro-editorial" method="POST">
                        <input type="hidden" name="modulo_editorial" value="registrar">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Código</label>
                            <input class="form-control text-model_input" type="text" name="editorial_codigo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Nombre</label>
                            <input class="form-control text-model_input" type="text" name="editorial_nombre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">País</label>
                            <input class="form-control text-model_input" type="text" name="editorial_pais">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Información de Contacto</label>
                            <textarea class="form-control text-model_input" name="editorial_informacioncontacto"></textarea>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success text-model">Registrar Editorial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Actualización -->
    <div class="modal fade" id="modal-editar-editorial" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-model_title">Actualizar Editorial</h5>
                    <button type="button" class="btn-close" onclick="cerrarModalEditareditorial()"></button>
                </div>
                <div class="modal-body">
                    <form id="form-edicion-editorial" method="POST">
                        <input type="hidden" name="modulo_editorial" value="actualizar">
                        <input type="hidden" id="editorial_id" name="editorial_id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Código</label>
                            <input id="edit_editorial_codigo" class="form-control text-model_input" type="text" name="editorial_codigo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Nombre</label>
                            <input id="edit_editorial_nombre" class="form-control text-model_input" type="text" name="editorial_nombre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">País</label>
                            <input id="edit_editorial_pais" class="form-control text-model_input" type="text" name="editorial_pais">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-model">Información de Contacto</label>
                            <textarea id="edit_editorial_informacioncontacto" class="form-control text-model_input" name="editorial_informacioncontacto"></textarea>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success text-model">Actualizar Editorial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   // Modal handling functions
function abrirModalRegistroeditorial() {
    const modal = new bootstrap.Modal(document.getElementById('modal-registro-editorial'));
    modal.show();
}

function cerrarModalRegistroeditorial() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modal-registro-editorial'));
    modal.hide();
    document.getElementById('form-registro-editorial').reset();
}

function abrirModalEditareditorial(editorial) {
    document.getElementById('editorial_id').value = editorial.idEditorial;
    document.getElementById('edit_editorial_codigo').value = editorial.codigo;
    document.getElementById('edit_editorial_nombre').value = editorial.nombre;
    document.getElementById('edit_editorial_pais').value = editorial.pais;
    document.getElementById('edit_editorial_informacioncontacto').value = editorial.informacioncontacto;
    
    const modal = new bootstrap.Modal(document.getElementById('modal-editar-editorial'));
    modal.show();
}

function cerrarModalEditareditorial() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modal-editar-editorial'));
    modal.hide();
    document.getElementById('form-edicion-editorial').reset();
}

// Function to load editorial list
function cargarEditoriales(pagina = 1, busqueda = '') {
    $.ajax({
        url: '<?= APP_URL ?>app/ajax/editorialAjax.php',
        type: 'POST',
        data: {
            modulo_editorial: 'listar',
            pagina: pagina,
            registros: 10,
            url: 'editorial', 
            busqueda: busqueda
        },
        success: function(response) {
            $('#lista-editoriales').html(response);

            $('.pagination .page-link').on('click', function(e) {
                e.preventDefault();
                if ($(this).attr('aria-disabled') !== 'true') {
                    const href = $(this).attr('href');
                    // Extraer el número de página de la URL (formato: url/{pagina}/)
                    const match = href.match(/\/(\d+)\//);
                    if (match && match[1]) {
                        cargarEditoriales(parseInt(match[1]), busqueda);
                    }
                }
            });

        },
        error: function(xhr, status, error) {
            console.error("Error cargando categorías:", error);
            $('#lista-editoriales').html('<div class="alert alert-danger">Error al cargar las editoriales</div>');
        }
    });
}

// Registration form handler with SweetAlert2
$('#form-registro-editorial').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '<?= APP_URL ?>app/ajax/editorialAjax.php',
        type: 'POST',
        data: $(this).serialize(),
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
                    htmlContainer: 'fs-4',  
                    confirmButton: 'fs-5',
                    timer: 2000,
                    timerProgressBar: true
                }
            }).then((result) => {
                if (resp.tipo === "limpiar") {
                    cerrarModalRegistroeditorial();
                    cargarEditoriales();
                }
            });
        }
    });
});

// Edit form handler with SweetAlert2
$('#form-edicion-editorial').on('submit', function(e) {
    e.preventDefault();
    const formData = $(this).serialize() + "&modulo_editorial=actualizar";
    
    $.ajax({
        url: '<?= APP_URL ?>app/ajax/editorialAjax.php',
        type: 'POST',
        data: formData,
        dataType: "json",
        success: function(response) {
            Swal.fire({
                icon: response.icono || 'info',
                title: response.titulo,
                text: response.texto,
                width: '400px',
                padding: '2em',
                customClass: {
                    title: 'fs-4',
                    htmlContainer: 'fs-5',
                    confirmButton: 'fs-5'
                }
            }).then((result) => {
                if (response.tipo === "recargar") {
                    cerrarModalEditareditorial();
                    cargarEditoriales();
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición:", error);
            console.log("Respuesta del servidor:", xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al actualizar la editorial. Por favor, intente nuevamente.'
            });
        }
    });
});

// Function to delete editorial with SweetAlert2
function eliminarEditorial(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "¿Desea eliminar esta editorial?",
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
                url: '<?= APP_URL ?>app/ajax/editorialAjax.php',
                type: 'POST',
                data: {
                    modulo_editorial: 'eliminar',
                    editorial_id: id
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
                    }).then((result) => {
                        if (resp.tipo === "recargar") {
                            cargarEditoriales();
                        }
                    });
                }
            });
        }
    });
}

// Load editorials when page is ready
$(document).ready(function() {
    cargarEditoriales();
});


// Buscador en tiempo real para editoriales
$("#buscador-editorial").on("keyup", function() {
    var valor = $(this).val().toLowerCase();
    $("#lista-editoriales table tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
    });
});
</script>