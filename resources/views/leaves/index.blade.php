<x-app-layout>

<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-4">
        <br>
        <h2 class="text-3xl font-bold text-gray-800">Leave List</h2>
        <a href="{{ route('leaves.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + Add Leave
        </a>
    </div>

     <!-- add Search Option -->
    <div class="flex justify-between items-center mb-4">
         <!-- 🔍 LEFT: Name Search (existing feature) -->
        <form action="{{ route('leaves.search') }}" method="GET" class="flex gap-2">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Enter name"
                 class="border rounded-lg px-4 py-2">
            <button type="submit"
                 class="bg-blue-600 text-white px-4 py-2 rounded-lg">Search</button>
        </form>
        <!-- 📅 RIGHT: Month Filter (new feature) -->
        <form action="{{ route('leaves.index') }}" method="GET" class="flex gap-2">
            <input type="month" name="month"
                class="border rounded-lg px-4 py-2">
             <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Month
            </button>
        </form>   
    </div>
     <!-- end Search Option -->

     <!-- add export button -->
        <div class="flex justify-end mb-4 gap-2">
            <a href="{{ route('export.data', ['type' => 'leaves', 'format' => 'pdf']) }}
                    ?search={{ request('search') }}&month={{ request('month') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                Export PDF
            </a>
            <a href="{{ route('export.data', ['type' => 'leaves', 'format' => 'excel']) }}
                    ?search={{ request('search') }}&month={{ request('month') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 ml-2">
                Export Excel
            </a>
        </div>
        <!-- end export button -->

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-center">Name</th>
                    <th class="p-2 text-center">Type</th>
                    <th class="p-2 text-center">From</th>
                    <th class="p-2 text-center">To</th>
                    <th class="p-2 text-center">Days</th>
                    <th class="p-2 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($leaves as $leave)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-1 text-center">{{ $leave->employee->name }}</td>
                    <td class="p-1 text-center">
                        <span class="px-2 py-1 rounded text-sm 
                            {{ $leave->type == 'CL' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $leave->type }}
                        </span>
                    </td>
                    <td class="p-1 text-center">{{ $leave->from_date }}</td>
                    <td class="p-1 text-center">{{ $leave->to_date }}</td>
                    <td class="p-1 text-center">{{ $leave->days }}</td>
                    <td class="p-1 text-center">
                        <a href="{{ route('leaves.edit', $leave->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        |
                        <form id="delete-form-{{ $leave->id }}"
                            action="{{ route('leaves.destroy', $leave->id) }}" 
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="confirmDelete({{ $leave->id }})"
                                    class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
         {{ $leaves->onEachSide(1)->links() }}
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