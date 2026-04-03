<x-app-layout>

<x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 lg:gap-4">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Leave Summary ({{ $month->format('F Y') }})</h2>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 lg:gap-3">
            <!-- Search & Filter -->
            <form action="{{ route('leaves.summary') }}" method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name or number" class="pl-9 lg:pl-10 w-40 sm:w-52 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2">
                </div>
            </form>
            <form action="{{ route('leaves.summary') }}" method="GET" class="flex items-center gap-2">
                @php
                    $monthOld = request('month');
                    if ($monthOld) {
                        $monthClean = preg_replace('/-\d+$/', '', $monthOld);
                        if (strpos($monthClean, '/') !== false) {
                            $parts = explode('/', $monthClean);
                            $monthOld = $parts[0] . '/' . $parts[1];
                        } else {
                            $monthOld = \Carbon\Carbon::parse($monthClean . '-01')->format('m/Y');
                        }
                    }
                @endphp
                <input type="text" name="month" id="filter_month" value="{{ $monthOld }}" placeholder="Select month" class="w-36 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2 flatpickr-month">
                <button type="submit" class="px-2 lg:px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">Filter</button>
            </form>

            <!-- Export -->
            <div class="relative group">
                <button class="flex items-center px-2 lg:px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span class="hidden sm:inline">Export</span>
                </button>
                <div class="absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                    <a href="{{ route('export.data', ['type' => 'leave-summary', 'format' => 'pdf']) }}?search={{ request('search') }}&month={{ request('month') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Export PDF</a>
                    <a href="{{ route('export.data', ['type' => 'leave-summary', 'format' => 'excel']) }}?search={{ request('search') }}&month={{ request('month') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Export Excel</a>
                </div>
            </div>
        </div>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto">
    @if($summary->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500 text-lg">No leave data found</p>
        </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full">    
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Total CL</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Total ML</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Total RL</th>
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-100">
                @foreach($summary as $row)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center justify-center">
                            <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-xs font-medium">
                                {{ substr($row->employee->name, 0, 1) }}
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $row->employee->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 text-center">{{ $row->employee->phone }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                            {{ $row->CL }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                            {{ $row->ML }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            {{ $row->RL }}
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthEl = document.getElementById('filter_month');
    const monthValue = monthEl ? monthEl.value : '';
    
    if (monthEl && monthValue) {
        const parts = monthValue.split('/');
        if (parts.length === 2) {
            const defaultDate = new Date(parts[1], parseInt(parts[0]) - 1, 1);
            flatpickr(monthEl, {
                dateFormat: "m/Y",
                allowInput: false,
                defaultDate: defaultDate,
                plugins: [new monthSelectPlugin({
                    dateFormat: "m/Y"
                })],
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length > 0) {
                        const monthStr = (selectedDates[0].getMonth() + 1).toString().padStart(2, '0') + '/' + selectedDates[0].getFullYear();
                        monthEl.value = monthStr;
                    }
                }
            });
        } else {
            flatpickr(monthEl, {
                dateFormat: "m/Y",
                allowInput: false,
                plugins: [new monthSelectPlugin({
                    dateFormat: "m/Y"
                })],
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length > 0) {
                        const monthStr = (selectedDates[0].getMonth() + 1).toString().padStart(2, '0') + '/' + selectedDates[0].getFullYear();
                        monthEl.value = monthStr;
                    }
                }
            });
        }
    } else if (monthEl) {
        flatpickr(monthEl, {
            dateFormat: "m/Y",
            allowInput: false,
            plugins: [new monthSelectPlugin({
                dateFormat: "m/Y"
            })],
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length > 0) {
                    const monthStr = (selectedDates[0].getMonth() + 1).toString().padStart(2, '0') + '/' + selectedDates[0].getFullYear();
                    monthEl.value = monthStr;
                }
            }
        });
    }
});
</script>

</x-app-layout>
