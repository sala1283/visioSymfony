<?php

namespace App\Controller\Gite;

use App\Entity\Gite;
use App\Entity\GiteSearch;
use App\Form\GiteSearchType;
use App\Repository\GiteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GiteController extends AbstractController
{
    private GiteRepository $repo;
    public function __construct(GiteRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $gites = $this->repo->findLastGite();
        return $this->render('home/index.html.twig', ['gites' => $gites]);
    }
    /**
     * @Route("/gites", name="gite.index")
     */
    public function gites(Request $request)
    {
        $search = new GiteSearch();
        $form = $this->createForm(GiteSearchType::class, $search);
        $form->handleRequest($request);
        $gites = $this->repo->findAllGiteSearch($search);
        return $this->render('gite/index.html.twig', [
            'gites' => $gites,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/gite/{id}", name = "gite.show")
     */
    public function show(Gite $gite)
    {
        //$gite = $this->repo->find($id);
        return $this->render('gite/show.html.twig', ["gite" => $gite]);
    }
}
