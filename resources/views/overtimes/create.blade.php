<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Add Overtime</h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('overtimes.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                <input type="text" id="employee_search"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Type employee name...">
                <input type="hidden" name="employee_id" id="employee_id">
                @error('employee_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="suggestions" class="border rounded bg-white mt-1 hidden shadow-lg max-h-48 overflow-y-auto"></div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="OnDay">On Day</option>
                    <option value="OffDay">Off Day</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
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

<script>
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