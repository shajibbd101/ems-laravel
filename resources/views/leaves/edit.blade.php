<x-app-layout>

<h2>Edit Leave</h2>

<form action="{{ route('leaves.update', $leave->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Employee:</label>
    <select name="employee_id">
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}"
                {{ $leave->employee_id == $emp->id ? 'selected' : '' }}>
                {{ $emp->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Type:</label>
    <select name="type">
        <option value="CL" {{ $leave->type == 'CL' ? 'selected' : '' }}>CL</option>
        <option value="ML" {{ $leave->type == 'ML' ? 'selected' : '' }}>ML</option>
        <option value="RL" {{ $leave->type == 'RL' ? 'selected' : '' }}>RL</option>
    </select>

    <br><br>

    <label>From Date:</label>
    <input type="date" name="from_date" value="{{ $leave->from_date }}">

    <br><br>

    <label>To Date:</label>
    <input type="date" name="to_date" value="{{ $leave->to_date }}">

    <br><br>

    <button type="submit">Update</button>
</form>

</x-app-layout>