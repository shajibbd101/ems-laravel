<x-app-layout>

<div class="max-w-xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Leave</h2>

    <form method="POST" action="{{ route('leaves.store') }}"
          class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <select name="employee_id" class="w-full border rounded p-2">
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
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
            <input type="date" name="from_date" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">To Date</label>
            <input type="date" name="to_date" class="w-full border rounded p-2">
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

</x-app-layout>