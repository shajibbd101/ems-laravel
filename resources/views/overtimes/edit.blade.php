<x-app-layout>

<h2>Edit Overtime</h2>

<form method="POST" action="{{ route('overtimes.update', $overtime->id) }}">
@csrf
@method('PUT')

Name:
<select name="employee_id">
@foreach($employees as $emp)
<option value="{{ $emp->id }}"
    {{ $overtime->employee_id == $emp->id ? 'selected' : '' }}>
    {{ $emp->name }}
</option>
@endforeach
</select>
<br><br>

Type:
<select name="type">
<option {{ $overtime->type == 'OnDay' ? 'selected' : '' }}>OnDay</option>
<option {{ $overtime->type == 'OffDay' ? 'selected' : '' }}>OffDay</option>
</select>
<br><br>

Date:
<input type="date" name="date" value="{{ $overtime->date }}">
<br><br>

<button type="submit">Update</button>

</form>

</x-app-layout>