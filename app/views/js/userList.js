document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput-buscador");
  const tableBody = document.querySelector("table tbody");

  searchInput.addEventListener("keyup", function () {
    const searchTerm = this.value.toLowerCase();
    const rows = tableBody.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName("td");
      let shouldShow = false;

      for (let j = 0; j < cells.length; j++) {
        const cellText = cells[j].textContent.toLowerCase();
        if (cellText.includes(searchTerm)) {
          shouldShow = true;
          break;
        }
      }

      rows[i].style.display = shouldShow ? "" : "none";
    }
  });
});
