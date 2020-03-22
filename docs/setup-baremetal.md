# Configuração do projeto sem o Docker

### Comandos para configuração ###

`$ composer install`

`$ npm install`

`$ php artisan key:generate`

`$ php artisan migrate --seed`

`$ php artisan upgrade --dev`

`$ npm run dev`

### Real Time ###
Para as aplicações real-time dentro do sistema foram utilizadas as seguintes tecnologias:
 - Socket.io (Cliente front-end para Real time)
 - Redis (Publish Subscribe e Cache)
 - Laravel Echo Server (Servidor Real-Time)

Para funcionar é necessário, primeiramente, instalar o Redis e configurar o env para utilizá-lo como driver de broadcast.
Para isso, execute o seguinte comando:

`# apt-get install redis-server`

E adicione a seguinte linha no arquivo .env:

`BROADCAST_DRIVER=redis`

Após isso, execute o seguinte comando para a configuração do servidor RT:

`$ laravel-echo-server init`

Ao executar o comando acima, você deverá escoher as opções que se enquadram nas configurações de sua máquina e selecionar o Redis como banco de dados.
Após a configuração, você deverá abrir o arquivo gerado `laravel-echo-server.json` e alterar os seguintes trechos:

```json
"authHost": "http://endereco"`
```

```json
"database": "redis",
"databaseConfig": {
  "redis" : {
     "port": "6379",
     "host": "localhost",
       "options": {
           "db":  1
        }
   },
  "sqlite": {}
},
```

Após a configuração, basta iniciar o servidor sempre que precisar do recurso de real time:

``$ laravel-echo-server start``


## Laravel Echo Server - PROD ##

O arquivo resources/assets/js/broadcast.js deve ficar:

```
import Echo from 'laravel-echo';

window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: { path: '/socket.io' },
});
```

O arquivo laravel-echo-server.json deve ficar:

```
{
	"authHost": "https://plataforma.saly.com.br",
	"authEndpoint": "/broadcasting/auth",
	"clients": [
		{
			"appId": "4d99a0e7f8ff7afa",
			"key": "707bdbba4987a3189292e3837a6ba36e"
		}
	],
	"database": "redis",
	"databaseConfig": {
		"redis": {
			"host": "app-cache.bssp3p.ng.0001.use1.cache.amazonaws.com",
			"port": 6379,
			"db": 0
		},
		"sqlite": {
			"databasePath": "/database/laravel-echo-server.sqlite"
		}
	},
	"devMode": true,
	"host": null,
	"port": "6001",
	"protocol": "http",
	"socketio": {},
	"sslCertPath": "",
	"sslKeyPath": "",
	"sslCertChainPath": "",
	"sslPassphrase": "",
	"subscribers": {
		"http": true,
		"redis": true
	},
	"apiOriginAllow": {
		"allowCors": false,
		"allowOrigin": "",
		"allowMethods": "",
		"allowHeaders": ""
	}
}
```

Deve-se adicionar a configuração do NGINX

```
location /socket.io {
	proxy_pass http://127.0.0.1:6001;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
}
```

### Supervisor ###

Neste projeto foi utilizado o supervisor, um sistema que permite monitorar e controlar processos relacionados a um projeto ou a um cliente. Tem o supervisor server (supervisord), e o supervisor client (supervisorctl). Foi utilizado para delegar o processo de envio de emails para um fila de modo assíncrono.

Instalar o supervisor:

`sudo apt-get install supervisor`

Verifique se foi criado o arquivo /etc/supervisor/supervisord.conf

Se não tiver, terá que criar o arquivo digitando:

`$ sudo echo_supervisord_conf > /etc/supervisord.conf`

Crie uma seção de programa na configuração (essa seção define o programa que será gerenciado e executado quando o comando de supervisão é chamado).

Na pasta /etc/supervisor/conf.d, crie um arquivo app-queue-work.conf, e adicione um programa:

```
[program:app-queue-work]

process_name=%(program_name)s_%(process_num)02d
command=php /home/letsgrow/Development/app/project/artisan queue:work database --daemon
autostart=true
autorestart=true
user=letsgrow
numprocs=1
redirect_stderr=true
stdout_logfile=/home/letsgrow/Development/app/project/storage/logs/worker.log

```

Crie o arquivo de log do worker, na pasta de logs do SEU PROJETO, dentro da storage:

`$ sudo nano /home/letsgrow/Development/app/project/storage/logs/worker.log`

Inicie o supervisord (server):

`$ sudo supervisord -c /etc/supervisor/supervisord.conf`

Inicie o supervisorctl (cliente):

`$ sudo supervisorctl start all`

Isso será o necessário para utilizar o supervisor.

Para reiniciar o supervisor:

`$ sudo supervisorctl reload`

Para ver o status supervisor:

`$ sudo supervisorctl status`

Para parar todos os jobs do supervisor:

`$ sudo supervisorctl stop all`
