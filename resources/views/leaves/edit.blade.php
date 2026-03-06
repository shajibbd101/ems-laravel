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
            <input type="text" name="name" value="{{ $leave->employee->name }}"
                   class="w-full border rounded p-2" readonly>
            <input type="hidden" name="employee_id" value="{{ $leave->employee_id }}">
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
            <input type="date" name="from_date" id="from_date"
                   value="{{ $leave->from_date }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">To Date</label>
            <input type="date" name="to_date" id="to_date"
                   value="{{ $leave->to_date }}"
                   class="w-full border rounded p-2">
        </div>
        <br>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Update
        </button>
    </form>

    <script>
        const fromDate = document.getElementById('from_date');
        const toDate = document.getElementById('to_date');

        fromDate.addEventListener('change', function () {
            toDate.min = this.value;

            // If to_date is earlier than from_date, clear it
            if (toDate.value < this.value) {
                toDate.value = '';
            }
        });

        // Set initial min when page loads (for edit page)
        window.onload = function () {
            if (fromDate.value) {
                toDate.min = fromDate.value;
            }
        };
    </script>
</div>

</x-app-layout>