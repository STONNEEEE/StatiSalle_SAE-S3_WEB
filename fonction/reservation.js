document.addEventListener("DOMContentLoaded", function () {

    // Récupération des éléments <select> et <input> pour les filtres
    const filters = {
        nom: document.getElementById("nom"), // Filtre sur le nom
        salles: document.getElementById("salles"), // Filtre sur la salle
        activites: document.getElementById("activites"), // Filtre sur les activités
        date_debut: document.getElementById("date_debut"), // Filtre date début
        date_fin: document.getElementById("date_fin"), // Filtre date fin
        heure_debut: document.getElementById("heure_debut"), // Filtre heure début
        heure_fin: document.getElementById("heure_fin"), // Filtre heure fin
    };

    // Récupération de toutes les lignes du tableau
    const rows = Array.from(document.querySelectorAll("table.table-striped tbody tr"));

    // Fonction pour vérifier si tous les filtres sont vides
    function areFiltersEmpty() {
        return Object.values(filters).every(filter => {
            // Si c'est un champ SELECT, vérifier si la première option est sélectionnée
            if (filter.tagName === "SELECT") {
                return filter.selectedIndex === 0;
            }
            // Si c'est un champ INPUT, vérifier si la valeur est vide
            return filter.value.trim() === "";
        });
    }

    // Fonction de filtrage
    function filterTable() {
        const filteredRows = []; // Tableau pour stocker les lignes filtrées
        let visibleRowCount = 0; // Compteur pour les lignes visibles
        let noResultsFound = true; // Variable pour vérifier si des résultats sont trouvés

        // Si tous les filtres sont vides, on ne fait rien et on affiche toutes les lignes
        if (areFiltersEmpty()) {
            rows.forEach(row => {
                row.style.display = ""; // Affiche toutes les lignes
                filteredRows.push(row); // Ajouter la ligne au tableau filtré
            });

            // Met à jour le compteur avec le nombre total de lignes
            const resultCountElement = document.querySelector(".result-count");
            if (resultCountElement) {
                resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${rows.length / 2}`;
            }

            // Retirer la ligne "Aucune réservation trouvée" si elle existe
            supprimerLigneResultatIntrouvable();
            return filteredRows; // Retourner les lignes filtrées (même si toutes sont affichées)
        }

        rows.forEach(row => {
            const columns = row.querySelectorAll("td.tab-trier");

            // Extraction des valeurs nécessaires des colonnes correspondantes
            const values = {
                salles: columns[1]?.innerText.trim().toLowerCase(),
                nom: columns[2]?.innerText.trim().toLowerCase(),
                activites: columns[3]?.childNodes[0]?.textContent.trim().toLowerCase(),
                date: columns[4]?.textContent.trim(),
                heure_debut: columns[5]?.textContent.trim(),
                heure_fin: columns[6]?.textContent.trim(),
            };

            // Vérification des filtres
            const isDateInRange = (() => {
                const filterStart = filters.date_debut.value.trim();
                const filterEnd = filters.date_fin.value.trim();

                if (!filterStart && !filterEnd) return true;

                const rowDate = new Date(values.date);
                const startDate = filterStart ? new Date(filterStart) : null;
                const endDate = filterEnd ? new Date(filterEnd) : null;

                return (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
            })();

            function timeToMinutes(time) {
                const [hours, minutes, seconds] = time.split(":").map(Number);
                return hours * 60 + minutes + (seconds || 0) / 60;
            }

            const isTimeInRange = (() => {
                const filterStartTime = filters.heure_debut.value.trim();
                const filterEndTime = filters.heure_fin.value.trim();

                if (!filterStartTime && !filterEndTime) return true;

                const rowStartTime = values.heure_debut;
                const rowEndTime = values.heure_fin;

                if (!rowStartTime || !rowEndTime) return false;

                const filterStartMinutes = filterStartTime ? timeToMinutes(filterStartTime) : null;
                const filterEndMinutes = filterEndTime ? timeToMinutes(filterEndTime) : null;
                const rowStartMinutes = timeToMinutes(rowStartTime);
                const rowEndMinutes = timeToMinutes(rowEndTime);

                const isStartInRange = filterStartMinutes === null || rowStartMinutes >= filterStartMinutes;
                const isEndInRange = filterEndMinutes === null || rowEndMinutes <= filterEndMinutes;

                return isStartInRange && isEndInRange;
            })();

            const matchesFilters = Object.keys(filters).every(key => {
                if (key === "date_debut" || key === "date_fin" || key === "heure_debut" || key === "heure_fin") {
                    return true;
                }

                const filterValue = filters[key]?.value.trim().toLowerCase();

                if (!filterValue || (filters[key]?.tagName === "SELECT" && filterValue === filters[key]?.options[0]?.value.trim())) {
                    return true;
                }

                if (key === "salles") {
                    return values.salles === filterValue;
                }

                return values[key]?.includes(filterValue) ?? false;
            });

            const isVisible = matchesFilters && isDateInRange && isTimeInRange;
            row.style.display = isVisible ? "" : "none";

            if (isVisible) {
                filteredRows.push(row); // Ajouter la ligne filtrée
                visibleRowCount++;
                noResultsFound = false;
            }
        });

        // Met à jour le nombre de résultats trouvés
        const resultCountElement = document.querySelector(".result-count");
        if (resultCountElement) {
            resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${visibleRowCount}`;
        }

        // Si aucune ligne n'est visible, afficher une ligne "Aucune réservation trouvée"
        if (noResultsFound) {
            ajouterLigneResultatIntrouvable();
        } else {
            supprimerLigneResultatIntrouvable();
        }

        return filteredRows; // Retourne les lignes filtrées
    }

    // Fonction pour retirer la ligne "Aucune réservation trouvée"
    function supprimerLigneResultatIntrouvable() {
        const noResultsRow = document.querySelector(".no-results-row");
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }

    // Fonction pour ajouter la ligne "Aucune réservation trouvée"
    function ajouterLigneResultatIntrouvable() {
        const tbody = document.querySelector("table.table-striped tbody");
        if (!document.querySelector(".no-results-row")) {
            const row = document.createElement("tr");
            row.classList.add("no-results-row");
            row.innerHTML = '<td colspan="8" class="text-center text-danger fw-bold">Aucune réservation trouvée</td>';
            tbody.appendChild(row);
        }
    }

    // ---------------- PAGINATION ----------------
    const paginationContainer = document.querySelector("#pagination");
    const rowsPerPageOptions = document.querySelectorAll(".rows-per-page");
    let rowsPerPage = 10; // Par défaut, 10 lignes par page
    let currentPage = 1;
    let filteredRows = [];

    function generatePageLinks(totalPages, currentPage) {
        const pages = [];

        pages.push(1);

        if (currentPage > 3) {
            pages.push('...');
        }

        for (let i = Math.max(2, currentPage - 2); i <= Math.min(totalPages - 1, currentPage + 2); i++) {
            pages.push(i);
        }

        if (currentPage < totalPages - 2) {
            pages.push('...');
        }

        if (totalPages > 1) {
            pages.push(totalPages);
        }

        return pages;
    }

    function renderTable() {
        filteredRows = filterTable(); // Applique le filtrage et récupère les lignes filtrées
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        const startRow = (currentPage - 1) * rowsPerPage;
        const endRow = startRow + rowsPerPage;

        filteredRows.forEach((row, index) => {
            row.style.display = index >= startRow && index < endRow ? "" : "none";
        });

        paginationContainer.innerHTML = "";

        const pageLinks = generatePageLinks(totalPages, currentPage);

        const firstButton = document.createElement("button");
        firstButton.textContent = "<<";
        firstButton.className = currentPage === 1
            ? "btn-pagination-disabled rounded"
            : "btn-pagination rounded";
        if (currentPage !== 1) {
            firstButton.addEventListener("click", () => {
                currentPage = 1;
                renderTable();
            });
        }
        paginationContainer.appendChild(firstButton);

        const prevButton = document.createElement("button");
        prevButton.textContent = "<";
        prevButton.className = currentPage === 1
            ? "btn-pagination-disabled rounded"
            : "btn-pagination rounded";
        if (currentPage !== 1) {
            prevButton.addEventListener("click", () => {
                currentPage -= 1;
                renderTable();
            });
        }
        paginationContainer.appendChild(prevButton);

        pageLinks.forEach(link => {
            const button = document.createElement("button");
            button.textContent = link;
            if (link === "...") {
                button.className = "btn-pagination btn-points disabled rounded";
            } else {
                button.className = `btn-pagination rounded ${link === currentPage ? "active" : ""}`;
                button.addEventListener("click", () => {
                    currentPage = link;
                    renderTable();
                });
            }
            paginationContainer.appendChild(button);
        });

        const nextButton = document.createElement("button");
        nextButton.textContent = ">";
        nextButton.className = currentPage === totalPages
            ? "btn-pagination-disabled rounded"
            : "btn-pagination rounded";
        if (currentPage !== totalPages) {
            nextButton.addEventListener("click", () => {
                currentPage += 1;
                renderTable();
            });
        }
        paginationContainer.appendChild(nextButton);

        const lastButton = document.createElement("button");
        lastButton.textContent = ">>";
        lastButton.className = currentPage === totalPages
            ? "btn-pagination-disabled rounded"
            : "btn-pagination rounded";
        if (currentPage !== totalPages) {
            lastButton.addEventListener("click", () => {
                currentPage = totalPages;
                renderTable();
            });
        }
        paginationContainer.appendChild(lastButton);
    }

    rowsPerPageOptions.forEach(option => {
        option.addEventListener("click", function () {
            rowsPerPage = parseInt(this.dataset.rows, 10);
            currentPage = 1; // Revenir à la première page
            renderTable();
        });
    });

    // Ajouter les événements de changement pour les filtres
    Object.values(filters).forEach(filter => {
        filter.addEventListener("change", renderTable);
    });

    renderTable();
});
