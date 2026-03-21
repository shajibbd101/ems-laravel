<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Edit Leave</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('leaves.update', $leave->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                <input type="text" name="name" value="{{ $leave->employee->name }}"
                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-emerald-500 focus:ring-emerald-500" readonly>
                <input type="hidden" name="employee_id" value="{{ $leave->employee_id }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="CL" {{ $leave->type == 'CL' ? 'selected' : '' }}>Casual Leave</option>
                    <option value="ML" {{ $leave->type == 'ML' ? 'selected' : '' }}>Medical Leave</option>
                    <option value="RL" {{ $leave->type == 'RL' ? 'selected' : '' }}>Restricted Leave</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="from_date" id="from_date"
                        value="{{ $leave->from_date }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="to_date" id="to_date"
                        value="{{ $leave->to_date }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Update
                </button>
                <a href="{{ route('leaves.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const fromDate = document.getElementById('from_date');
    const toDate = document.getElementById('to_date');

    fromDate.addEventListener('change', function () {
        toDate.min = this.value;
        if (toDate.value < this.value) {
            toDate.value = '';
        }
    });

    window.onload = function () {
        if (fromDate.value) {
            toDate.min = fromDate.value;
        }
    };
</script>

</x-app-layout>