<?php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\UserBundle\Entity\Useur;

class LoadUseur implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$names = array(
			'Alexandre',
			'MArine',
			'Ania'
		);
		foreach ($names as $name)
		{
			$user = new Useur;
			$user->setUsername($name);
			$user->setPassword($name);
			$user->setSalt('');
			$user->setRoles(array('ROLE_USER'));
			$manager->persist($user);
		}
		$manager->flush();
	}
}