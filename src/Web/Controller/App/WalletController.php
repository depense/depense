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

namespace Depense\Web\Controller\App;

use Depense\Module\User\Action\AssignActiveWallet;
use Depense\Module\Wallet\Action\CreateWallet;
use Depense\Module\Wallet\Action\UpdateWallet;
use Depense\Module\Wallet\Factory\WalletFactory;
use Depense\Module\Wallet\Model\Wallet;
use Depense\Web\Controller\AbstractController;
use Depense\Web\Form\WalletType;
use Depense\Web\Voter\WalletVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wallets", name="app_wallet_")
 */
class WalletController extends AbstractController
{
    /**
     * @param Request       $request
     * @param WalletFactory $factory
     *
     * @return Response
     *
     * @Route("/create", name="create")
     */
    public function create(Request $request, WalletFactory $factory): Response
    {
        $form = $this->createForm(WalletType::class, $wallet = $factory->create());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->perform(new CreateWallet($wallet));

            // add some flash bag message

            return $this->redirectToRoute('app_page_overview');
        }

        return $this->render('app/wallet/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Wallet  $wallet
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/{wallet}/edit", name="edit")
     */
    public function edit(Wallet $wallet, Request $request): Response
    {
        $oldBalance = $wallet->getBalance();

        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->perform(new UpdateWallet($oldBalance, $wallet));

            return $this->redirectToRoute('app_page_overview');
        }

        return $this->render('app/wallet/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Wallet $wallet
     *
     * @return Response
     *
     * @Route("/{wallet}/switch", name="switch")
     */
    public function switch(Wallet $wallet): Response
    {
        $this->denyAccessUnlessGranted(WalletVoter::SWITCH, $wallet);

        $this->perform(new AssignActiveWallet($wallet));

        // add some flash bag message

        return $this->redirectToRoute('app_page_overview');
    }
}
