// ---------------- FILTRE ----------------
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
    const rows = document.querySelectorAll("table.table-striped tbody tr");

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
        let visibleRowCount = 0; // Compteur pour les lignes visibles
        let noResultsFound = true; // Variable pour vérifier si des résultats sont trouvés

        // Si tous les filtres sont vides, on ne fait rien et on affiche toutes les lignes
        if (areFiltersEmpty()) {
            rows.forEach(row => {
                row.style.display = ""; // Affiche toutes les lignes
            });

            // Met à jour le compteur avec le nombre total de lignes
            const resultCountElement = document.querySelector(".result-count");
            if (resultCountElement) {
                resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${rows.length/2}`;
            }

            // Retirer la ligne "Aucune réservation trouvée" si elle existe
            removeNoResultsRow();
            return; // On arrête la fonction ici, aucun filtrage n'est appliqué
        }

        rows.forEach(row => {
            const columns = row.querySelectorAll("td.tab-trier");

            // Extraction des valeurs nécessaires des colonnes correspondantes
            const values = {
                salles: columns[1]?.innerText.trim().toLowerCase(), // Utiliser innerText pour récupérer tout le texte visible
                nom: columns[2]?.innerText.trim().toLowerCase(), // Utiliser innerText pour récupérer tout le texte visible
                activites: columns[3]?.childNodes[0]?.textContent.trim().toLowerCase(), // Colonne "Activité"
                date: columns[4]?.textContent.trim(), // Colonne "Date"
                heure_debut: columns[5]?.textContent.trim(), // Colonne "Heure début"
                heure_fin: columns[6]?.textContent.trim(), // Colonne "Heure fin"
            };

            // Vérification des filtres
            const isDateInRange = (() => {
                const filterStart = filters.date_debut.value.trim(); // Valeur du filtre date début
                const filterEnd = filters.date_fin.value.trim(); // Valeur du filtre date fin

                if (!filterStart && !filterEnd) return true; // Pas de filtre

                const rowDate = new Date(values.date); // Date de la ligne
                const startDate = filterStart ? new Date(filterStart) : null;
                const endDate = filterEnd ? new Date(filterEnd) : null;

                return (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
            })();

            // Convertit une chaîne d'heure (HH:mm:ss) en minutes totales
            function timeToMinutes(time) {
                const [hours, minutes, seconds] = time.split(":").map(Number);
                return hours * 60 + minutes + (seconds || 0) / 60;
            }

            const isTimeInRange = (() => {
                const filterStartTime = filters.heure_debut.value.trim();
                const filterEndTime = filters.heure_fin.value.trim();

                // Si aucun filtre n'est défini, tout est accepté
                if (!filterStartTime && !filterEndTime) return true;

                const rowStartTime = values.heure_debut;
                const rowEndTime = values.heure_fin;

                // Si une des heures de la ligne est manquante, la ligne est exclue
                if (!rowStartTime || !rowEndTime) return false;

                // Convertir les heures en minutes totales pour la comparaison
                const filterStartMinutes = filterStartTime ? timeToMinutes(filterStartTime) : null;
                const filterEndMinutes = filterEndTime ? timeToMinutes(filterEndTime) : null;
                const rowStartMinutes = timeToMinutes(rowStartTime);
                const rowEndMinutes = timeToMinutes(rowEndTime);

                // Vérification stricte : la réservation doit commencer et se terminer dans la plage
                const isStartInRange = filterStartMinutes === null || rowStartMinutes >= filterStartMinutes;
                const isEndInRange = filterEndMinutes === null || rowEndMinutes <= filterEndMinutes;

                return isStartInRange && isEndInRange;
            })();

            const matchesFilters = Object.keys(filters).every(key => {
                if (key === "date_debut" || key === "date_fin" || key === "heure_debut" || key === "heure_fin") {
                    return true;
                }

                const filterValue = filters[key]?.value.trim().toLowerCase();

                // Si la valeur du filtre est vide ou égale à la valeur par défaut (première option), on passe
                if (!filterValue || (filters[key]?.tagName === "SELECT" && filterValue === filters[key]?.options[0]?.value.trim())) {
                    return true;
                }

                if (key === "salles") {
                    return values.salles === filterValue; // Vérifie l'égalité exacte, sans modification
                }

                // Vérification pour les autres champs (on garde la logique de recherche partielle)
                return values[key]?.includes(filterValue) ?? false;
            });

            // Afficher ou masquer la ligne en fonction des conditions
            const isVisible = matchesFilters && isDateInRange && isTimeInRange;
            row.style.display = isVisible ? "" : "none";

            if (isVisible) {
                visibleRowCount++; // Incrémente si la ligne est visible
                noResultsFound = false; // Il y a des résultats visibles
            }
        });

        // Met à jour le nombre de résultats trouvés
        const resultCountElement = document.querySelector(".result-count");
        if (resultCountElement) {
            resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${visibleRowCount}`;
        }

        // Si aucune ligne n'est visible, afficher une ligne "Aucune réservation trouvée"
        if (noResultsFound) {
            addNoResultsRow();
        } else {
            removeNoResultsRow();
        }
    }

    // Fonction pour ajouter la ligne "Aucune réservation trouvée"
    function addNoResultsRow() {
        const tbody = document.querySelector("table.table-striped tbody");
        if (!document.querySelector(".no-results-row")) {
            const row = document.createElement("tr");
            row.classList.add("no-results-row");
            row.innerHTML = `<td colspan="8" class="text-center text-danger fw-bold">Aucune réservation trouvée</td>`;
            tbody.appendChild(row);
        }
    }

    // Fonction pour retirer la ligne "Aucune réservation trouvée"
    function removeNoResultsRow() {
        const noResultsRow = document.querySelector(".no-results-row");
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }

    // Ajout des écouteurs d'événements pour chaque filtre
    Object.values(filters).forEach(filter => {
        const eventType = filter.tagName === "SELECT" ? "change" : "input";
        filter.addEventListener(eventType, filterTable);
    });

    // Bouton de réinitialisation des filtres
    const resetButton = document.querySelector('.btn-reset');
    if (resetButton) {
        resetButton.addEventListener('click', function () {
            Object.values(filters).forEach(filter => {
                // Réinitialise chaque filtre à sa valeur par défaut
                if (filter.tagName === "SELECT") {
                    filter.selectedIndex = 0; // Remet le premier élément sélectionné
                } else {
                    filter.value = ""; // Vide les champs texte
                }
            });
            filterTable(); // Applique les filtres réinitialisés
        });
    }
});