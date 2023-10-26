<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Modules\Core\ORM\Enums\TaskPriorityEnum;
use App\Modules\Core\ORM\Enums\TaskStatusEnum;
use Faker\Generator;
use Faker\Provider\ru_RU\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ruText = (new Text(new Generator()));

        $user = User::first();

        return [
            'user_id' => $user->getId(),
            'title' => $ruText->realText(100),
            'description' => $ruText->realText(500),
            'status' => TaskStatusEnum::TODO->value,
            'priority' => TaskPriorityEnum::PRIORITY_1->value
        ];
    }
}
