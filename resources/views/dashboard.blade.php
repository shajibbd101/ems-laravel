<x-app-layout>

    <x-slot name="header">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Total Employees -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Employees</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 lg:mt-2">{{ $totalEmployees }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Monthly Overtime (On Day) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Overtime (On Day)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 lg:mt-2">{{ $totalOvertimeOnDay }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Monthly Overtime (Off Day) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Overtime (Off Day)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 lg:mt-2">{{ $totalOvertimeOffDay }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Overtime -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Overtime</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 lg:mt-2">{{ $totalOvertimeOnDay + $totalOvertimeOffDay }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 lg:mt-8">
        <h3 class="text-base lg:text-lg font-semibold text-gray-800 mb-3 lg:mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('employees.create') }}" class="flex items-center p-3 lg:p-4 bg-white rounded-lg border border-gray-200 hover:border-emerald-500 hover:shadow-md transition-all group">
                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 lg:mr-4 flex-shrink-0 group-hover:bg-emerald-500 transition-colors">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-emerald-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-900 text-sm lg:text-base">Add Employee</p>
                    <p class="text-xs lg:text-sm text-gray-500 hidden sm:block">Register new employee</p>
                </div>
            </a>

            <a href="{{ route('leaves.create') }}" class="flex items-center p-3 lg:p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all group">
                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 lg:mr-4 flex-shrink-0 group-hover:bg-blue-500 transition-colors">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-900 text-sm lg:text-base">Request Leave</p>
                    <p class="text-xs lg:text-sm text-gray-500 hidden sm:block">Submit leave request</p>
                </div>
            </a>

            <a href="{{ route('overtimes.create') }}" class="flex items-center p-3 lg:p-4 bg-white rounded-lg border border-gray-200 hover:border-amber-500 hover:shadow-md transition-all group">
                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-3 lg:mr-4 flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-amber-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-900 text-sm lg:text-base">Log Overtime</p>
                    <p class="text-xs lg:text-sm text-gray-500 hidden sm:block">Record overtime hours</p>
                </div>
            </a>
        </div>
    </div>

</x-app-layout>