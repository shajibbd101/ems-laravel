<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">Overtime Summary ({{ $month->format('F Y') }})</h2>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto">
    <!-- Actions Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search & Filter -->
            <div class="flex flex-col sm:flex-row gap-3 flex-1">
                <form action="{{ route('overtimes.summary') }}" method="GET" class="flex items-center gap-2 flex-1 max-w-xs">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name" class="pl-10 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                </form>
                <form action="{{ route('overtimes.summary') }}" method="GET" class="flex items-center gap-2">
                    <input type="month" name="month" value="{{ request('month') }}" class="rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    <button type="submit" class="px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">Filter</button>
                </form>
            </div>

            <!-- Export Buttons -->
            <div class="relative group">
                <button class="flex items-center px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export
                </button>
                <div class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                    <a href="{{ route('export.data', ['type' => 'overtime-summary', 'format' => 'pdf']) }}?search={{ request('search') }}&month={{ request('month') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Export PDF</a>
                    <a href="{{ route('export.data', ['type' => 'overtime-summary', 'format' => 'excel']) }}?search={{ request('search') }}&month={{ request('month') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Export Excel</a>
                </div>
            </div>
        </div>
    </div>

    @if($summary->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-500 text-lg">No overtime data found</p>
        </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full">    
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total On Day</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Off Day</th>
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-100">
                @foreach($summary as $row)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-medium">
                                {{ substr($row->employee->name, 0, 1) }}
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $row->employee->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                            {{ $row->total_on }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                            {{ $row->total_off }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $summary->onEachSide(1)->links() }}
    </div>
    @endif
</div>

</x-app-layout>