<x-app-layout>

<div class="max-w-xl mx-auto py-8">
    <br>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit Leave</h2>

    <form method="POST" action="{{ route('leaves.update', $leave->id) }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Employee</label>
            <select name="employee_id" class="w-full border rounded p-2">
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}"
                        {{ $leave->employee_id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

         <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="CL" {{ $leave->type == 'CL' ? 'selected' : '' }}>Casual Leave</option>
                <option value="ML" {{ $leave->type == 'ML' ? 'selected' : '' }}>Medical Leave</option>
                <option value="RL" {{ $leave->type == 'RL' ? 'selected' : '' }}>Restricted Leave</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">From Date</label>
            <input type="date" name="from_date"
                   value="{{ $leave->from_date }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">To Date</label>
            <input type="date" name="to_date"
                   value="{{ $leave->to_date }}"
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