<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitles = [
            'مطور برمجيات', 'محاسب', 'مهندس شبكات', 'مدير مشروع', 
            'مصمم جرافيك', 'أخصائي تسويق', 'ممثل خدمة عملاء', 'محلل بيانات',
            'مدير مبيعات', 'موظف استقبال', 'مدير موارد بشرية', 'باحث قانوني'
        ];

        return [
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory(),
            'name' => $this->faker->name('ar_SA'),
            'phone' => '05' . $this->faker->numerify('########'),
            'job_title' => $this->faker->randomElement($jobTitles),
            'salary' => $this->faker->randomFloat(2, 4000, 20000),
            'hire_date' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'is_active' => $this->faker->boolean(90), // 90% active
        ];
    }
}
