<?php

namespace server;

use Castor\Attribute\AsTask;

use function database\fixtures;
use function database\migrate;
use function docker\down;
use function docker\up;
use function symfony\start as sfStart;
use function symfony\stop as sfStop;

#[AsTask(
    description: 'Start the web server and all docker services. It can use as dev environment.',
    aliases: ['start'])]
function start(bool $quietly = false, bool $detach = false): void
{
    up($quietly);
    migrate($quietly);
    fixtures($quietly);
    sfStart($detach);
}

#[AsTask(description: 'Start the web server and all docker services', aliases: ['start:demo'])]
function startDemo(bool $quietly = false): void
{
    up($quietly);
    migrate($quietly);
    fixtures($quietly);
}

#[AsTask(description: 'Stop the web server and all docker services', aliases: ['stop'])]
function stop(bool $quietly = false, bool $purge = false): void
{
    down($purge, $quietly);
    sfStop();
}
