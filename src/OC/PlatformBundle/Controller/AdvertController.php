<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OC\PlatformBundle\Entity\Advert;

/**
* 
*/
class AdvertController extends Controller
{
	
	public function indexAction()
	{
		return $this->render('OCPlatformBundle:Advert:index.html.twig',array('listAdverts'=>array()));
	}

	public function viewAction($id)
	{
		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()
		);
		    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('OCPlatformBundle:Advert')
	    ;
	    $advert = $repository->find($id);
	     if (null === $advert) {
	      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
	    }
	        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
	      'advert' => $advert
	    ));


		return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
		  'advert' => $advert
		));
	}
	public function viewSlugAction($year, $slug, $_format)
	{
		return new Response("Affichage de $year $slug $_format");
	}

	public function addAction(Request $request)
	{
	    // Création de l'entité
	    $advert = new Advert();
	    $advert->setTitle('Recherche développeur Symfony2.');
	    $advert->setAuthor('Alexandre');
	    $advert->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");
	    $advert->setData(new \DateTime());
	    // On peut ne pas définir ni la date ni la publication,
	    // car ces attributs sont définis automatiquement dans le constructeur

	    // On récupère l'EntityManager
	    $em = $this->getDoctrine()->getManager();

	    // Étape 1 : On « persiste » l'entité
	    $em->persist($advert);

	    // Étape 2 : On « flush » tout ce qui a été persisté avant
	    $em->flush();

	    // Reste de la méthode qu'on avait déjà écrit
	    if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
			return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
	    }

	    return $this->render('OCPlatformBundle:Advert:add.html.twig');
	}

	
  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
	
}