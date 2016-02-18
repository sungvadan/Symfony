<?php

namespace OC\PlatformBundle\Beta;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
	protected $betaHtml;

	protected $endDate;

	public function __construct(BetaHtml $betaHTML, $endDate){
		$this->betaHtml = $betaHTML;
		$this->endDate = new \Datetime($endDate);
	}

	public function processBeta(FilterResponseEvent $event)
	{
	    // On teste si la requête est bien la requête principale (et non une sous-requête)
	    if (!$event->isMasterRequest()) {
	      return;
	    }

	    $remainingDays = $this->endDate->diff(new \Datetime())->format('%d');

	    if($remainingDays <= 0){
	    	return;
	    }

        // On récupère la réponse que le gestionnaire a insérée dans l'évènement
	    $response = $this->betaHtml->displayBeta($event->getResponse(), $remainingDays);

	    // Ici on modifie comme on veut la réponse…

	    // Puis on insère la réponse modifiée dans l'évènement
	    $event->setResponse($response);

	}
}