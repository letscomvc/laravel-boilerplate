<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Upgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade
                                {--dev : Executa o procedimento para ambiente de desenvolvimento}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualizar aplicação';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->showCommandHeader();

        $shouldConfirm = ! ($this->option('dev'));
        $confirmMessage = 'Tem certeza que deseja atualizar a aplicação?';
        if ($shouldConfirm && ! $this->components->confirm($confirmMessage)) {
            $this->components->error('Cancelado');

            return;
        }

        $this->executeCommands();
        $this->newLine();
        $this->components->info('Pronto!');
    }

    private function showCommandHeader()
    {
        $this->components->info('Atualização da aplicação. Este comando fará as seguintes ações:');
        $this->components->bulletList([
            'Executar as migrações',
            'Executar seeder de atualização',
            'Criar/limpar caches (eventos, rotas, configurações, views, etc.)',
        ]);

        if (! $this->option('dev')) {
            $this->newLine();
            $this->components->warn(' Se você estiver em ambiente de desenvolvimento, utilize --dev');
        }
    }

    private function executeCommands()
    {
        ($this->option('dev'))
            ? $this->executeClearCaches()
            : $this->executeMakeCaches();

        $this->executeMigrate();
        $this->executeUpgradeSeeder();
    }

    private function executeMigrate()
    {
        $this->components->task(
            'Migrating Database',
            fn () => $this->callSilent('migrate', ['--force' => true]) == 0
        );
    }

    private function executeUpgradeSeeder()
    {
        $this->components->task(
            'Run Upgrade Seeder',
            fn () => $this->callSilent('db:seed', ['--class' => 'UpgradeSeeder', '--force' => true]) == 0
        );
    }

    private function executeMakeCaches()
    {
        collect([
            'Caching Events' => fn () => $this->callSilent('event:cache') == 0,
            'Caching Views' => fn () => $this->callSilent('view:cache') == 0,
            'Caching Configs' => fn () => $this->callSilent('config:cache') == 0,
            'Caching Routes' => fn () => $this->callSilent('route:cache') == 0,
        ])->each(fn ($task, $description) => $this->components->task($description, $task));
    }

    private function executeClearCaches()
    {
        $this->newLine();

        collect([
            'Cleaning Event Cache' => fn () => $this->callSilent('event:clear') == 0,
            'Cleaning View Cache' => fn () => $this->callSilent('view:clear') == 0,
            'Cleaning Application Cache' => fn () => $this->callSilent('cache:clear') == 0,
            'Cleaning Route Cache' => fn () => $this->callSilent('route:clear') == 0,
            'Cleaning Config Cache' => fn () => $this->callSilent('config:clear') == 0,
            'Cleaning Compiled' => fn () => $this->callSilent('clear-compiled') == 0,
        ])->each(fn ($task, $description) => $this->components->task($description, $task));
    }
}
