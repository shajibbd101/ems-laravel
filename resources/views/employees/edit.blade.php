<x-app-layout>
<div class="max-w-xl mx-auto py-8">

@if($employee->photo)
    <img src="{{ asset('storage/'.$employee->photo) }}" width="100"><br><br>
@endif

    <br>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit Employee</h2>
    <form method="POST" action="{{ route('employees.update', $employee->id) }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" value="{{ $employee->name }}"
                   class="w-full border rounded p-2">               
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ $employee->email }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Phone</label>
            <input type="text" name="phone" value="{{ $employee->phone }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Department</label>
            <input type="text" name="department" value="{{ $employee->department }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Salary</label>
            <input type="text" name="salary" value="{{ $employee->salary }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Joining Date</label>
            <input type="date" name="joining_date" value="{{ $employee->joining_date }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Photo</label>
            <input type="file" name="photo" class="w-full border rounded p-2">
        </div>
        <br>
        <div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>

</x-app-layout>