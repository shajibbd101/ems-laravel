<h2>Edit Overtime</h2>

<form method="POST" action="{{ route('overtimes.update', $overtime->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    Name: <input type="text" name="name" value="{{ $overtime->employee->name }}"><br><br>
    Type: <input type="text" name="type" value="{{ $overtime->employee->type }}"><br><br>
    Date: <input type="date" name="date" value="{{ $overtime->date }}"><br><br>

    <button type="submit">Update</button>
</form>