<x-app-layout>

<x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 lg:gap-4">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Overtimes</h2>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 lg:gap-3">
            <!-- Search & Filter -->
            <form action="{{ route('overtimes.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name or number" class="pl-9 lg:pl-10 w-40 sm:w-52 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2">
                </div>
            </form>
            <form action="{{ route('overtimes.index') }}" method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2">
                <input type="month" name="month" value="{{ request('month') }}" class="rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2">
                <button type="submit" class="px-2 lg:px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">Filter</button>
                @if(request('date') || request('month'))
                    <a href="{{ route('overtimes.index') }}" class="px-2 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">Clear</a>
                @endif
            </form>

            <!-- Buttons -->
            <div class="flex items-center gap-2">
                <div class="relative group">
                    <button class="flex items-center px-2 lg:px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span class="hidden sm:inline">Export</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                        <a href="{{ route('export.data', ['type' => 'overtimes', 'format' => 'pdf']) }}?search={{ request('search') }}&month={{ request('month') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Export PDF</a>
                        <a href="{{ route('export.data', ['type' => 'overtimes', 'format' => 'excel']) }}?search={{ request('search') }}&month={{ request('month') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Export Excel</a>
                    </div>
                </div>
                <a href="{{ route('overtimes.create') }}" class="flex items-center px-2 lg:px-3 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Add</span>
                </a>
            </div>
        </div>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto">
    @if($overtimes->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-500 text-lg">No overtime records found</p>
            <a href="{{ route('overtimes.create') }}" class="inline-block mt-4 text-emerald-600 hover:text-emerald-700 font-medium">Add your first overtime</a>
        </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full">    
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Shift</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Monthly (On Day)</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Monthly (Off Day)</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-100">
                @foreach($overtimes as $ot)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center justify-center">
                            <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-medium">
                                {{ substr($ot->employee->name, 0, 1) }}
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $ot->employee->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 text-center">{{ $ot->employee->phone }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium 
                            {{ $ot->type == 'OnDay' ? 'bg-emerald-100 text-emerald-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ $ot->type }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        @if($ot->shift)
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $ot->shift }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 text-center">{{ \Carbon\Carbon::parse($ot->date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $monthlyTotals[$ot->employee_id]->total_on ?? 0 }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $monthlyTotals[$ot->employee_id]->total_off ?? 0 }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('overtimes.edit', $ot->id) }}" class="p-1.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form id="delete-form-{{ $ot->id }}" action="{{ route('overtimes.destroy', $ot->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $ot->id }})" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $overtimes->onEachSide(1)->links() }}
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This overtime record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6366f1',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

</x-app-layout>
