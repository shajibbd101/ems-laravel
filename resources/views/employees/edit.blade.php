<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Edit Employee</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @if($employee->photo)
            <div class="mb-6 flex items-center gap-4">
                <img src="{{ asset('storage/'.$employee->photo) }}" class="w-16 h-16 rounded-full object-cover">
                <span class="text-sm text-gray-500">Current photo</span>
            </div>
        @endif

        <form method="POST" action="{{ route('employees.update', $employee->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ $employee->name }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>               
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $employee->email }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ $employee->phone }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                    <select name="designation" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="Security Guard" {{ $employee->designation == 'Security Guard' ? 'selected' : '' }}>Security Guard</option>
                        <option value="Security Habilder" {{ $employee->designation == 'Security Habilder' ? 'selected' : '' }}>Security Habilder</option>
                        <option value="MasterRole" {{ $employee->designation == 'MasterRole' ? 'selected' : '' }}>MasterRole</option>
                        <option value="Thok" {{ $employee->designation == 'Thok' ? 'selected' : '' }}>Thok</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                    <input type="number" name="salary" value="{{ $employee->salary }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date</label>
                    <input type="date" name="joining_date" value="{{ $employee->joining_date }}"
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Update Employee
                </button>
                <a href="{{ route('employees.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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