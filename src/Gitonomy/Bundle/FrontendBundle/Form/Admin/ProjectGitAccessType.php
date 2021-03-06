<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Bundle\FrontendBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectGitAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('role', 'entity', array(
            'class' => 'Gitonomy\Bundle\CoreBundle\Entity\Role',
            'property' => 'name'
        ));
        $builder->add('reference', 'text');
        $builder->add('read',  'checkbox');
        $builder->add('write', 'checkbox');
        $builder->add('admin', 'checkbox');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gitonomy\Bundle\CoreBundle\Entity\ProjectGitAccess',
        ));
    }

    public function getName()
    {
        return 'project_git_access';
    }
}
