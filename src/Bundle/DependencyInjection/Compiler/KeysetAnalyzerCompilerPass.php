<?php

declare(strict_types=1);

namespace Jose\Bundle\JoseFramework\DependencyInjection\Compiler;

use Jose\Component\KeyManagement\Analyzer\KeysetAnalyzerManager;
use Override;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final readonly class KeysetAnalyzerCompilerPass implements CompilerPassInterface
{
    #[Override]
    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition(KeysetAnalyzerManager::class)) {
            return;
        }

        $definition = $container->getDefinition(KeysetAnalyzerManager::class);

        $taggedServices = $container->findTaggedServiceIds('jose.keyset_analyzer');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
