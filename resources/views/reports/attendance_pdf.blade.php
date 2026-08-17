<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>تقرير حضور الموظفين</title>
    <style>
        @font-face {
            font-family: 'Cairo';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("fonts/Cairo-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Cairo';
            font-style: normal;
            font-weight: bold;
            src: url('{{ public_path("fonts/Cairo-Bold.ttf") }}') format('truetype');
        }

        @page {
            margin: 20px 25px; /* هوامش صغيرة جداً للورقة لكي يتمدد الجدول بالكامل */
        }

        body {
            font-family: 'Cairo', sans-serif;
            direction: ltr;
            text-align: right;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .header-container {
            text-align: center;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header-container h2 {
            margin: 0 0 3px 0;
            color: #0f172a;
            font-size: 18px;
            font-weight: bold;
        }

        .header-container h4 {
            margin: 0;
            color: #64748b;
            font-size: 12px;
            font-weight: normal;
        }

        .info-table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        .info-table td {
            border: none;
            padding: 0;
            font-size: 10px;
            color: #334155;
        }

        .stats-box {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: separate;
            border-spacing: 5px;
            table-layout: fixed;
        }

        .stats-box td {
            border: 1px solid #cbd5e1;
            padding: 5px 3px;
            text-align: center;
            background-color: #f8fafc;
            border-radius: 4px;
        }

        .stats-box .label {
            font-size: 10px;
            color: #475569;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .stats-box .number {
            font-size: 14px;
            font-weight: bold;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            table-layout: fixed;
        }

        .report-table th, .report-table td {
            border: 1px solid #cbd5e1;
            padding: 4px 6px; /* بادينج صغير جداً لجعل السجلات مستطيلة وصغيرة */
            text-align: center;
            font-size: 11px;
            word-wrap: break-word;
            vertical-align: middle;
        }

        .report-table th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
            font-size: 11px;
            padding: 6px 6px;
        }

        .report-table td.employee-name {
            text-align: right;
            font-weight: bold;
            color: #0f172a;
        }

        .text-success { color: #15803d; font-weight: bold; }
        .text-danger { color: #b91c1c; font-weight: bold; }
        .text-warning { color: #a16207; font-weight: bold; }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }
    </style>
</head>

<body>

    <div class="header-container">
        <h2>{{ $labels['title'] }}</h2>
        <h4>{{ $labels['subtitle'] }}</h4>
    </div>

    <table class="info-table">
        <tr>
            <td style="text-align: left;">
                <strong>{{ $labels['printed_at'] }}</strong> {{ now()->format('Y-m-d H:i') }}
            </td>
            <td style="text-align: right;">
                {{ $toDate }} <strong>{{ $labels['to'] }}</strong> &nbsp; | &nbsp; 
                {{ $fromDate }} <strong>{{ $labels['from'] }}</strong> 
            </td>
        </tr>
    </table>

    <table class="stats-box">
        <tr>
            <td>
                <div class="label" style="color: #a16207;">{{ $labels['total_late'] }}</div>
                <div class="number text-warning">{{ $summary['total_late'] }}</div>
            </td>
            <td>
                <div class="label" style="color: #b91c1c;">{{ $labels['total_absent'] }}</div>
                <div class="number text-danger">{{ $summary['total_absent'] }}</div>
            </td>
            <td>
                <div class="label" style="color: #15803d;">{{ $labels['total_present'] }}</div>
                <div class="number text-success">{{ $summary['total_present'] }}</div>
            </td>
            <td>
                <div class="label">{{ $labels['total_emp'] }}</div>
                <div class="number" style="color: #0f172a;">{{ $summary['total_employees'] }}</div>
            </td>
        </tr>
    </table>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 11%;">{{ $labels['th_total'] }}</th>
                <th style="width: 9%;">{{ $labels['th_late'] }}</th>
                <th style="width: 9%;">{{ $labels['th_absent'] }}</th>
                <th style="width: 9%;">{{ $labels['th_present'] }}</th>
                <th style="width: 17%;">{{ $labels['th_job'] }}</th>
                <th style="width: 18%;">{{ $labels['th_dept'] }}</th>
                <th style="text-align: right; width: 22%;">{{ $labels['th_name'] }}</th>
                <th style="width: 5%;">#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reportData as $row)
                <tr>
                    <td><strong>{{ $row['total'] }}</strong></td>
                    <td class="text-warning">{{ $row['late'] }}</td>
                    <td class="text-danger">{{ $row['absent'] }}</td>
                    <td class="text-success">{{ $row['present'] }}</td>
                    <td>{{ $row['job_title'] }}</td>
                    <td>{{ $row['department_name'] }}</td>
                    <td class="employee-name">{{ $row['employee_name'] }}</td>
                    <td>{{ $loop->iteration }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 10px; color: #64748b;">
                        {{ $labels['no_data'] }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        {{ $labels['footer'] }}
    </div>

</body>
</html>
