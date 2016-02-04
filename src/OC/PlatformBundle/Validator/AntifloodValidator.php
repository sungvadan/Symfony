<?php
// src/OC/PlatformBundle/Validator/AntifloodValidator.php

namespace OC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;

class AntifloodValidator extends ConstraintValidator
{
	private $requestStack;
	private $em;

	public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
	{
		$this->requestStack = $requestStack;
		$this->em           = $em;
	}

	public function validate($value, Constraint $constraint)
	{
		$request = $this->requestStack->getCurrentRequest();
		$ip = $request->getClientIp();
		$idFlood = $this->em
			->getRepository('OCPlatformBundle:Application')
			->isFlood($ip,15)
		;
		if($isFlood)
		{
			$this->context->addViolation($constraint->message);
		}
	}
}