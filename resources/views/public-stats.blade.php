<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golfnerd - Statistics</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        .brand-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Logo Header -->
            <div class="text-center mb-12">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo.svg') }}" alt="Golfnerd" class="h-20">
                </div>
                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Data-Driven Golf</p>
            </div>

            <!-- Aggregate Stats Section -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Overall Stats</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $aggregateStats->total_rounds ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Rounds</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $aggregateStats->total_birdies ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Birdies</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $aggregateStats->total_eagles ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Eagles</div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Averages Per Round</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $aggregateStats->avg_birdies_per_round ?? 0 }}</div>
                            <div class="text-sm text-gray-600 mt-1">Avg Birdies</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $aggregateStats->avg_eagles_per_round ?? 0 }}</div>
                            <div class="text-sm text-gray-600 mt-1">Avg Eagles</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-600">{{ $aggregateStats->avg_putts_per_round ?? 0 }}</div>
                            <div class="text-sm text-gray-600 mt-1">Avg Putts</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top 10 Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Top 10 Birdies Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Top 10 - Most Birdies</h3>
                    <div class="h-80">
                        <canvas id="topBirdiesChart"></canvas>
                    </div>
                </div>

                <!-- Top 10 Eagles Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Top 10 - Most Eagles</h3>
                    <div class="h-80">
                        <canvas id="topEaglesChart"></canvas>
                    </div>
                </div>

                <!-- Top 10 Rounds Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Top 10 - Most Rounds</h3>
                    <div class="h-80">
                        <canvas id="topRoundsChart"></canvas>
                    </div>
                </div>

                <!-- Top 10 Least Putts Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Top 10 - Least Putts</h3>
                    <div class="h-80">
                        <canvas id="leastPuttsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Trend Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Average Birdies Per Round Trend -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Average Birdies Per Round (Weekly)</h3>
                    <div class="h-80">
                        <canvas id="avgBirdiesTrendChart"></canvas>
                    </div>
                </div>

                <!-- Rounds Per Week Trend -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Rounds Played Per Week</h3>
                    <div class="h-80">
                        <canvas id="roundsTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Individual User Stats Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800">Player Leaderboard</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rank
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Player
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rounds
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Birdies
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avg Birdies
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avg Putts
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($userStats as $stat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-900">{{ $stat->ranking_position ?? '-' }}</span>
                                            @if(($stat->delta ?? 0) > 0)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    ↑{{ $stat->delta }}
                                                </span>
                                            @elseif(($stat->delta ?? 0) < 0)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    ↓{{ abs($stat->delta) }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $stat->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_rounds }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_birdies }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $stat->avg_birdies_per_round ?? 0 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $stat->avg_putts_per_round ?? 0 }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        No statistics available yet. Be the first to track your golf rounds!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Links Section -->
            <div class="mt-8 text-center">
                <div class="inline-flex gap-4">
                    <a href="/user" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login to Track Your Rounds
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart.js configuration
        Chart.defaults.font.family = 'system-ui, -apple-system, sans-serif';

        // Top Birdies Chart
        const topBirdiesData = {
            labels: [
                @foreach($topBirdies as $stat)
                    '{{ $stat->name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Birdies',
                data: [
                    @foreach($topBirdies as $stat)
                        {{ $stat->total_birdies }},
                    @endforeach
                ],
                backgroundColor: 'rgba(14, 165, 233, 0.8)',
                borderColor: 'rgba(14, 165, 233, 1)',
                borderWidth: 2
            }]
        };

        new Chart(document.getElementById('topBirdiesChart'), {
            type: 'bar',
            data: topBirdiesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });

        // Top Eagles Chart
        const topEaglesData = {
            labels: [
                @foreach($topEagles as $stat)
                    '{{ $stat->name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Eagles',
                data: [
                    @foreach($topEagles as $stat)
                        {{ $stat->total_eagles }},
                    @endforeach
                ],
                backgroundColor: 'rgba(234, 179, 8, 0.8)',
                borderColor: 'rgba(234, 179, 8, 1)',
                borderWidth: 2
            }]
        };

        new Chart(document.getElementById('topEaglesChart'), {
            type: 'bar',
            data: topEaglesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });

        // Top Rounds Chart
        const topRoundsData = {
            labels: [
                @foreach($topRounds as $stat)
                    '{{ $stat->name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Rounds',
                data: [
                    @foreach($topRounds as $stat)
                        {{ $stat->total_rounds }},
                    @endforeach
                ],
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 2
            }]
        };

        new Chart(document.getElementById('topRoundsChart'), {
            type: 'bar',
            data: topRoundsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });

        // Least Putts Chart
        const leastPuttsData = {
            labels: [
                @foreach($leastPutts as $stat)
                    '{{ $stat->name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Avg Putts',
                data: [
                    @foreach($leastPutts as $stat)
                        {{ $stat->avg_putts_per_round }},
                    @endforeach
                ],
                backgroundColor: 'rgba(109, 40, 217, 0.8)',
                borderColor: 'rgba(109, 40, 217, 1)',
                borderWidth: 2
            }]
        };

        new Chart(document.getElementById('leastPuttsChart'), {
            type: 'bar',
            data: leastPuttsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });

        // Average Birdies Per Round Trend Chart
        const avgBirdiesTrendData = {
            labels: [
                @foreach($avgBirdiesTrend as $dataPoint)
                    '{{ \Carbon\Carbon::parse($dataPoint->week_start)->format('M d') }}',
                @endforeach
            ],
            datasets: [{
                label: 'Avg Birdies Per Round',
                data: [
                    @foreach($avgBirdiesTrend as $dataPoint)
                        {{ $dataPoint->avg_birdies }},
                    @endforeach
                ],
                fullDates: [
                    @foreach($avgBirdiesTrend as $dataPoint)
                        '{{ \Carbon\Carbon::parse($dataPoint->week_start)->format('M d, Y') }}',
                    @endforeach
                ],
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderColor: 'rgba(14, 165, 233, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        };

        new Chart(document.getElementById('avgBirdiesTrendChart'), {
            type: 'line',
            data: avgBirdiesTrendData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return 'Week of ' + context[0].dataset.fullDates[context[0].dataIndex];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 0.5
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            maxTicksLimit: 12
                        }
                    }
                }
            }
        });

        // Rounds Per Week Trend Chart
        const roundsTrendData = {
            labels: [
                @foreach($roundsTrend as $dataPoint)
                    '{{ \Carbon\Carbon::parse($dataPoint->week_start)->format('M d') }}',
                @endforeach
            ],
            datasets: [{
                label: 'Rounds Played',
                data: [
                    @foreach($roundsTrend as $dataPoint)
                        {{ $dataPoint->total_rounds }},
                    @endforeach
                ],
                fullDates: [
                    @foreach($roundsTrend as $dataPoint)
                        '{{ \Carbon\Carbon::parse($dataPoint->week_start)->format('M d, Y') }}',
                    @endforeach
                ],
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        };

        new Chart(document.getElementById('roundsTrendChart'), {
            type: 'line',
            data: roundsTrendData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return 'Week of ' + context[0].dataset.fullDates[context[0].dataIndex];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            maxTicksLimit: 12
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
