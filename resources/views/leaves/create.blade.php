<x-app-layout>

<div class="max-w-xl mx-auto py-8">
    <br>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Add Leave</h2>

    <form method="POST" action="{{ route('leaves.store') }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
<!-- 
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        <div>
            <label class="block mb-1 font-medium">Name</label>
            
            <input type="text" id="employee_search"
                class="w-full border rounded p-2"
                placeholder="Type employee name...">

            <!-- Hidden field to store selected employee ID -->
            <input type="hidden" name="employee_id" id="employee_id">
            @error('employee_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Suggestion box -->
            <div id="suggestions"
                class="border rounded bg-white mt-1 hidden"></div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="CL">Casual Leave</option>
                <option value="ML">Medical Leave</option>
                <option value="RL">Restricted Leave</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">From Date</label>
            <input type="date" name="from_date" id="from_date"
                   class="w-full border rounded p-2">
            @error('from_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">To Date</label>
            <input type="date" name="to_date" id="to_date"
                   class="w-full border rounded p-2">
            @error('to_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Submit
            </button>
        </div>       
    </form>    
</div>

<!-- add new -->

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

//smart date validation

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

</x-app-layout>