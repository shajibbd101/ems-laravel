<x-app-layout>
<div class="max-w-xl mx-auto py-8">
    <br>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit Overtime</h2>

    <form method="POST" action="{{ route('overtimes.update', $overtime->id) }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Employee</label>
            <select name="employee_id" class="w-full border rounded p-2">
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}"
                        {{ $overtime->employee_id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="OnDay" {{ $overtime->type == 'OnDay' ? 'selected' : '' }}>On Day</option>
                <option value="OffDay" {{ $overtime->type == 'OffDay' ? 'selected' : '' }}>Off Day</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Date</label>
            <input type="date" name="date"
                   value="{{ $overtime->date }}"
                   class="w-full border rounded p-2">
        </div>
        <br>
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Update
        </button>

    </form>

</div>
</x-app-layout>