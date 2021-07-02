<?php

namespace App\Controller\Gite;

use App\Entity\Contact;
use App\Entity\Gite;
use App\Entity\GiteSearch;
use App\Form\ContactType;
use App\Form\GiteSearchType;
use App\Notification\ContactNotification;
use App\Repository\GiteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
    public function index(): Response
    {
        $gites = $this->repo->findLastGite();
        return $this->render('home/index.html.twig', ['gites' => $gites]);
    }
    /**
     * @Route("/gites", name="gite.index")
     */
    public function gites(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new GiteSearch();
        $form = $this->createForm(GiteSearchType::class, $search);
        $form->handleRequest($request);
        $gites = $this->repo->findAllGiteSearch($search);
        $gites = $paginator->paginate(
            $gites, /* query NOT result */

            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );
        return $this->render('gite/index.html.twig', [
            'gites' => $gites,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/gite/{id}", name = "gite.show")
     */
    public function show(Gite $gite, Request $request, ContactNotification $notification): Response
    {
        //$gite = $this->repo->find($id);
        $contact = new Contact();
        $contact->setGite($gite);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('Success', 'Votre email a bien été envoy');
            return $this->redirectToRoute('gite.show', ['id' => $gite->getId()]);
        }
        return $this->render('gite/show.html.twig', ["gite" => $gite, "form" => $form->createView()]);
    }
}
