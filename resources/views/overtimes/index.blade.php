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

    <div class="flex justify-between items-center mb-4">
        <!-- 🔍 LEFT: Name Search (existing feature) -->
        <form action="{{ route('overtimes.search') }}" method="GET" class="flex gap-2">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Enter name"
                class="border rounded-lg px-4 py-2">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>
        </form>
        <!-- 📅 RIGHT: Month Filter (new feature) -->
        <form action="{{ route('overtimes.index') }}" method="GET" class="flex gap-2">
            <input type="month" name="month"
                class="border rounded-lg px-4 py-2">
             <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Month
            </button>
        </form>
    </div>
     <!-- end Search Option -->
        <div>
            {{ $overtimes->onEachSide(1)->links() }}
        </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-center">Name</th>
                    <th class="p-3 text-center">Type</th>
                    <th class="p-3 text-center">Date</th>
                    <th class="p-3 text-center">TotalOnDay</th>
                    <th class="p-3 text-center">TotalOffDay</th>
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
                        {{ $monthlyTotals[$ot->employee_id]->total_on ?? 0 }}
                    </td>
                     <td class="p-3 text-center">
                        {{ $monthlyTotals[$ot->employee_id]->total_off ?? 0 }}
                    </td>
                    <td class="p-3 text-center">
                        <a href="{{ route('overtimes.edit', $ot->id) }}" 
                            class="text-blue-600 hover:underline">Edit</a>
                        |
                        <form id="delete-form-{{ $ot->id }}"
                            action="{{ route('overtimes.destroy', $ot->id) }}" 
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="confirmDelete({{ $ot->id }})"
                                    class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- success messages -->
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

<!-- sweetalert confirmation delete -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This employee will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
<!-- end delete confirmation -->

</x-app-layout>