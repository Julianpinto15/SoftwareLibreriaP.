<div class="container">
    <div class="position-contenido">

     <div class="filtros w-100">
        <div class="row">
          <div class="col-md-6">
            <div class="filtro-grupo">
              <div class="input-group mb-3 filtro-input-contenedor">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput-vendedor" class="form-control filtro-input" placeholder="Buscar por vendedor...">
              </div>
              <div class="input-group mb-3 filtro-input-contenedor">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                <input type="date" id="searchInput-fecha" class="form-control filtro-input">
              </div>
              <button id="btnLimpiarFiltros" class="btn btn-info btn-sm filtro-btn">Limpiar filtros</button>
            </div>
          </div>
        </div>
     </div>

      <div class="content-name">
          <h1 class="text-titulo">Ventas</h1>
          <h2 class="h5 text-muted"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de Ventas</h2>
      </div>
   </div>
</div>

<div class="container">
	<div class="form-rest mb-4"></div>

	<?php
		use app\controllers\saleController;

		$insVenta = new saleController();

		echo $insVenta->listarVentaControlador($url[1],6,$url[0],"");

		include "./app/views/inc/print_invoice_script.php";
	?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const searchInputVendedor = document.getElementById("searchInput-vendedor");
  const searchInputFecha = document.getElementById("searchInput-fecha");
  const btnLimpiarFiltros = document.getElementById("btnLimpiarFiltros");
  const table = document.querySelector("table");
  
  if (!table) {
    console.error("No se encontró la tabla en el documento");
    return;
  }
  
  const tableBody = table.querySelector("tbody");
  if (!tableBody) {
    console.error("No se encontró el cuerpo de la tabla");
    return;
  }

  // Indices de las columnas (ajustar según la estructura real de tu tabla)
  let indexVendedor = -1;
  let indexFecha = -1;
  
  // Detectar las columnas automáticamente
  const headerRow = table.querySelector("thead tr");
  if (headerRow) {
    const headers = headerRow.querySelectorAll("th");
    headers.forEach((header, index) => {
      const headerText = header.textContent.toLowerCase();
      if (headerText.includes("vendedor") || headerText.includes("usuario") || headerText.includes("empleado")) {
        indexVendedor = index;
      }
      if (headerText.includes("fecha")) {
        indexFecha = index;
      }
    });
  }
  
  // Si no se encontraron encabezados, buscar en la primera fila para detectar patrones
  if (indexVendedor === -1 || indexFecha === -1) {
    const firstRow = tableBody.querySelector("tr");
    if (firstRow) {
      const cells = firstRow.querySelectorAll("td");
      cells.forEach((cell, index) => {
        const cellText = cell.textContent;
        // Detectar columna fecha buscando formatos comunes (DD/MM/AAAA o AAAA-MM-DD)
        if (indexFecha === -1 && (cellText.match(/\d{2}\/\d{2}\/\d{4}/) || cellText.match(/\d{4}-\d{2}-\d{2}/))) {
          indexFecha = index;
        }
        // La columna de vendedor es más difícil de detectar automáticamente,
        // intentamos encontrar celdas con nombres de personas
        if (indexVendedor === -1 && cellText.includes(" ") && cellText.length > 5 && !cellText.match(/^\d/)) {
          indexVendedor = index;
        }
      });
    }
  }
  
  console.log("Columna vendedor detectada:", indexVendedor);
  console.log("Columna fecha detectada:", indexFecha);

  // Función para convertir formato de fecha
  function convertirFormatoFecha(fechaISO) {
    if (!fechaISO) return "";
    
    const fecha = new Date(fechaISO);
    const dia = fecha.getDate().toString().padStart(2, '0');
    const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    const anio = fecha.getFullYear();
    
    // Devolver todos los formatos posibles para comparar
    return [
      `${dia}/${mes}/${anio}`, // DD/MM/YYYY
      `${dia}-${mes}-${anio}`, // DD-MM-YYYY
      `${anio}-${mes}-${dia}`, // YYYY-MM-DD
      `${anio}/${mes}/${dia}`, // YYYY/MM/DD
      `${dia}/${mes}/${anio.toString().slice(2)}`, // DD/MM/YY
      `${mes}/${dia}/${anio}` // MM/DD/YYYY (formato americano)
    ];
  }

  // Función para realizar la búsqueda
  function realizarBusqueda() {
    const terminoVendedor = searchInputVendedor.value.toLowerCase().trim();
    const fechaSeleccionada = searchInputFecha.value;
    
    // Convertir la fecha seleccionada a varios formatos posibles
    const formatosFecha = convertirFormatoFecha(fechaSeleccionada);
    
    const rows = tableBody.querySelectorAll("tr");

    rows.forEach(row => {
      const cells = row.querySelectorAll("td");
      
      // Si no hay suficientes celdas, simplemente mostrar la fila
      if (cells.length === 0) {
        row.style.display = "";
        return;
      }
      
      let coincideVendedor = !terminoVendedor;
      let coincideFecha = !fechaSeleccionada;
      
      // Verificar coincidencia de vendedor
      if (terminoVendedor && indexVendedor >= 0 && indexVendedor < cells.length) {
        const vendedorText = cells[indexVendedor].textContent.toLowerCase();
        coincideVendedor = vendedorText.includes(terminoVendedor);
      }
      
      // Verificar coincidencia de fecha
      if (fechaSeleccionada && indexFecha >= 0 && indexFecha < cells.length) {
        const fechaText = cells[indexFecha].textContent.trim();
        // Comprobar si alguno de los formatos de fecha coincide
        coincideFecha = formatosFecha.some(formato => fechaText.includes(formato));
      }
      
      // Si no pudimos detectar las columnas, buscar en todas
      if ((indexVendedor === -1 && terminoVendedor) || (indexFecha === -1 && fechaSeleccionada)) {
        cells.forEach(cell => {
          const cellText = cell.textContent.toLowerCase();
          if (terminoVendedor && !coincideVendedor && cellText.includes(terminoVendedor)) {
            coincideVendedor = true;
          }
          if (fechaSeleccionada && !coincideFecha) {
            // Comprobar si alguno de los formatos de fecha coincide
            coincideFecha = formatosFecha.some(formato => cellText.includes(formato));
          }
        });
      }
      
      // Mostrar la fila solo si coincide con ambos criterios
      row.style.display = (coincideVendedor && coincideFecha) ? "" : "none";
    });
    
    console.log(`Búsqueda realizada - Vendedor: "${terminoVendedor}", Fecha: "${fechaSeleccionada}" (Formatos: ${formatosFecha.join(", ")})`);
  }

  // Eventos para los inputs
  searchInputVendedor.addEventListener("keyup", realizarBusqueda);
  searchInputFecha.addEventListener("change", realizarBusqueda);
  
  // Botón para limpiar filtros
  btnLimpiarFiltros.addEventListener("click", function() {
    searchInputVendedor.value = "";
    searchInputFecha.value = "";
    
    // Mostrar todas las filas
    const rows = tableBody.querySelectorAll("tr");
    rows.forEach(row => {
      row.style.display = "";
    });
  });
  
  // Mensaje de depuración para confirmar que el script se cargó correctamente
  console.log("Script de búsqueda cargado correctamente");
});
</script>
