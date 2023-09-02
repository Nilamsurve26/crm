<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Role::truncate();
    Role::create(['name' => 'SUPER ADMIN']);
    Role::create(['name' => 'ADMIN']);
    Role::create(['name' => 'MIM']);
    Role::create(['name' => 'TECHNICIAN']);
    Role::create(['name' => 'CUSTOMER']);
   
  }
}
