<x-app-layout>

<h2>Add Overtime</h2>

<form method="POST" action="{{ route('overtimes.store') }}">
@csrf

Name:
<select name="employee_id">
@foreach($employees as $emp)
<option value="{{ $emp->id }}">{{ $emp->name }}</option>
@endforeach
</select><br><br>

Type:
<select name="type">
<option>OnDay</option>
<option>OffDay</option>
</select><br><br>

Date:
<input type="date" name="date"><br><br>

<button type="submit">Submit</button>

</form>

</x-app-layout>