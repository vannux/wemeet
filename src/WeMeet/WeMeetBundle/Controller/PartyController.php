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
	 * @param string $apikey
	 * @return array
	 */
	public function postPartyAction($apikey)
	{
		$logger = $this->get('logger');
		$logger->info('getPartyAction chiamata');
		$logger->info('getPartyAction: apikey ' . $apikey);
		
		$user = $this->userGet($apikey);
		$json = $this->decodeJSONPayload();
		
		$logger->info('getPartyAction: id ' . $json->{'id'});
		
		$party = $this->container->get('doctrine.orm.entity_manager')->getRepository('WeMeetWeMeetBundle:Partyevents')->find($json->{'id'});
		return array($party);
	}
	/**
	 * @Rest\View()
	 * @param string $apikey
	 * @return array
	 */
	public function getPartyAllAction($apikey)
	{
		$logger = $this->get('logger');
		$logger->info('getPartyAllAction chiamata');
		$logger->info('getPartyAllAction: apikey ' . $apikey);
		
		$user = $this->userGet($apikey);
		
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
		$logger->info('putPartyAction: apikey ' . $apikey);
	
		$user = $this->userGet($apikey);
	
		$json = $this->decodeJSONPayload();
	
		$doctrineManager = $this->container->get('doctrine.orm.entity_manager');
		
		$id = $json->{'id'};
		$logger->info('putPartyAction: id ' . $id);
		if ($id != '') {
			$logger->info('putPartyAction: getting party with id ' . $id );
			$party = $this->container->get('doctrine.orm.entity_manager')->getRepository('WeMeetWeMeetBundle:Partyevents')->find($json->{'id'});
		} else {
			$logger->info('putPartyAction: creating new party');
			$party = new Partyevents();
		}
		
		$party->setCreatedBy($user);
		$party->setName($json->{'name'});
		$party->setDescription($json->{'description'});
		$party->setEventdate(new \DateTime(str_replace('\\/', '/', $json->{'eventdate'})));
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
