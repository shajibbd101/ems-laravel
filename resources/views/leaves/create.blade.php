<x-app-layout>

<h2>Add Leave</h2>

<form method="POST" action="{{ route('leaves.store') }}">
@csrf

Name:
<select name="employee_id">
@foreach($employees as $emp)
    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
@endforeach
</select><br><br>

Type:
<select name="type">
    <option>CL</option>
    <option>ML</option>
    <option>RL</option>
</select><br><br>

From Date:
<input type="date" name="from_date"><br><br>

To Date:
<input type="date" name="to_date"><br><br>

<button type="submit">Submit</button>

</form>

</x-app-layout>