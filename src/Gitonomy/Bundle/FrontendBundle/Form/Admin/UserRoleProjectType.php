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
use Doctrine\ORM\EntityRepository;

class UserRoleProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if ('user' === $options['from']) {
            $projects     = $options['usedProjects'];
            $usedProjects = array();
            foreach ($projects as $project) {
                $usedProjects[] = $project->getId();
            }

            $builder->add('project', 'entity', array(
                'class'   => 'Gitonomy\Bundle\CoreBundle\Entity\Project',
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) use ($usedProjects) {
                    $query = $er
                        ->createQueryBuilder('P')
                        ->orderBy('P.name', 'ASC');
                    if (count($usedProjects) > 0) {
                        $query
                            ->where('P.id NOT IN (:projectIds)')
                            ->setParameter('projectIds', $usedProjects);
                    }

                    return $query;
                },
            ));
        }

        if ('project' === $options['from']) {
            $users     = $options['usedUsers'];
            $usedUsers = array();
            foreach ($users as $user) {
                $usedUsers[] = $user->getId();
            }

            $builder->add('user', 'entity', array(
                'class'   => 'Gitonomy\Bundle\CoreBundle\Entity\User',
                'property' => 'fullname',
                'query_builder' => function(EntityRepository $er) use ($usedUsers) {
                    $query = $er
                        ->createQueryBuilder('U')
                        ->orderBy('U.fullname', 'ASC');
                    if (count($usedUsers) > 0) {
                        $query
                            ->where('U.id NOT IN (:userIds)')
                            ->setParameter('userIds', $usedUsers);
                    }

                    return $query;
                },
            ));
        }

        $builder
            ->add('role', 'entity', array(
                'class'   => 'Gitonomy\Bundle\CoreBundle\Entity\Role',
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    $query = $er
                        ->createQueryBuilder('R')
                        ->where('R.isGlobal = false')
                        ->orderBy('R.name', 'ASC');

                    return $query;
                },
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'   => 'Gitonomy\Bundle\CoreBundle\Entity\UserRoleProject',
            'usedProjects' => array(),
            'usedUsers'    => array(),
            'from'         => null,
        ));
    }

    public function getParent()
    {
        return 'baseadmin';
    }

    public function getName()
    {
        return 'adminuserroleproject';
    }
}
