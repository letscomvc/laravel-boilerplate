<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Upgrade extends Command
{
    /**
     * @var bool
     */
    protected $routeCacheEnabled = true;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->showCommandHeader();

        $shouldConfirm = !($this->option('dev'));
        $confirmMessage = 'Tem certeza que deseja atualizar a aplicação?';
        if ($shouldConfirm && !$this->confirm($confirmMessage)) {
            $this->error('Cancelado.');
            return;
        }

        $this->executeCommands();
        $this->info('Pronto!');
    }

    private function showCommandHeader()
    {
        $this->info('Atualização da aplicação.');
        $this->line('Este comando fará as seguintes ações:');
        $this->line(' - Executar as migrações');
        $this->line(' - Executar seeder de atualização');
        $this->line(' - Criar cache das configurações (utilizar --dev para somente apagar o cache existente)');
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
        $migrationMessages = [
            'success' => 'Migrações concluidas.',
            'failed' => 'Erro ao rodar migrações'
        ];
        $this->executeWithMessages('migrate', ['--force' => true], $migrationMessages);
    }

    private function executeUpgradeSeeder()
    {
        $seedMessages = [
            'success' => 'Seeds concluidas.',
            'failed' => 'Erro ao rodar seed de atualização.'
        ];
        $this->executeWithMessages(
            'db:seed',
            ['--class' => 'UpgradeSeeder', '--force' => true],
            $seedMessages
        );
    }

    private function executeMakeCaches()
    {
        $this->cacheViews();
        $this->cacheConfig();
        $this->cacheEvents();

        ($this->routeCacheEnabled)
            ? $this->cacheRoutes()
            : $this->clearRoutesCache();
    }

    private function executeClearCaches()
    {
        $this->clearApplicationCache();
        $this->clearRoutesCache();
        $this->clearConfigurationsCache();
        $this->clearViewsCache();
    }

    private function cacheRoutes()
    {
        $cacheRoutesMessages = ['success' => 'Criado cache das rotas.'];
        $this->executeWithMessages('route:cache', [], $cacheRoutesMessages);
    }

    private function cacheConfig()
    {
        $cacheConfigsMessages = ['success' => 'Criado cache das configurações.'];
        $this->executeWithMessages('config:cache', [], $cacheConfigsMessages);
    }

    private function cacheEvents()
    {
        $cacheEventsMessages = ['success' => 'Criado cache dos eventos.'];
        $this->executeWithMessages('event:cache', [], $cacheEventsMessages);
    }

    private function cacheViews()
    {
        $cacheViewsMessages = ['success' => 'Criado cache das views.'];
        $this->executeWithMessages('view:cache', [], $cacheViewsMessages);
    }

    private function clearRoutesCache()
    {
        $clearCacheRouteMessages = ['success' => 'Cache das rotas foi apagado.'];
        $this->executeWithMessages('route:clear', [], $clearCacheRouteMessages);
    }

    private function clearConfigurationsCache()
    {
        $clearCacheConfigurationMessages = ['success' => 'Cache das configurações foi apagado.'];
        $this->executeWithMessages('config:clear', [], $clearCacheConfigurationMessages);
    }

    private function clearViewsCache()
    {
        $clearCacheViewMessages = ['success' => 'Cache das views foi apagado.'];
        $this->executeWithMessages('view:clear', [], $clearCacheViewMessages);
    }

    private function clearApplicationCache()
    {
        $clearCacheMessages = ['success' => 'Cache da aplicação foi apagado.'];
        $this->executeWithMessages('cache:clear', [], $clearCacheMessages);
    }

    private function executeWithMessages($commandName, $commandOptions, $outputMessages = [])
    {
        try {
            $this->callSilent($commandName, $commandOptions);
            $message = data_get(
                $outputMessages,
                'success',
                "Comando [$commandName] executado com sucesso"
            );
            $this->info($message);
        } catch (\Exception $exception) {
            $message = data_get(
                $outputMessages,
                'failed',
                "Falha ao executar o comando [$commandName]"
            );

            $this->error("{$message} - {$exception->getMessage()}");
        }
    }
}