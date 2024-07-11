# Simple User Counter

A simple user data processing implementation using data transfer object as a communication contract, action as business logic layer, and repository as data infrastructure layer.

## Tech Stack

**Client:** Laravel Livewire, Laravel Filament, TailwindCSS

**Server:** Docker, Laravel 11 (PHP 8.3), Swoole, Laravel Octane, Laravel Horizon, Laravel Livewire, Laravel Filament, PM2

**Database:** Postgresql 16, Redis 7.2

## Installation

This application use docker container as development environment.
The fastest way to setup is to use docker

First install docker in your device

https://docs.docker.com/engine/install/

and install gnu make command on your os

Copy `.env.example` to `.env`
and then run

```bash
  make build
```

to build docker image for this project

then run

```bash
    make setup
```

to setup dependencies for project

then run

```bash
    make up
```

And you're good to go, you can access the application in `http://localhost` using default `.env` setup
