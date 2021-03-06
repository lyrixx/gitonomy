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

namespace Gitonomy\Bundle\FrontendBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifyLocaleListener
{
    protected $allowedLocales;

    public function __construct($allowedLocales)
    {
        $this->allowedLocales = $allowedLocales;
    }

    public function onKernelRequest(GetResponseEvent $e)
    {
        if ($e->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $e->getRequest();
        $locale  = $request->attributes->get('_locale');

        if (null === $locale) {
            return;
        }

        if (true === in_array($locale, $this->allowedLocales, true)) {
            return;
        }

        $e->stopPropagation();
        throw new NotFoundHttpException(sprintf('Locale "%s" not available', $locale));
    }
}
