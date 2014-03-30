<?php

namespace WeMeet\WeMeetBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class WeMeetController extends FOSRestController {
	
	public function decodeJSONPayload() {
		$logger = $this->get('logger');
		
		$jsonPayload = $this->getRequest()->get('jsonPayload');
		$logger->info('Parsing json ' . $jsonPayload);
		$json = json_decode($jsonPayload);
		$jsonError = json_last_error();
		if ( $jsonError > 0 ) {
			throw new BadRequestHttpException('Errore decoding JSON payload string ' . $jsonPayload . ' (err. code: ' . $jsonError . ')');
		}
		return $json;
	}
	
	public function userGet($apikey)
	{
		if (!$apikey) {
			throw new BadRequestHttpException('Missing apikey parameter');
		}
	
		$doctrineManager = $this->container->get('doctrine.orm.entity_manager');
		$user = $doctrineManager->getRepository('WeMeetWeMeetBundle:User')->findOneByApikey($apikey);
		if (!$user) {
			throw new NotFoundHttpException('User not found with apikey' . $apikey);
		}
	
		return $user;
	}

}