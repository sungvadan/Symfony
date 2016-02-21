<?php

namespace OC\PlatformBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;


class JsonParamConverter implements ParamConverterInterface
{
	function supports(ParamConverter $configuration)
	{
		if( 'json' !== $configuration->getNAme())
		{
			return false;
		}
		return true;
	}

	function apply(Request $request, ParamConverter $configuration)
	{
		$json = $request->attrubutes->get('json');

		$json = json_decode($json);

		$request->attrubutes->set('json',$json); 
	}
}