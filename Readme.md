### Overview
cat-life

### IDE-helper

```bash
$ cd src
$ make ide-helper
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
# up
$ cd src
$ make up

# exec bash
$ cd src
$ make bash
```

### openapi
```bash
$ cd src
$ make generate-openapi
```
