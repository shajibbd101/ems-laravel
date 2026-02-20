<x-app-layout>

<a href="{{ route('overtimes.create') }}">Add Overtime</a>

<h2>Overtime List</h2>

<table border="1">
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Date</th>
</tr>

@foreach($overtimes as $ot)
<tr>
    <td>{{ $ot->employee->name }}</td>
    <td>{{ $ot->type }}</td>
    <td>{{ $ot->date }}</td>
</tr>
@endforeach

</table>

</x-app-layout>