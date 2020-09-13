<?php
/*
 * This file is part of the Depense.Net package.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Depense\Web\Controller\Root;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="root_page_")
 */
class PageController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("", name="home")
     */
    public function home(): Response
    {
        return $this->render('root/home/index.html.twig');
    }
}
