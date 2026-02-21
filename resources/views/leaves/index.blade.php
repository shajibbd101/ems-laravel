<x-app-layout>

<a href="{{ route('leaves.create') }}">Add Leave</a>

<h2>Leave List</h2>

<table border="1">
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>From</th>
    <th>To</th>
    <th>Days</th>
    <th>Action</th>
</tr>

@foreach($leaves as $leave)
<tr>
    <td>{{ $leave->employee->name ?? 'N/A' }}</td>
    <td>{{ $leave->type }}</td>
    <td>{{ $leave->from_date }}</td>
    <td>{{ $leave->to_date }}</td>
    <td>{{ $leave->days }}</td>

    <td>
<!--Edit Button-->
        <a href="{{ route('leaves.edit', $leave->id) }}">Edit</a>

        <!-- Delete Button -->
         <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

</x-app-layout>