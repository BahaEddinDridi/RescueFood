@extends('layouts.app')

@section('content')

<div style="height: 60px;"></div> <!-- Espace vide pour pousser le contenu vers le bas -->

<div class="container mt-7 extra-spacing" style="margin-top: 60px;">
    <h3 class="text-center mb-4">Statistiques des Dons</h3>

    <div class="row justify-content-center mb-5">
        <!-- Doughnut Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Statistiques selon le Statut des Dons</h5>
                </div>
                <div class="card-body">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Statistiques selon la Date d'Expiration</h5>
                </div>
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-spacing {
        margin-top: 200px; /* Ajustez cette valeur si vous souhaitez encore plus d'espace */
    }
    
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Doughnut chart for donation status
    var ctx1 = document.getElementById('donutChart').getContext('2d');
    var donutChart = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Récupérés', 'Disponibles'],
            datasets: [{
                label: 'Statut des Dons',
                data: [{{ $pourcentageRecuperes }}, {{ $pourcentageDisponibles }}],
                backgroundColor: ['#4CAF50', '#FF9800'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw.toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });

    // Bar chart for expiration status
    var ctx2 = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Expirés', 'Non Expirés'],
            datasets: [{
                label: 'Statut des Dons selon la date d\'expiration',
                data: [{{ $donsExpires }}, {{ $donsNonExpires }}],
                backgroundColor: ['#FF6347', '#4CAF50'],
                borderColor: ['#FF6347', '#4CAF50'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
