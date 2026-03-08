<x-app-layout>

<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-6">
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

            <!-- pagination -->
            <div class="mt-4">
                {{ $summary->onEachSide(1)->links() }}
            </div>

        </form>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-center border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Employee Name</th>
                    <th class="p-3">Total OnDay</th>
                    <th class="p-3">Total OffDay</th>
                </tr>
            </thead>

            <tbody>
                @forelse($summary as $row)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 font-semibold">
                        {{ $row->employee->name }}
                    </td>
                    <td class="p-3 text-green-600 font-bold">
                        {{ $row->total_on }}
                    </td>
                    <td class="p-3 text-yellow-600 font-bold">
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

</div>

</x-app-layout>