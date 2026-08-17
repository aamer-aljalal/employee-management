<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        
        if ($employees->isEmpty()) {
            return;
        }

        $startDate = now()->subMonths(4);
        $endDate = now();
        $attendances = [];
        $batchSize = 500;

        // Loop through each day from start date to end date
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            
            // Skip weekends (Friday and Saturday)
            if ($date->isFriday() || $date->isSaturday()) {
                continue;
            }

            foreach ($employees as $employee) {
                // Random status generator: 80% present, 15% late, 5% absent
                $rand = rand(1, 100);
                if ($rand <= 80) {
                    $status = 'present';
                } elseif ($rand <= 95) {
                    $status = 'late';
                } else {
                    $status = 'absent';
                }

                $attendances[] = [
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                    'status' => $status,
                    'notes' => $status === 'absent' ? 'لم يحضر للعمل' : ($status === 'late' ? 'تأخير بسبب زحمة السير' : null),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($attendances) >= $batchSize) {
                   Attendance::insertOrIgnore($attendances);
                    $attendances = [];
                }
            }
        }

        // Insert remaining records
        if (count($attendances) > 0) {
           Attendance::insertOrIgnore($attendances);
        }
    }
}
