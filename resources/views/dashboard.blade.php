<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-lg lg:text-xl font-semibold text-gray-800">
                Dashboard
            </h2>

            <p class="text-xs lg:text-sm text-gray-500">
                {{ now()->format('F Y') }}
            </p>
        </div>
    </x-slot>

    <!-- Stats Grid - Row 1 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Employees</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 lg:mt-2">{{ $totalEmployees }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total Employees</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Monthly Overtime (On Day)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-amber-600 mt-1 lg:mt-2">{{ $monthlyOvertimeOnDay }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Monthly Overtime (Off Day)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-purple-600 mt-1 lg:mt-2">{{ $monthlyOvertimeOffDay }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Monthly Overtime</p>
                    <p class="text-2xl lg:text-3xl font-bold text-blue-600 mt-1 lg:mt-2">{{ $monthlyOvertimeOnDay + $monthlyOvertimeOffDay }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Row 2: Leave Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mt-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Casual Leave (CL)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-emerald-600 mt-1 lg:mt-2">{{ $monthlyCL }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Medical Leave (ML)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-red-500 mt-1 lg:mt-2">{{ $monthlyML }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Restricted Leave (RL)</p>
                    <p class="text-2xl lg:text-3xl font-bold text-indigo-600 mt-1 lg:mt-2">{{ $monthlyRL }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 truncate">Total Monthly Leaves</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 lg:mt-2">{{ $monthlyCL + $monthlyML + $monthlyRL }}</p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers & Quick Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mt-6">
        <!-- Top Overtime Employees -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800 mb-4">Top Overtime This Month</h3>
            @if($topOvertimeEmployees->isNotEmpty())
                <div class="space-y-3">
                    @foreach($topOvertimeEmployees as $employee)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-semibold text-amber-600">{{ substr($employee->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $employee->designation }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                                {{ $employee->overtimes_count }} OT
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No overtime records this month</p>
            @endif
        </div>

        <!-- Top Leave Employees -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800 mb-4">Employees on Leave</h3>
            @if($topLeaveEmployees->where('leaves_count', '>', 0)->isNotEmpty())
                <div class="space-y-3">
                    @foreach($topLeaveEmployees->where('leaves_count', '>', 0) as $employee)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-semibold text-blue-600">{{ substr($employee->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $employee->designation }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                {{ $employee->leaves_count }} Leave
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No leave records this month</p>
            @endif
        </div>

        <!-- Top Leave This Month -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800 mb-4">Top Leave This Month</h3>
            @if($topLeaveEmployees->isNotEmpty())
                <div class="space-y-3">
                    @foreach($topLeaveEmployees as $employee)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs font-semibold text-red-600">{{ substr($employee->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $employee->designation }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                {{ $employee->leaves_count }} Leave
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No leave records this month</p>
            @endif
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mt-6">
        <!-- Recent Employees -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-800">Recent Employees</h3>
                <a href="{{ route('employees.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">View All</a>
            </div>
            @if($recentEmployees->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentEmployees as $employee)
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-xs font-semibold text-emerald-600">{{ substr($employee->name, 0, 1) }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $employee->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $employee->designation }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $employee->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No recent employees</p>
            @endif
        </div>

        <!-- Recent Overtimes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-800">Recent Overtimes</h3>
                <a href="{{ route('overtimes.index') }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium">View All</a>
            </div>
            @if($recentOvertimes->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentOvertimes as $overtime)
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-xs font-semibold text-amber-600">{{ substr($overtime->employee->name ?? 'N/A', 0, 1) }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $overtime->employee->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $overtime->type }} - {{ $overtime->date }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $overtime->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No recent overtimes</p>
            @endif
        </div>

        <!-- Recent Leaves -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-800">Recent Leaves</h3>
                <a href="{{ route('leaves.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">View All</a>
            </div>
            @if($recentLeaves->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentLeaves as $leave)
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-xs font-semibold text-blue-600">{{ substr($leave->employee->name ?? 'N/A', 0, 1) }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $leave->employee->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $leave->type }} - {{ $leave->from_date }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $leave->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No recent leaves</p>
            @endif
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
