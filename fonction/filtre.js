// ---------------- FILTRE ----------------
document.addEventListener("DOMContentLoaded", function () {
    const filters = {
        nom: document.getElementById("nom"), // Filtre sur le nom
        salles: document.getElementById("salles"), // Filtre sur la salle
        activites: document.getElementById("activites"), // Filtre sur les activités
        date_debut: document.getElementById("date_debut"), // Filtre date début
        date_fin: document.getElementById("date_fin"), // Filtre date fin
        heure_debut: document.getElementById("heure_debut"), // Filtre heure début
        heure_fin: document.getElementById("heure_fin"), // Filtre heure fin
    };

    const rows = document.querySelectorAll("table.table-striped tbody tr");

    function areFiltersEmpty() {
        return Object.values(filters).every(filter => {
            if (!filter) return true; // Si le filtre n'existe pas, on le considère comme vide
            if (filter.tagName === "SELECT") {
                return filter.selectedIndex === 0;
            }
            return filter.value.trim() === "";
        });
    }

    function filterTable() {
        let visibleRowCount = 0;
        let noResultsFound = true;

        if (areFiltersEmpty()) {
            rows.forEach(row => {
                row.style.display = "";
            });
            updateResultCount(rows.length);
            removeNoResultsRow();
            return;
        }

        rows.forEach(row => {
            const columns = row.querySelectorAll("td.tab-trier");

            // Vérification si les colonnes sont correctement récupérées
            if (!columns || columns.length === 0) {
                row.style.display = "none";
                return;
            }

            const values = {
                salles: columns[1]?.innerText.trim().toLowerCase() || "",
                nom: columns[2]?.innerText.trim().toLowerCase() || "",
                activites: columns[3]?.childNodes[0]?.textContent.trim().toLowerCase() || "",
                date: columns[4]?.textContent.trim() || "",
                heure_debut: columns[5]?.textContent.trim() || "",
                heure_fin: columns[6]?.textContent.trim() || "",
            };

            const isDateInRange = (() => {
                const filterStart = filters.date_debut?.value.trim();
                const filterEnd = filters.date_fin?.value.trim();

                if (!filterStart && !filterEnd) return true;

                const rowDate = new Date(values.date);
                const startDate = filterStart ? new Date(filterStart) : null;
                const endDate = filterEnd ? new Date(filterEnd) : null;

                return (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
            })();

            const isTimeInRange = (() => {
                const filterStartTime = filters.heure_debut?.value.trim();
                const filterEndTime = filters.heure_fin?.value.trim();

                if (!filterStartTime && !filterEndTime) return true;

                const rowStartTime = values.heure_debut;
                const rowEndTime = values.heure_fin;

                if (!rowStartTime || !rowEndTime) return false;

                const timeToMinutes = time => {
                    const [hours, minutes] = time.split(":").map(Number);
                    return hours * 60 + minutes;
                };

                const filterStartMinutes = filterStartTime ? timeToMinutes(filterStartTime) : null;
                const filterEndMinutes = filterEndTime ? timeToMinutes(filterEndTime) : null;
                const rowStartMinutes = timeToMinutes(rowStartTime);
                const rowEndMinutes = timeToMinutes(rowEndTime);

                const isStartInRange = filterStartMinutes === null || rowStartMinutes >= filterStartMinutes;
                const isEndInRange = filterEndMinutes === null || rowEndMinutes <= filterEndMinutes;

                return isStartInRange && isEndInRange;
            })();

            const matchesFilters = Object.keys(filters).every(key => {
                if (!filters[key]) return true;

                const filterValue = filters[key]?.value.trim().toLowerCase();
                if (!filterValue || (filters[key]?.tagName === "SELECT" && filterValue === filters[key]?.options[0]?.value.trim())) {
                    return true;
                }

                if (key === "salles") {
                    return values.salles === filterValue;
                }

                if (key === "date_debut" || key === "date_fin" || key === "heure_debut" || key === "heure_fin") {
                    return true;
                }

                return values[key]?.includes(filterValue) ?? false;
            });

            const isVisible = matchesFilters && isDateInRange && isTimeInRange;
            row.style.display = isVisible ? "" : "none";

            if (isVisible) {
                visibleRowCount++;
                noResultsFound = false;
            }
        });

        updateResultCount(visibleRowCount);

        if (noResultsFound) {
            addNoResultsRow();
        } else {
            removeNoResultsRow();
        }
    }

    function updateResultCount(count) {
        const resultCountElement = document.querySelector(".result-count");
        if (resultCountElement) {
            resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${count}`;
        }
    }

    function addNoResultsRow() {
        const tbody = document.querySelector("table.table-striped tbody");
        if (!document.querySelector(".no-results-row")) {
            const row = document.createElement("tr");
            row.classList.add("no-results-row");
            row.innerHTML = `<td colspan="8" class="text-center text-danger fw-bold">Aucune réservation trouvée</td>`;
            tbody.appendChild(row);
        }
    }

    function removeNoResultsRow() {
        const noResultsRow = document.querySelector(".no-results-row");
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }

    Object.values(filters)
        .filter(filter => filter instanceof HTMLElement) // Vérifie que c'est un élément HTML
        .forEach(filter => {
            const eventType = filter.tagName === "SELECT" ? "change" : "input";
            filter.addEventListener(eventType, filterTable);
        });

    const resetButton = document.querySelector('.btn-reset');
    if (resetButton) {
        resetButton.addEventListener('click', function () {
            Object.values(filters).forEach(filter => {
                if (filter?.tagName === "SELECT") {
                    filter.selectedIndex = 0;
                } else if (filter) {
                    filter.value = "";
                }
            });
            filterTable();
        });
    }
});