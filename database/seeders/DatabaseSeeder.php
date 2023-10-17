<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ]);

        \App\Models\Category::factory()->create([
            'field_group_id' => '1',
            'name' => 'Computer',
        ]);

        \App\Models\Category::factory()->create([
            'field_group_id' => '2',
            'name' => 'Vehicle',
        ]);

        \App\Models\FieldGroup::factory()->create([
            'name' => 'fields for computer',
        ]);
        \App\Models\FieldGroup::factory()->create([
            'name' => 'fields for vehicle',
        ]);

        \App\Models\Field::factory()->create([
            'field_groups_id' => '1',
            'label' => 'Ram',
            'is_required' => 'required',
        ]);
        \App\Models\Field::factory()->create([
            'field_groups_id' => '2',
            'label' => 'plate number',
            'is_required' => 'required',
        ]);
        // \App\Models\ParentModel::factory()->create([
        //     'category_id' => '1',
        //     'name' => 'Laptop',
        // ]);
        // \App\Models\ParentModel::factory()->create([
        //     'category_id' => '1',
        //     'name' => 'Desktop',
        // ]);
        // \App\Models\ParentModel::factory()->create([
        //     'category_id' => '2',
        //     'name' => 'Sedan',
        // ]);
        // \App\Models\ParentModel::factory()->create([
        //     'category_id' => '2',
        //     'name' => 'Suv',
        // ]);
        \App\Models\Employee::factory()->create([
            'first_name' => 'Juan',
            'last_name' => 'De La Cruz',
            'position' => 'position 1',
        ]);

        \App\Models\Employee::factory()->create([
            'first_name' => 'Jimmy',
            'last_name' => 'Neutron',
            'position' => 'position 2',
        ]);
    }
}
