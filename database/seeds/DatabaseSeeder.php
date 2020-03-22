<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * The tables that should be seeded.
     *
     * @var array
     */
    protected $tables = [
        'business_days', 'appointments'
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();

        // $this->call(UsersTableSeeder::class);
        $this->call(BusinessDaysTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);
    }

    /**
     * Truncate the tables.
     */
    protected function cleanDatabase()
    {
        $this->setFKCheckOff();

        foreach ($this->tables as $table)
        {
            DB::table($table)->truncate();
        }

        $this->setFKCheckOn();
    }

    /**
     * Set foreign key check off depending on database.
     */
    private function setFKCheckOff() {
        switch(DB::getDriverName()) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = OFF');
                break;
        }
    }

    /**
     * Set foreign key check on depending on database.
     */
    private function setFKCheckOn() {
        switch(DB::getDriverName()) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = ON');
                break;
        }
    }
}
