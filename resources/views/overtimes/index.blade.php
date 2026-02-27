<x-app-layout>
   

<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-6">
        <br><br><br>
        <h2 class="text-3xl font-bold text-gray-800">Overtime List</h2>
        <a href="{{ route('overtimes.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + Add Overtime
        </a>
    </div>

    <!-- add Search Option -->
    <div>
        <form action="{{ route('name_search') }}" method="GET">
            <input type="search" name="search" placeholder="Enter name" class="border rounded-lg px-4 py-2 w-1/2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Search</button>
        </form>
    </div>
    <br>
     <!-- end Search Option -->

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-center">Name</th>
                    <th class="p-3 text-center">Type</th>
                    <th class="p-3 text-center">Date</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($overtimes as $ot)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-center">{{ $ot->employee->name }}</td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 rounded text-sm 
                            {{ $ot->type == 'OnDay' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $ot->type }}
                        </span>
                    </td>
                    <td class="p-3 text-center">{{ $ot->date }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('overtimes.edit', $ot->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        |
                        <form action="{{ route('overtimes.destroy', $ot->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>