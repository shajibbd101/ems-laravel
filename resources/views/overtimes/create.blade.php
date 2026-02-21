<x-app-layout>
<div class="max-w-xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Overtime</h2>

    <form method="POST" action="{{ route('overtimes.store') }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Employee</label>
            <select name="employee_id" class="w-full border rounded p-2">
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="OnDay">On Day</option>
                <option value="OffDay">Off Day</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Date</label>
            <input type="date" name="date" class="w-full border rounded p-2">
        </div>
        <br>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Save
        </button>

    </form>

</div>
</x-app-layout>