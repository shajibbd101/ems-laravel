<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-bold">Dashboard</h2>
    </x-slot>

    <!-- Total Employee -->
    <div class="p-6">
        <div style="background:#4CAF50;color:white;padding:20px;width:250px;">
            <h3>Total Employees</h3>
            <h1>{{ $totalEmployees }}</h1>
        </div>
    </div>
    <!-- End Total Employee -->

    <!-- Total overtime -->
    <div class="p-6">
        <div style="background:#4CAF50;color:white;padding:20px;width:300px;">
            <h3>Total Monthly Overtime (On Day)</h3>
            <h1>{{ $totalOvertimeOnDay }}</h1>
        </div>
    </div>

    <div class="p-6">
        <div style="background:#4CAF50;color:white;padding:20px;width:300px;">
            <h3>Total Monthly Overtime (Off Day)</h3>
            <h1>{{ $totalOvertimeOffDay }}</h1>
        </div>
    </div>
    <!-- End Total Overtime -->

</x-app-layout>