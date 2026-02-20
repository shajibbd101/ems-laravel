<h2>Add Employee</h2>

<form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
    @csrf

    Name: <input type="text" name="name"><br><br>
    Email: <input type="email" name="email"><br><br>
    Phone: <input type="text" name="phone"><br><br>
    Department: <input type="text" name="department"><br><br>
    Salary: <input type="text" name="salary"><br><br>
    Joining Date: <input type="date" name="joining_date"><br><br>
    Photo: <input type="file" name="photo"><br><br>

    <button type="submit">Save</button>
</form>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif