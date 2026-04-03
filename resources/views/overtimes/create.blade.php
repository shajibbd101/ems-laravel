<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Add Overtime</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('overtimes.store') }}" class="space-y-6">
            @csrf

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="employee_phone" 
                        value="{{ old('employee_phone') }}"
                        class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-emerald-500 focus:ring-emerald-500"
                        readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="OnDay" {{ old('type') == 'OnDay' ? 'selected' : '' }}>On Day</option>
                        <option value="OffDay" {{ old('type') == 'OffDay' ? 'selected' : '' }}>Off Day</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shift</label>
                    <select name="shift" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Select Shift</option>
                        <option value="A" {{ old('shift') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('shift') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('shift') == 'C' ? 'selected' : '' }}>C</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                @php
                    $dateOld = old('date');
                    if ($dateOld && strpos($dateOld, '/') === false) {
                        $dateOld = \Carbon\Carbon::parse($dateOld)->format('d/m/Y');
                    }
                @endphp
                <input type="text" name="date" id="date" 
                    value="{{ $dateOld }}"
                    placeholder="Select date"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Save
                </button>
                <a href="{{ route('overtimes.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
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
    const dateEl = document.getElementById('date');
    const employeeSearch = document.getElementById('employee_search');
    const employeeId = document.getElementById('employee_id');
    const employeeName = document.getElementById('employee_name');
    
    const datePicker = flatpickr(dateEl, {
        dateFormat: "d/m/Y",
        allowInput: false
    });
    
    // Initialize flatpickr with old values after validation errors
    if (dateEl.value) {
        datePicker.setDate(dateEl.value, true);
    }
    
    const nameValue = employeeName ? employeeName.value : '';
    if (nameValue) {
        employeeSearch.value = nameValue;
    }
    
    if (employeeId && employeeId.value && employeeSearch.value) {
        employeeSearch.readOnly = true;
    }
});

document.getElementById('employee_search').addEventListener('keyup', function () {
    let query = this.value;

    if (query.length < 1) {
        document.getElementById('suggestions').classList.add('hidden');
        return;
    }

    fetch(`/employee-search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            let suggestions = document.getElementById('suggestions');
            suggestions.innerHTML = '';

            if (data.length > 0) {
                suggestions.classList.remove('hidden');

                data.forEach(emp => {
                    let div = document.createElement('div');
                    div.classList.add('p-3', 'hover:bg-emerald-50', 'cursor-pointer', 'border-b', 'last:border-b-0');
                    div.innerText = emp.name;

                    div.onclick = function () {
                        document.getElementById('employee_search').value = emp.name;
                        document.getElementById('employee_id').value = emp.id;
                        document.getElementById('employee_name').value = emp.name;
                        document.getElementById('employee_phone').value = emp.phone || '';
                        suggestions.classList.add('hidden');
                    };

                    suggestions.appendChild(div);
                });
            } else {
                suggestions.classList.add('hidden');
            }
        });
});
</script>

</x-app-layout>