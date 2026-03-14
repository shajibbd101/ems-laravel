<!-- <h3>Overtime Summary</h3>

<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Total OnDay</th>
            <th>Total OffDay</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->employee_name }}</td>
            <td>{{ $row->total_on_day }}</td>
            <td>{{ $row->total_off_day }}</td>
        </tr>
        @endforeach
    </tbody>
</table> -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>overtime Summary Report</title>

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

<h2>Overtime Summary Report</h2>

<table>
    <thead>
        <tr>

            {{-- Overtime Columns --}}
            ($type == 'overtime Summary')
                <th>Name</th>
                <th>Total OnDay</th>
                <th>Total OffDay</th>

        </tr>
    </thead>

    <tbody>
        @foreach($data as $row)
            <tr>

                {{-- Overtime Summary Data --}}
                ($type == 'overtimes Summary')
                    <td>{{ $row->employee_name }}</td>
                    <td>{{ $row->total_on_day }}</td>
                    <td>{{ $row->total_off_day }}</td>

            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>