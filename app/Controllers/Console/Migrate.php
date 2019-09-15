<?php

namespace App\Controllers\Console;

use App\Controllers\BaseController;

class Migrate extends BaseController
{
    /**
     * Run database to latest version,
     * alternative from built-in command line migration.
     */
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Revert migration, total batch 0 mean all of it
     */
    public function rollback($totalBatch = 0)
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->regress($totalBatch);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Initialize new database
     */
    public function init()
    {
        $forge = \Config\Database::forge();
        if ($forge->createDatabase(env('database.default.database'))) {
            echo 'Database created!';
        } else {
            echo 'Database creation failed';
        }
    }

    /**
     * Destroy database from env settings.
     */
    public function destroy()
    {
        $forge = \Config\Database::forge();
        if ($forge->dropDatabase(env('database.default.database'))) {
            echo 'Database deleted!';
        }
    }
}
