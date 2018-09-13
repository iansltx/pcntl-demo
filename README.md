# (Ab)using Process Control for Powerful CLI Applications

This repo contains companion code for [the CascadiaPHP 2018 presentation with the above title](https://ian.im/pcntl18) by [@iansltx](https://twitter.com/iansltx], plus a Docker image including the necessary PHP extensions for the CLI examples from the presentation, as well as the [psysh](https://psysh.org/) REPL.

## Running Outside Docker

If you have the necessary extensions, some of which are now included in the `php-common` package that ships with e.g. Ubuntu 18.04, you can run all examples in this repo without Docker. You'll also need at least PHP 7.1. For a full list of required extensions, see the `apk add` line in this repo's Dockerfile. Note that Alpine Linux splits packages apart a bit more than a standard Linux distribution, so you'll probably end up installing fewer actual packages than are listed there. Remember to `composer install` to grab dependencies like Symfony Process!

As fair warning, a number of the functions in these examples are OS-dependent. For example,  pcntl_sigtimedwait() and pcntl_sigwaitinfo() don't exist on macOS/OS X.

## Using the Docker Container

After cloning the repo, you'll need to build the container:

```bash
docker build . -t pcntl
```

The build process copies any files in this directory into the container file system, and installs any dependencies mentioned in composer.json. To run a file with the PHP interpreter:

```bash
docker run --rm --name pcntl pcntl php sleepAndWrite.php
```

The above command names the container `pcntl` so you don't have to look its ID up later, for example when opening an interactive shell into the running container:

```bash
docker exec -it pcntl sh
```

or sending a signal to the container:

```bash
docker kill -s SIGCONT pcntl
```

The above command includes `--rm` to delete the container once it's done running, so the same name is available for subsequent runs.

When run with no parameters, the container will start the `psysh` REPL, though you'll need to tell Docker to attach your terminal to it to keep the REPL running:

```bash
docker run --rm -it pcntl
```

If you'd rather mount your local directory instead of needing to rebuild every time you change a file, [use the -v option in your docker run command](https://docs.docker.com/engine/reference/commandline/run/#mount-volume--v---read-only).