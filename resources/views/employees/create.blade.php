<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Add Employee</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('employees.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                    <select name="designation" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="Security Guard">Security Guard</option>
                        <option value="Security Habilder">Security Habilder</option>
                        <option value="MasterRole">MasterRole</option>
                        <option value="Thok">Thok</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                    <input type="number" name="salary" value="{{ old('salary') }}" 
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date</label>
                    @php
                        $joiningDateOld = old('joining_date');
                        if ($joiningDateOld && strpos($joiningDateOld, '/') === false) {
                            $joiningDateOld = \Carbon\Carbon::parse($joiningDateOld)->format('d/m/Y');
                        }
                    @endphp
                    <input type="text" name="joining_date" id="joining_date" 
                        value="{{ $joiningDateOld }}"
                        placeholder="Select date"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 flatpickr-date">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Add Employee
                </button>
                <a href="{{ route('employees.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const joiningDateEl = document.getElementById('joining_date');
    
    const joiningPicker = flatpickr(joiningDateEl, {
        dateFormat: "d/m/Y",
        allowInput: false
    });
    
    if (joiningDateEl.value) {
        joiningPicker.setDate(joiningDateEl.value, true);
    }
});
</script>

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        text: '{{ $errors->first() }}',
    });
</script>
@endif

</x-app-layout>