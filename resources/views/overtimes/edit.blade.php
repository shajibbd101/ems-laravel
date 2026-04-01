<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Edit Overtime</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('overtimes.update', $overtime->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                <input type="text" name="name" value="{{ $overtime->employee->name }}"
                    class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-emerald-500 focus:ring-emerald-500" readonly>
                <input type="hidden" name="employee_id" value="{{ $overtime->employee_id }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="OnDay" {{ $overtime->type == 'OnDay' ? 'selected' : '' }}>On Day</option>
                    <option value="OffDay" {{ $overtime->type == 'OffDay' ? 'selected' : '' }}>Off Day</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="text" name="date" id="date"
                    value="{{ \Carbon\Carbon::parse($overtime->date)->format('d/m/Y') }}"
                    placeholder="Select date"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Update
                </button>
                <a href="{{ route('overtimes.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#date", {
        dateFormat: "d/m/Y",
        allowInput: false
    });
});
</script>

</x-app-layout>