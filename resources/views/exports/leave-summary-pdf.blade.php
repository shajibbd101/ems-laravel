<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Summary Report</title>

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

<h2>Leave Summary Report</h2>

<table>
    <thead>
        <tr>

            {{-- Leave Columns --}}
            ($type == 'leave Summary')
                <th>Name</th>
                <th>CL</th>
                <th>ML</th>
                <th>RL</th>

        </tr>
    </thead>

    <tbody>
        @foreach($data as $row)
            <tr>

                {{-- Leave Summary Data --}}
                ($type == 'leaves Summary')
                    <td>{{ $row->employee_name }}</td>
                    <td>{{ $row->CL }}</td>
                    <td>{{ $row->ML }}</td>
                    <td>{{ $row->RL }}</td>

            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>