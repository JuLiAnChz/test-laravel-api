<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoStatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('todo_status')->insert([
      ['id' => 'PENDING', 'title' => 'PENDIENTE'],
      ['id' => 'FINISHED', 'title' => 'FINALIZADO'],
      ['id' => 'DELETED', 'title' => 'ELIMINADO'],
    ]);
  }
}
