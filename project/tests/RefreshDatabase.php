<?php

namespace Tests;

use App\Support\FileSystemHelper;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase as RefreshDatabaseBase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

trait RefreshDatabase
{
    use RefreshDatabaseBase;

    /**
     * Define if test will make cache of database migrations.
     *
     * @var bool
     */
    protected $useDatabaseSchemaCache = true;

    /**
     * Refresh a conventional test database.
     *
     * @return void
     */
    protected function refreshTestDatabase()
    {
        if (!RefreshDatabaseState::$migrated && !$this->isDatabaseSchemaAlreadyMigrated()) {
            $this->artisan('migrate:fresh', [
                '--drop-views' => $this->shouldDropViews(),
                '--drop-types' => $this->shouldDropTypes(),
            ]);

            $this->app[Kernel::class]->setArtisan(null);

            $this->setDatabaseSchemaAsAlreadyMigrated();
            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    /**
     * Verify if local database is already migrated according migrations folder
     *
     * @return bool
     */
    private function isDatabaseSchemaAlreadyMigrated(): bool
    {
        if (!$this->useDatabaseSchemaCache) {
            return false;
        }

        $cache = app('cache')->driver('file');

        $migrationsFolderHash = $this->getMigrationsFolderHash();
        return ($cache->get('migrations-folder-last-hash') === $migrationsFolderHash);
    }

    /**
     * Define database as already migration according migrations folder
     *
     * @return void
     */
    private function setDatabaseSchemaAsAlreadyMigrated(): void
    {
        $cache = app('cache')->driver('file');

        $migrationsFolderHash = $this->getMigrationsFolderHash();
        $cache->put('migrations-folder-last-hash', $migrationsFolderHash);
    }

    /**
     * Generates a hash of database migrations folder.
     *
     * @return string
     */
    private function getMigrationsFolderHash()
    {
        static $migrationsFolderHash;

        if (!$migrationsFolderHash) {
            $migrationsFolder = base_path('/database/migrations');
            $migrationsFolderHash = FileSystemHelper::hashDirectory($migrationsFolder);
        }

        return $migrationsFolderHash;
    }
}
