@if($employee->photo)
    <img src="{{ asset('storage/'.$employee->photo) }}" width="100"><br><br>
@endif

<h2>Edit Employee</h2>

<form method="POST" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    Name: <input type="text" name="name" value="{{ $employee->name }}"><br><br>
    Email: <input type="email" name="email" value="{{ $employee->email }}"><br><br>
    Phone: <input type="text" name="phone" value="{{ $employee->phone }}"><br><br>
    Department: <input type="text" name="department" value="{{ $employee->department }}"><br><br>
    Salary: <input type="text" name="salary" value="{{ $employee->salary }}"><br><br>
    Joining Date: <input type="date" name="joining_date" value="{{ $employee->joining_date }}"><br><br>
    Photo: <input type="file" name="photo"><br><br>

    <button type="submit">Update</button>
</form>