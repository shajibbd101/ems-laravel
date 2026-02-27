<x-app-layout>

<div class="max-w-7xl mx-auto py-8 px-4">
    
    <div class="flex justify-between items-center mb-6">
        <br><br><br>
        <h2 class="text-3xl font-bold text-gray-800 text-center">Employee List</h2>
        <a href="{{ route('employees.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + Add Employee
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

    @if($employees->isEmpty())
        <p>No employees found</p>
    @else

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-center">ID</th>
                    <th class="p-3 text-center">Name</th>
                    <th class="p-3 text-center">Photo</th>
                    <th class="p-3 text-center">Email</th>
                    <th class="p-3 text-center">Phone</th>
                    <th class="p-3 text-center">Designation</th>
                    <th class="p-3 text-center">Salary</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($employees as $employee)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-center">{{ $employee->id }}</td>
                    <td class="p-3 text-center">{{ $employee->name }}</td>
                    <td class="p-3 text-center">
                        @if($employee->photo)
                            <img src="{{ asset('storage/'.$employee->photo) }}" width="60" height="60">
                        @else
                            No Photo
                        @endif
                    </td>
                    <td class="p-3 text-center">{{ $employee->email }}</td>
                    <td class="p-3 text-center">{{ $employee->phone }}</td>
                    <td class="p-3 text-center">{{ $employee->designation }}</td>
                    <td class="p-3 text-center">{{ $employee->salary }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        |
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
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
@endif
</x-app-layout>