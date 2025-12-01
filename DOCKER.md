# Docker Setup for Advent of Code 2025

This project uses Docker to provide a consistent PHP environment for running Symfony commands.

## Container Details

- **Image**: PHP 8.2 CLI
- **Container name**: `adventofcode-php`
- **No port conflicts**: This container doesn't expose any ports and can run alongside other projects (like kaban)

## Quick Start

```bash
# Build the Docker image
make build

# Start the container
make up

# Install dependencies
make composer-install

# Access the container shell
make bash

# Run Symfony console commands
make console CMD="list"
make console CMD="cache:clear"

# Run tests
make test

# Stop the container
make down
```

## Available Make Commands

- `make up` - Start the container
- `make down` - Stop the container
- `make build` - Build the Docker image
- `make bash` - Access the container shell
- `make exec COMMAND="..."` - Execute any command in the container
- `make console CMD="..."` - Run Symfony console commands
- `make composer-install` - Install composer dependencies
- `make test` - Run PHPUnit tests
- `make help` - Show all available commands

## Examples

```bash
# Generate a new day
make console CMD="generate:day 01"

# Run a specific day solution
make exec COMMAND="php bin/console app:day01"

# Install a new package
make exec COMMAND="composer require vendor/package"

# Access PHP directly
make exec COMMAND="php --version"
```

## Manual Docker Commands

If you prefer not to use the Makefile:

```bash
# Start the container
docker compose up -d

# Execute commands
docker compose exec php php bin/console list

# Stop the container
docker compose down
```

## Compatibility with Other Projects

This container is designed to run alongside other Docker-based projects:
- Uses a unique container name: `adventofcode-php`
- No exposed ports
- Isolated network: `adventofcode2025_default`
- No conflicts with kaban or other projects

## Troubleshooting

### Container won't start
```bash
docker compose down
docker compose build --no-cache
docker compose up -d
```

### Permission issues
The container runs as the default PHP user. If you encounter permission issues with mounted volumes, check file ownership.

### Out of sync with code changes
The project directory is mounted as a volume, so code changes are immediately available. No rebuild needed for code changes.
