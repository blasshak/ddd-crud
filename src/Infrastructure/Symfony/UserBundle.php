<?php

namespace Infrastructure\Symfony;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass($this->buildMappingCompilerPass());
    }

    public function buildMappingCompilerPass()
    {
        $entityDir = realpath(__DIR__.'/../Persistence/Doctrine/ORM/Mapping/Entity');
        $entityMappings = 'Domain\Model\Entity';

        $valueObjectDir = realpath(__DIR__.'/../Persistence/Doctrine/ORM/Mapping/ValueObject');
        $valueObjectMappings = 'Domain\Model\ValueObject';

        return DoctrineOrmMappingsPass::createYamlMappingDriver(
            [$entityDir => $entityMappings, $valueObjectDir => $valueObjectMappings],
            [],
            false,
            ['Model' => 'Domain\Model\Entity']
        );
    }
}
