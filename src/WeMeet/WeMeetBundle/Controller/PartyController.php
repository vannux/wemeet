<?php
namespace WeMeet\WeMeetBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Lsw\ApiCallerBundle\Call\HttpGetJson;

use WeMeet\WeMeetBundle\Entity\User;
use WeMeet\WeMeetBundle\Entity\Partyevents;
use WeMeet\WeMeetBundle\Controller\WeMeetController;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PartyController extends WeMeetController {
	/**
	 * @Rest\View()
	 * @param Partyevents $id
	 * @return array
	 */
	public function getPartyAction($id)
	{
		$party = $this->container->get('doctrine.orm.entity_manager')->getRepository('WeMeetWeMeetBundle:Partyevents')->find($id);
		return array($party);
	}
	/**
	 * @Rest\View()
	 * @return array
	 */
	public function getPartyAllAction()
	{
		$logger = $this->get('logger');
		$logger->info('getPartyAllAction chiamata');
		$parties = $this->container->get('doctrine.orm.entity_manager')->getRepository('WeMeetWeMeetBundle:Partyevents')->findAll();
		return $parties;
	}
	/**
	 * @Rest\View()
	 * @param string $apikey
	 * @return string
	 */
	public function putPartyAction($apikey)
	{
		$logger = $this->get('logger');
		$logger->info('putPartyAction: apikey' . $apikey);
	
		$user = $this->userGet($apikey);
	
		$json = $this->decodeJSONPayload();
	
		$doctrineManager = $this->container->get('doctrine.orm.entity_manager');
		
		$party = new Partyevents();
		$party->setCreatedBy($user);
		$party->setName($json->{'name'});
		$party->setDescription($json->{'description'});
		$party->setEventdate(new \DateTime($json->{'eventdate'}));
		$party->setCity($json->{'city'});
		$party->setLocation($json->{'location'});
		$party->setGeolat($json->{'geolat'});
		$party->setGeolon($json->{'geolon'});
		$party->setPublic($json->{'public'});
		
		$doctrineManager->persist($party);
		$doctrineManager->flush();
	
		//return '';
	}
}
