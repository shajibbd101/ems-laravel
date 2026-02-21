<x-app-layout>

<a href="{{ route('overtimes.create') }}">Add Overtime</a>

<h2>Overtime List</h2>

<table border="1">
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Date</th>
    <th>Action</th>
</tr>

@foreach($overtimes as $ot)
<tr>
    <td>{{ $ot->employee->name }}</td>
    <td>{{ $ot->type }}</td>
    <td>{{ $ot->date }}</td>
    <td>
        <a href="{{ route('overtimes.edit', $ot->id) }}">Edit</a>

        <form action="{{ route('overtimes.destroy', $ot->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

</x-app-layout>