<x-app-layout>

<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Leave List</h2>
        <a href="{{ route('leaves.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + Add Leave
        </a>
    </div>


    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">From</th>
                    <th class="p-3">To</th>
                    <th class="p-3">Days</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($leaves as $leave)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $leave->employee->name }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm 
                            {{ $leave->type == 'CL' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $leave->type }}
                        </span>
                    </td>
                    <td class="p-3">{{ $leave->from_date }}</td>
                    <td class="p-3">{{ $leave->to_date }}</td>
                    <td class="p-3">{{ $leave->days }}</td>
                    <td class="p-3 text-center flex gap-2 justify-center">

                        <a href="{{ route('leaves.edit', $leave->id) }}"
                           class="bg-indigo-500 text-black px-3 py-1 rounded hover:bg-indigo-600">
                            Edit
                        </a>

                        <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-black px-3 py-1 rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-app-layout>