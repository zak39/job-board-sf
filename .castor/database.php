<?php

namespace database;

use Castor\Attribute\AsTask;

use function Castor\context;
use function Castor\io;
use function Castor\run;

#[AsTask(description: 'Create database tables', aliases: ['db:m:m'])]
function migrate(bool $quietly = false) {
    $dbMigrated = run('symfony console doctrine:migrations:migrate -n', context: context()->withQuiet($quietly));

    if (!$dbMigrated->isSuccessful()) {
        io()->error('Impossible to migrate the database');
        return;
    }

    io()->success('The database tables is ready');
}

#[AsTask(description: 'Load faker data', aliases: ['db:f'])]
function fixtures(bool $quietly = false) {
    $fixturesLoaded = run('symfony console doctrine:fixtures:load -n', context: context()->withQuiet($quietly));

    if (!$fixturesLoaded->isSuccessful()) {
        io()->error('Impossible to apply fixtures');
        return;
    }
}

#[AsTask(description: 'Drop the database with force', aliases: ['db:drop'])]
function drop(): void
{
    $result = run('symfony console doctrine:database:drop --force');

    if($result->isSuccessful()) {
        io()->success('The database is dropped');
        return;
    }

    io()->error('Impossible to drop the database');
}

#[AsTask(description: 'Reset the database', aliases: ['db:r'])]
function reset(bool $quietly = false): void
{ 
    fixtures($quietly);
    io()->success('The database is reset');
}
