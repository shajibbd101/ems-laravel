<x-app-layout>
<div class="max-w-xl mx-auto py-8">
    <br>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Add Overtime</h2>

    <form method="POST" action="{{ route('overtimes.store') }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Name</label>
            
            <input type="text" id="employee_search"
                class="w-full border rounded p-2"
                placeholder="Type employee name...">

            <!-- Hidden field to store selected employee ID -->
            <input type="hidden" name="employee_id" id="employee_id">

            <!-- Suggestion box -->
            <div id="suggestions"
                class="border rounded bg-white mt-1 hidden"></div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="OnDay">On Day</option>
                <option value="OffDay">Off Day</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Date</label>
            <input type="date" name="date" class="w-full border rounded p-2">
        </div>
        <br>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Save
        </button>

    </form>

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
                    div.classList.add('p-2', 'hover:bg-gray-200', 'cursor-pointer');
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