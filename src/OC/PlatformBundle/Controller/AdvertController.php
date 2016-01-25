<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;

/**
* 
*/
class AdvertController extends Controller
{
	
	public function indexAction()
	{
		/*test commit sur mac */
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
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('OCPlatformBundle:Advert');

	    $advert = $repository->find($id);
	     if (null === $advert) {
	      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
	    }

	    $listApplications = $em->getRepository('OCPlatformBundle:Application')->findBy(array('advert'=>$advert));
	        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
	      'advert' => $advert,
	      'listApplications' => $listApplications
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
	    $advert->setTitle('Recherche développeur Symfony3.');
	    $advert->setAuthor('Alexandre');
	    $advert->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");
	    $advert->setData(new \DateTime());


	    $image  = new  Image();
	    $image->setUrl('https://www.ogdpc.fr/public/images/logoOGDPCWeb.jpg');
	    $image->setAlt('OGDPC');

	    $advert->setImage($image);

	    $application1 = new Application();
	    $application1->setAuthor('Van Truong PHAN');
	    $application1->setContent("j'ai tous les compétence requises");
	    $application1->setAdvert($advert);
        $application1->setDate(new \DateTime());
	
		$application2 = new Application();
	    $application2->setAuthor('Huy Quan PHAN');
	    $application2->setContent("j'ai tous les compétence requises2");
	    $application2->setAdvert($advert);
	    $application2->setDate(new \DateTime());

	    



	    // On peut ne pas définir ni la date ni la publication,
	    // car ces attributs sont définis automatiquement dans le constructeur

	    // On récupère l'EntityManager
	    $em = $this->getDoctrine()->getManager();

	    // Étape 1 : On « persiste » l'entité
	    $em->persist($advert);

     	$em->persist($application1);
     	$em->persist($application2);

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