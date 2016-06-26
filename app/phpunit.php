<?php
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once 'autoload.php';

$kernel = new AppKernel('test', true);
$kernel->loadClassCache();
$kernel->boot();

$createDatabaseCommand = new CreateDatabaseDoctrineCommand();
$createDatabaseCommand->setContainer($kernel->getContainer());
$createDatabaseCommand->run(
    new ArrayInput(
        [
            '--if-not-exists' => true,
        ]
    ),
    new ConsoleOutput()
);


/** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
$entityManager = $kernel->getContainer()->get('doctrine')->getManager();

$schemaTool = new SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();
$schemaTool->dropSchema($metadata);
$schemaTool->createSchema($metadata);
