<?php

namespace Pitchart\Wssc\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\YamlFileLoader as TranslationFileLoader;

class CheckerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('wssc.checker_chain')) {
            return;
        }

        $definition = $container->findDefinition(
            'wssc.checker_chain'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'wssc.checker.curl'
        );
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addCurlCheck',
                    array(new Reference($id), $attributes['type'], $attributes['alias'])
                );
            }
        }

        // Building translator
        $translator = new Translator($container->getParameter('locale'), new MessageSelector());
        $translator->addLoader('yaml', new TranslationFileLoader());
        $translator->addResource('yaml', __DIR__ . '/../Resources/translations/messages.fr.yml', 'fr_FR');

        // Adding the translator to the service container
        $translatorDefinition = new Definition();
        $translatorDefinition->setSynthetic(true);
        $container->setDefinition('translator', $translatorDefinition);
        $container->set('translator', $translator);

    }
}
