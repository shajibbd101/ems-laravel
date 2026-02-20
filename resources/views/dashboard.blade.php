<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-bold">Dashboard</h2>
    </x-slot>

    <div class="p-6">
        <div style="background:#4CAF50;color:white;padding:20px;width:250px;">
            <h3>Total Employees</h3>
            <h1>{{ $totalEmployees }}</h1>
        </div>
    </div>

</x-app-layout>