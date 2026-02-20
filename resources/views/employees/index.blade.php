<h2>Employee List</h2>

<a href="{{ route('employees.create') }}">Add Employee</a>

<br><br>

@if($employees->isEmpty())
    <p>No employees found</p>
@else

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Photo</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
        <th>Salary</th>
        <th>Action</th>
    </tr>

    @foreach($employees as $employee)
    <tr>
        <td>{{ $employee->id }}</td>
        <td>{{ $employee->name }}</td>
        <td>
            @if($employee->photo)
                <img src="{{ asset('storage/'.$employee->photo) }}" width="60" height="60">
            @else
                No Photo
            @endif
        </td>
        <td>{{ $employee->email }}</td>
        <td>{{ $employee->phone }}</td>
        <td>{{ $employee->department }}</td>
        <td>{{ $employee->salary }}</td>
        <td>
            <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>

            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endif