<div align="center">
  
# Boilerplate Laravel 11

</div>

<div align="center">
  <img src="docs/lets-laravel.png" alt="Lets + Laravel" width="600"/>
</div>  

Esta é a base de projetos Laravel utilizada na Lets.

## Features do projeto
* Aplicação Laravel 11 (API).
* Docker e docker compose configurados com principais imagens utilizadas em um ambiente de desenvolvimento.
* Testes de unidade e de integração.
* Documentação via Insomnia.
* Permissionamento dinâmico.
* Estruturação organizado por domínios.

## Utilizando o projeto pelo docker

Em primeiro lugar é necessário ter o docker e o docker-compose instalados em sua máquina, para isso segue o tutorial:

* [Tutorial de instalação do docker e docker compose]([https://docs.docker.com/install/linux/docker-ce/ubuntu/](https://docs.docker.com/engine/install/ubuntu/))

Para iniciar o projeto pela **primeira vez**, basta rodar os comandos abaixo:

```bash
$> ./laravel-docker start
$> ./bin/setup.sh
```

Uma vez configurado, você não precisará mais rodar o script `setup.sh`.
Em vez disso, você precisará se preocupar apenas em subir e derrubar o ambiente:

#### Subir o ambiente
```
$> ./laravel-docker start
```

#### Derrubar o ambiente
```
$> ./laravel-docker stop
```

#### Limpar o ambiente
Este comando irá derrubar o ambiente, limpar os container órfãos e derrubar a rede interna do ambiente de desenvolvimento.
```
$> ./laravel-docker clean
```

## Comandos relevantes
Esses comandos devem ser rodados no contexto da aplicação Laravel. Para utilizá-los juntamente ao Docker, rode o seguinte comando para acessar o terminal da aplicação:
```
$> docker compose exec app bash
```

#### Atualizar aplicação
```
$> php artisan upgrade --dev
```

#### Rodar testes
```
$> php artisan test
```

#### Formatar a estilização
```
$> composer run lint
```
