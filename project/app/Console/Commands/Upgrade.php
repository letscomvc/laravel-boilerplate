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
                                {--no-cache : Não realiza caches da aplicação}
                                {--dev : Alias para --no-cache}
                                {--yes : Auto confirmar execução do comando}';

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

    private function showCommandHeader()
    {
        $this->info('Atualizar aplicação');
        $this->line('Este comando fará as seguintes ações:');
        $this->line(' - Realizar migrações;');
        $this->line(' - Executar Seeder de atualização;');
        $this->line(' - Criar cache das rotas (utilizar --dev para ignorar esta etapa);');
        $this->line(' - Criar cache das configurações (utilizar --dev para ignorar esta etapa);');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->showCommandHeader();

        if ($this->option('yes') || $this->option('dev')) {
            $this->executeCommands();
            $this->info('Pronto!');
            return;
        }

        $agree = $this->confirm('Tem certeza que deseja atualizar a aplicação ?');

        if ($agree) {
            $this->executeCommands();
            $this->info('Pronto!');
        } else {
            $this->error('Cancelado.');
        }
    }

    private function executeCommands()
    {
        if ($this->option('no-cache') || $this->option('dev')) {
            $this->executeNoCache();
        } else {
            $this->executeCache();
        }

        $this->executeMigrate();
        $this->executeUpgradeSeeder();

        $this->executeOptimization();
    }

    private function executeMigrate()
    {
        $migrationMessages = [
            'success' => 'Migrações concluidas.',
            'failed' => 'Erro ao rodar migrações'
        ];
        $this->executeWithMessages('migrate', [], $migrationMessages);
    }

    private function executeUpgradeSeeder()
    {
        $seedMessages = [
            'success'=> 'Seeds concluidas.',
            'failed' => 'Erro ao rodar Seed de atualização.'
        ];
        $this->executeWithMessages('db:seed', ['--class' => 'UpgradeSeeder'], $seedMessages);
    }

    private function executeCache()
    {
        $this->executeCacheRoutes();
        $this->executeCacheMessages();
    }

    private function executeCacheRoutes()
    {
        $cacheConfigurationsMessages = [
            'success'=> 'Cache das configurações foi criado.',
            'failed' => 'Erro ao criar cache das configurações.'
        ];
        $this->executeWithMessages('config:cache', [], $cacheConfigurationsMessages);
    }

    private function executeCacheMessages()
    {
        $cacheRouteMessages = [
            'success'=> 'Cache das rotas foi criado.',
            'failed' => 'Erro ao criar cache das rotas.'
        ];
        $this->executeWithMessages('route:cache', [], $cacheRouteMessages);
    }

    private function executeNoCache()
    {
        $this->executeClearCache();
        $this->executeClearViews();
        $this->executeClearRoutes();
        $this->executeClearConfigurations();
    }

    private function executeClearViews()
    {
        $clearCacheRouteMessages = ['success' => 'Cache das rotas foi apagado.'];
        $this->executeWithMessages('route:clear', [], $clearCacheRouteMessages);
    }

    private function executeClearRoutes()
    {
        $clearCacheConfigurationMessages = ['success' => 'Cache das configurações foi apagado.'];
        $this->executeWithMessages('config:clear', [], $clearCacheConfigurationMessages);
    }

    private function executeClearConfigurations()
    {
        $clearCacheViewMessages = ['success' => 'Cache das views foi apagado.'];
        $this->executeWithMessages('view:clear', [], $clearCacheViewMessages);
    }

    private function executeClearCache()
    {
        $clearCacheMessages = ['success' => 'Cache da aplicação foi apagado.'];
        $this->executeWithMessages('cache:clear', [], $clearCacheMessages);
    }

    private function executeOptimization()
    {
        $optimizeMessages = [
            'success'=> 'Framework otimizado.',
            'failed' => 'Erro ao otimizar framework.'
        ];
        $this->executeWithMessages('optimize', [], $optimizeMessages);
    }

    private function executeWithMessages($call, $options, $messages = [])
    {
        try {
            $this->callSilent($call, $options);

            if (isset($messages['success'])) {
                $this->info($messages['success']);
            }
        } catch (\Exception $e) {
            if (isset($messages['failed'])) {
                $this->error($messages['failed']);
            }
        }
    }
}
