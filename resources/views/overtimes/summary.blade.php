<x-app-layout>

<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-bold text-gray-800">
            Overtime Summary ({{ $month->format('F Y') }})
        </h2>

        <form action="{{ route('overtimes.summary') }}" method="GET" class="flex gap-2">
            <input type="month" name="month"
                   value="{{ request('month') }}"
                   class="border rounded-lg px-4 py-2">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Filter
            </button>
        </form>
    </div>

    <div class="flex justify-between items-center mb-2">
    <!-- add search -->
     <form action="{{ route('overtimes.summary') }}" method="GET" class="flex gap-2 mb-4">

            <input type="search" name="search"
                value="{{ request('search') }}"
                placeholder="Enter name"
                class="border rounded-lg px-4 py-2">

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>

        </form>

        <!-- add export button -->
        <div class="flex justify-end gap-2">
            <a href="{{ route('export.data', ['type' => 'overtime-summary', 'format' => 'pdf']) }}
                    ?search={{ request('search') }}&month={{ request('month') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                Export PDF
            </a>
            <a href="{{ route('export.data', ['type' => 'overtime-summary', 'format' => 'excel']) }}
                    ?search={{ request('search') }}&month={{ request('month') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 ml-2">
                Export Excel
            </a>
        </div>
        <!-- end export button -->

    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-center border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Employee Name</th>
                    <th class="p-2">Total OnDay</th>
                    <th class="p-2">Total OffDay</th>
                </tr>
            </thead>

            <tbody>
                @forelse($summary as $row)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-1 text-center">
                        {{ $row->employee->name }}
                    </td>
                    <td class="p-1 text-green-600 font-bold">
                        {{ $row->total_on }}
                    </td>
                    <td class="p-1 text-yellow-600 font-bold">
                        {{ $row->total_off }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-gray-500">
                        No overtime data found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- pagination -->
    <div class="mt-4">
        {{ $summary->onEachSide(1)->links() }}
    </div>

</div>

</x-app-layout>