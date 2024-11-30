<?php

use Castor\Attribute\AsTask;

use function Castor\import;
use function Castor\io;

import(__DIR__ . '/.castor/server.php');
import(__DIR__ . '/.castor/symfony.php');
import(__DIR__ . '/.castor/database.php');
import(__DIR__ . '/.castor/docker.php');

#[AsTask(description: 'Getting Started to begin with commands', aliases: ['started'])]
function gettingStarted(): void {
    io()->title('Getting started for Job Board SF');
    io()->text('It\'s a project to learn Symfony 7 from by <https://formation.yoandev.co/view/courses/decouvrez-symfony-7-en-7-projets>YoanDev</>.');
    io()->text('To start this project, follow these steps.');

    io()->section('Server');
    io()->text('You can start the server with this command :');
    io()->newLine();
    io()->text('$ castor start');
    io()->newLine();
    io()->info('This command start the web server, up all services from docker compose, create tables and fill databases.');
    io()->note('If you have a existing database, you could drop the database with the "castor database:drop" command.');
    io()->newLine();
    io()->text('To stop the server, you can use this command :');
    io()->newLine();
    io()->text('$ castor stop');
    io()->newLine(2);

    io()->section('Help');
    io()->text('Run the following command to know other commands :');
    io()->newLine();
    io()->text('$ castor');
    io()->newLine();
}
