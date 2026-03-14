<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($type) }} Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f2f2f2;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>{{ ucfirst(str_replace('-', ' ', $type)) }} Report</h2>

<table>
    <thead>
        <tr>

            {{-- Employees Columns --}}
            @if($type == 'employees')
                <th>Name</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Salary</th>

            {{-- Leaves Columns --}}
            @elseif($type == 'leaves')
                <th>Employee Name</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>

            {{-- Overtime Columns --}}
            @elseif($type == 'overtimes')
                <th>Employee Name</th>
                <th>Type</th>
                <th>Date</th>
                <th>TotalOnDay</th>
                <th>TotalOffDay</th>
            @endif

        </tr>
    </thead>

    <tbody>
        @foreach($data as $row)
            <tr>

                {{-- Employees Data --}}
                @if($type == 'employees')
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->designation }}</td>
                    <td>{{ $row->salary }}</td>

                {{-- Leaves Data --}}
                @elseif($type == 'leaves')
                    <td>{{ $row->employee->name ?? '' }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->from_date }}</td>
                    <td>{{ $row->to_date }}</td>
                    <td>{{ $row->days }}</td>

                {{-- Overtime Data --}}
                @elseif($type == 'overtimes')
                    <td>{{ $row->employee->name ?? '' }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->total_on_day }}</td>
                    <td>{{ $row->total_off_day }}</td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>