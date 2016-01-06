<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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