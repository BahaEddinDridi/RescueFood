@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <!-- Stats Card (Using Chart.js) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background-color: #222e3c; color: white; border-radius: 8px;">
                    <div class="card-body">
                        <h5 class="card-title">J’aime et Commentaires par Publication</h5>
                        <canvas id="likesCommentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post List -->
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Liste des publications</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th class="d-none d-xl-table-cell">Titre</th>
                        <th class="d-none d-xl-table-cell">Type</th>
                        <th class="d-none d-md-table-cell">Date de publication</th>
                        <th class="d-none d-md-table-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="User Profile"
                                    class="rounded-circle" width="50" height="50"
                                    style="object-fit: cover; margin-right: 10px;">
                                {{ $post->user->getFullNameAttribute() }}
                            </td>
                            <td class="d-none d-xl-table-cell">{{ $post->titre }}</td>
                            <td class="d-none d-xl-table-cell">{{ $post->type_post }}</td>
                            <td class="d-none d-xl-table-cell">
                                {{ $post->created_at }}
                            </td>
                            <td>
                                <a  href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-warning">Consulter</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Chart.js Configuration
        var ctx = document.getElementById('likesCommentsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar', // Bar chart
            data: {
                labels: @json($postTitles), // Labels for each post title
                datasets: [{
                    label: "J'aimes",
                    data: @json($likesData), // Likes count per post
                    backgroundColor: 'rgba(255, 99, 132, 0.6)', // Red color for Likes
                    borderColor: 'rgba(255, 99, 132, 1)', // Dark red for Likes border
                    borderWidth: 1
                }, {
                    label: 'Commentaires',
                    data: @json($commentsData), // Comments count per post
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue color for Comments
                    borderColor: 'rgba(54, 162, 235, 1)', // Dark blue for Comments border
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 14,
                                family: 'Arial, sans-serif'
                            },
                            color: '#fff', // White color for Y-axis ticks
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)', // Lighter grid lines
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 14,
                                family: 'Arial, sans-serif'
                            },
                            color: '#fff', // White color for X-axis ticks
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)', // Lighter grid lines
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 16,
                                family: 'Arial, sans-serif'
                            },
                            color: '#fff' // White color for legend labels
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)', // Darker tooltip background
                        bodyColor: '#fff', // White text in tooltips
                        titleColor: '#fff' // White title in tooltips
                    }
                }
            }
        });
    </script>
@endsection
