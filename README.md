# README #

Esta é a base de projetos Laravel utilizada na Lets.

## Utilizando o projeto pelo docker

Em primeiro lugar é necessário ter o docker e o docker-compose instalados em sua máquina, para isso segue o tutorial:

* [Tutorial de instalação do docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)
* [Tutorial de instalação do docker-compose](https://docs.docker.com/compose/install/)

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

Para mais informações sobre o laravel-docker, acesse a [página de documentação do laravel-docker](https://github.com/danilopinotti/laravel-docker-environment)

## Instalar o projeto diretamente na máquina ##
Para aprender a configurar o projeto ná própria máquina, leia o documento [Setup Baremetal](docs/setup-baremetal.md)

## LICENÇA
Licença MIT (MIT). Por favor, leia o [Arquivo de Licença](LICENSE) para mais informações.
