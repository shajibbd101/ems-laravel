<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Add Leave</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('leaves.store') }}" class="space-y-6">
            @csrf

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                <input type="text" id="employee_search"
                    value="{{ old('employee_name', session('employee_name')) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Type employee name...">
                <input type="hidden" name="employee_id" id="employee_id" value="{{ old('employee_id') }}">
                <input type="hidden" name="employee_name" id="employee_name" value="{{ old('employee_name', session('employee_name')) }}">
                @error('employee_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="suggestions" class="border rounded bg-white mt-1 hidden shadow-lg max-h-48 overflow-y-auto"></div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="CL" {{ old('type') == 'CL' ? 'selected' : '' }}>Casual Leave</option>
                    <option value="ML" {{ old('type') == 'ML' ? 'selected' : '' }}>Medical Leave</option>
                    <option value="RL" {{ old('type') == 'RL' ? 'selected' : '' }}>Restricted Leave</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="text" name="from_date" id="from_date" 
                        value="{{ old('from_date') }}"
                        placeholder="Select date"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 flatpickr-date">
                    @error('from_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="text" name="to_date" id="to_date" 
                        value="{{ old('to_date') }}"
                        placeholder="Select date"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 flatpickr-date">
                    @error('to_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Submit
                </button>
                <a href="{{ route('leaves.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>    
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}",
    });
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fromDateEl = document.getElementById('from_date');
    const toDateEl = document.getElementById('to_date');
    
    const fromPicker = flatpickr(fromDateEl, {
        dateFormat: "d/m/Y",
        allowInput: false,
        onChange: function(selectedDates, dateStr) {
            toPicker.set('minDate', dateStr);
        }
    });
    
    const toPicker = flatpickr(toDateEl, {
        dateFormat: "d/m/Y",
        allowInput: false
    });
    
    if (fromDateEl.value) {
        toPicker.set('minDate', fromDateEl.value);
    }
});
</script>

</x-app-layout>