<?php

namespace WeMeet\WeMeetBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Lsw\ApiCallerBundle\Call\HttpGetJson;

use WeMeet\WeMeetBundle\Entity\User;
use WeMeet\WeMeetBundle\Entity\Userposition;
use WeMeet\WeMeetBundle\Controller\WeMeetController;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends WeMeetController {
	
	/**
	 * @Rest\View()
	 * @param User $id
	 * @return array
	 */
	public function getUserAction($id)
	{
		$user = $this->container->get('doctrine.orm.entity_manager')->getRepository('WeMeetWeMeetBundle:User')->find($id);
		return array($user);
	}	
	/**
	 * @Rest\View()
	 * @return array
	 */
	public function getUserAllAction()
	{
		$logger = $this->get('logger');
		$logger->info('getUsersAllAction chiamata');
		$users = $this->container->get('doctrine.orm.entity_manager')->getRepository('WeMeetWeMeetBundle:User')->findAll();
		return $users;
	}
	
	/**
	 * @Rest\View()
	 * @param string $access_token
	 * @return string
	 */
	public function getLoginFacebookAction($access_token)
	{
		$logger = $this->get('logger');
		$logger->info('putLoginFBUser: ' . $access_token);
		$graph_url = "https://graph.facebook.com/me?" . "access_token=" . $access_token;
		$logger->info('putLoginFBUser: - graph_url ' . $graph_url);
		$parameters = array("access_token" => $access_token);
		$output = $this->get('api_caller')->call(new HttpGetJson('https://graph.facebook.com/me', $parameters));
		
		$doctrineManager = $this->container->get('doctrine.orm.entity_manager');
		$logger->info('username ' . $output->{'username'});
		$user = $doctrineManager->getRepository('WeMeetWeMeetBundle:User')->findOneByFacebookId($output->{'id'});
		
		if (!$user) {
			//L'utente non esiste quindi lo creo nel db e genero un api key random
			$user = new User();
			$user->setFirstname($output->{'first_name'});
			$user->setLastname($output->{'last_name'});
			$user->setUsername($output->{'username'});
			$user->setFacebookId($output->{'id'});
			$doctrineManager->persist($user);
			$doctrineManager->flush();
			//Utente creato restituisco l'api-key
			$this->apikey = $user->getApikey();
		}
		else {
			//Utente trovato restituisco l'api-key
			$this->apikey =  $user->getApikey();
		}
		
		$arr = array('apikey'=>$this->apikey);
		return $arr;
	}
	
	/**
	 * @Rest\View()
	 * @param string $apikey
	 * @return string
	 */
	public function getUserPositionAction($apikey)
	{
		$logger = $this->get('logger');
		$logger->info('getUserPosition: apikey' . $apikey);
		
		$user = $this->userGet($apikey);
		
		$doctrineManager = $this->container->get('doctrine.orm.entity_manager');
		$position = $doctrineManager->getRepository('WeMeetWeMeetBundle:Userposition')->findOneByUser($user);
		
		if (!$position) {
			throw new NotFoundHttpException('No user position');
		}
		return $position;
	}
	
	/**
	 * @Rest\View()
	 * @param string $apikey
	 * @return string
	 */
	public function putUserPositionAction($apikey)
	{
		$logger = $this->get('logger');
		$logger->info('putUserPositionAction: apikey' . $apikey);
		
		$user = $this->userGet($apikey);
		
		$json = $this->decodeJSONPayload();
		
		$doctrineManager = $this->container->get('doctrine.orm.entity_manager');
		$userposition = $doctrineManager->getRepository('WeMeetWeMeetBundle:Userposition')->findOneByUser($user);
		
		if (!$userposition) {
			$userposition = new Userposition();
			$userposition->setUser($user);
		}
		$userposition->setGeolat($json->{'geolat'});
		$userposition->setGeolon($json->{'geolon'});
		$doctrineManager->persist($userposition);
		$doctrineManager->flush();
		
		//return '';
	}
}