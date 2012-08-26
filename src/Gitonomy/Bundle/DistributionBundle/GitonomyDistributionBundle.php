<?php

namespace Gitonomy\Bundle\DistributionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Gitonomy\Bundle\DistributionBundle\DependencyInjection\CompilerPass\AddStepToListPass;

class GitonomyDistributionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddStepToListPass());
    }
}
