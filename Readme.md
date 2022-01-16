### Overview
cat-life

### IDE-helper

```bash
sail artisan ide-helper:model
```

### build docker

```shell
# app
$ docker image build -f infra/docker/8.1/php/Dockerfile -t catlife-app .

# nginx
$ docker image build -f infra/docker/8.1/nginx/Dockerfile -t catlife-web .
```

### For development
```bash
$ export WWWUSER=`id -g`; docker-compose up -d
```

