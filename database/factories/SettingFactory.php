<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'header_logo' => 'Hogo Company',
            'footer_logo' => 'Hogo Company',
            'footer_desc' => $this->faker->paragraph(),
            'email' => $this->faker->email(),
            'phone' => '672515052',
            'address' => 'Camp Yabassi face station MRS',
            'facebook' => 'facebook',
            'instagram' => 'instagram',
            'linkedin' => 'linkedin',
            'about_title' => $this->faker->sentence(),
            'about_desc' => $this->faker->paragraph(),
        ];
    }
}
