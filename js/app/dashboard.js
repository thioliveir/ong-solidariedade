// Chart.js - Gráfico de Linha
const ctx = document.getElementById("chartInscricoes")

new Chart(ctx, {
    type: "line",
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        datasets: [{
            label: "Inscrições",
            data: [20, 35, 25, 40, 60, 30, 0, 0, 0, 0, 0, 0],
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            backgroundColor: "rgb(75, 192, 192)",
            tension: 0.3,
            pointRadius: 5,
            pointHoverRadius: 7,
            borderWidth: 3,
            cubicInterpolationMode: 'monotone'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: "top",
                labels: {
                    font: {
                        size: 14
                    }
                }
            },
            title: {
                display: true,
                text: "Inscrições por mês",
                font: {
                    size: 18,
                    weight: "bold"
                }
            },
            tooltip: {
                enabled: true,
                mode: 'nearest',
                intersect: false,
                callbacks: {
                    label: context => `Inscrições: ${context.parsed.y}`
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Número de Inscrições'
                },
                ticks: {
                    stepSize: 10
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Mês'
                }
            }
        },
        animation: {
            duration: 1000,
            easing: "easeInOutQuad"
        }
        
    }
})

// Chart.js - Gráfico de Pizza
const ctxPizza = document.getElementById("chartModalidades");

new Chart(ctxPizza, {
    type: 'pie', // gráfico de pizza
    data: {
        labels: ['Presencial', 'EAD', 'Híbrido'],
        datasets: [{
            label: 'Modalidades de Cursos',
            data: [12, 8, 5], // aqui você coloca o número de cursos por modalidade
            backgroundColor: [
                'rgb(54, 162, 235)',  // azul para presencial
                'rgb(255, 206, 86)',  // amarelo para EAD
                'rgb(75, 192, 192)'   // verde para híbrido
            ],
            hoverOffset: 30,
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom', // legenda abaixo do gráfico
                labels: {
                    font: {
                        size: 14
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: context => {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.chart._metasets[context.datasetIndex].total;
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${label}: ${value} cursos (${percentage}%)`;
                    }
                }
            },
            title: {
                display: true,
                text: 'Distribuição dos Cursos por Modalidade',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            }
        }
    }
});


// DataTable - Tabela de Inscrições
document.addEventListener("DOMContentLoaded", function () {
    $("#tabelaAlunos").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
        },
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        responsive: true,
        searching: true,
        ordering: true,
        order: [[2, 'desc']] // ordenar pela data de inscrição desc por padrão
    })
})