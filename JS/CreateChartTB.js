// Récupération du canvas
const ctx = document.getElementById("chart");
var dark;
document.querySelector(".darkmode").addEventListener('click', () => {
    dark = (document.getElementsByClassName("dark"))[0] ? '#F0EEED': 'black';
});
// Test du rôle
if (ctx.getAttribute("data-role") == "manager") {
    // Chart Manager

    // Récupération des valeurs
    rempli = document.getElementById("rempli").value;
    valide = document.getElementById("valide").value;

    // Données du camembert
    data = {
        labels: ["Saisi", "Non saisi", "Validé", "Non validé"],
        datasets: [
            {
                label: "Taux de remplissage agent du mois en cours",
                data: [rempli, 100 - rempli],
                backgroundColor: ["#A5EBF0", "#C6C6C6"],
                hoverOffset: 4,
            },
            {
                label: "Proportion de validation du mois en cours",
                data: [valide, 100 - valide],
                backgroundColor: ["#609EA2", "#898989"],
                hoverOffset: 4,
            },
        ],
    };
} else if (ctx.getAttribute("data-role") == "assistante") {
    // Chart Assistante

    // Récupération des valeurs
    reporte = document.getElementById("reporte").value;

    // Données du camembert
    data = {
        labels: ["Reporté", "Non reporté"],
        datasets: [
            {
                label: "Pourcentage de report du mois en cours",
                data: [reporte, 100 - reporte],
                backgroundColor: ["#A5EBF0", "#C6C6C6"],
                hoverOffset: 4,
            },
        ],
    };
}

// Configuration du camembert
const config = {
    type: "pie",
    data: data,
    // Options pour avoir la légende avec les couleurs correspondant aux labels (source : site ChartJS)
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    generateLabels: function (chart) {
                        // Get the default label list
                        const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                        const labelsOriginal = original.call(this, chart);

                        // Build an array of colors used in the datasets of the chart
                        let datasetColors = chart.data.datasets.map(function (e) {
                            return e.backgroundColor;
                        });
                        datasetColors = datasetColors.flat();

                        // Modify the color and hide state of each label
                        labelsOriginal.forEach((label) => {
                            // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                            label.datasetIndex = (label.index - (label.index % 2)) / 2;

                            // The hidden state must match the dataset's hidden state
                            label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                            // Change the color to match the dataset
                            label.fillStyle = datasetColors[label.index];
                        });

                        return labelsOriginal;
                    },
                    color:dark,
                    font:{weight:"bold"}
                },
            },
        },
    },
};

// Création du camembert
new Chart(ctx, config);
