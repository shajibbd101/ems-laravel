<x-app-layout>

<div class="max-w-xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Employee</h2>

    <form method="POST" action="{{ route('employees.store') }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Phone</label>
            <input type="text" name="phone" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Department</label>
            <input type="text" name="department" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Salary</label>
            <input type="text" name="salary" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Joining Date</label>
            <input type="date" name="joining_date" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Photo</label>
            <input type="file" name="photo" class="w-full border rounded p-2">
        </div>

        <div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Submit
            </button>
        </div>
    </form>
</div>
<!-- end -->
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

</x-app-layout>