<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            'الموارد البشرية', 'تقنية المعلومات', 'المالية', 'المبيعات', 
            'التسويق', 'خدمة العملاء', 'الشؤون القانونية', 'البحث والتطوير', 
            'المشتريات', 'العلاقات العامة', 'التخطيط الاستراتيجي', 'التدريب والتطوير'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($departments),
            'description' => $this->faker->realText(50),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
