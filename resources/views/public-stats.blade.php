<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golf Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Golf Statistics</h1>
                <p class="text-lg text-gray-600">Golf performance tracker</p>
            </div>

            <!-- Aggregate Stats Section -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Overall Stats</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $aggregateStats->total_rounds ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Rounds</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $aggregateStats->total_eagles ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Eagles</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $aggregateStats->total_birdies ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Birdies</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-600">{{ $aggregateStats->total_putts ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Putts</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-orange-600">{{ $aggregateStats->total_bogeys ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Bogeys</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $aggregateStats->total_double_bogeys ?? 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Double Bogeys+</div>
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
                                    Player
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rounds
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Eagles
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Birdies
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Putts
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bogeys
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Double Bogeys+
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($userStats as $stat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $stat->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_rounds }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_eagles }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_birdies }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_putts }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_bogeys }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stat->total_double_bogeys }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
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
                    <a href="/user" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
