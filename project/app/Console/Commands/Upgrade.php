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
    protected $signature = 'upgrade {--no-cache : Não realiza caches da aplicação}';

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
        $this->line(' - Criar cache das rotas (utilizar --no-cache para ignorar esta etapa);');
        $this->line(' - Criar cache das configurações (utilizar --no-cache para ignorar esta etapa);');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->showCommandHeader();

        $agree = $this->confirm('Tem certeza que deseja atualizar a aplicação ?');

        if ($agree) {
            $migrationMessages = ['success'=>'Migrações concluidas.', 'failed' => 'Erro ao rodar migrações'];
            $this->executeWithMessages('migrate', [], $migrationMessages);

            $seedMessages = ['success'=> 'Seeds concluidas.', 'failed' => 'Erro ao rodar Seed de atualização.'];
            $this->executeWithMessages('db:seed', ['--class' => 'UpgradeSeeder'], $seedMessages);

            if (! $this->option('no-cache')){
                $cacheRouteMessages = ['success'=> 'Cache das rotas foi criado.', 'failed' => 'Erro ao criar cache das rotas.'];
                $this->executeWithMessages('route:cache', [], $cacheRouteMessages);

                $cacheConfigurationsMessages = ['success'=> 'Cache das configurações foi criado.', 'failed' => 'Erro ao criar cache das configurações.'];
                $this->executeWithMessages('config:cache', [], $cacheConfigurationsMessages);

            } else {
                $clearCacheRouteMessages = ['success'=> 'Cache das rotas foi apagado.'];
                $this->executeWithMessages('route:clear', [], $clearCacheRouteMessages);

                $clearCacheConfigurationMessages = ['success'=> 'Cache das configurações foi apagado.'];
                $this->executeWithMessages('config:clear', [], $clearCacheConfigurationMessages);

                $clearCacheViewMessages = ['success'=> 'Cache das views foi apagado.'];
                $this->executeWithMessages('view:clear', [], $clearCacheViewMessages);
            }

            $optimizeMessages = ['success'=> 'Framework otimizado.', 'failed' => 'Erro ao otimizar framework.'];
            $this->executeWithMessages('optimize', [], $optimizeMessages);

            $this->info('Pronto!');
        } else {
            $this->error('Cancelado.');
        }
    }

    private function executeWithMessages($call, $options, $messages = [])
    {
        try {
            $this->callSilent($call, $options);
            if (isset($messages['success']))
                $this->info($messages['success']);
        } catch(\Exception $e) {
            if (isset($messages['failed']))
                $this->error($messages['failed']);
        }
    }
}
