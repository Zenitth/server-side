<?php

namespace zenitth\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ApiController extends Controller
{

	public function getTestAction()
	{
		return array('id' => 1, 'name' => 'Arnaud');
	}

	public function getQuizzAction()
	{
		$tabQuestions = [];
		$user = $this->getDoctrine()->getRepository("ZenitthUserBundle:User")->find(1);
		$brand = $user->getUserBrand();
		$questions = $brand->getBrandQuestions();
		
		$arrayId= array();
		for($i=0;$i<10;$i++){
			$randQuestion=rand(0,count($questions));

			if (!in_array($randQuestion, $arrayId )) {
				array_push($arrayId, $randQuestion);
			}
		}

		foreach ($arrayId as $id => $question) {
			array_push($tabQuestions,$questions[$id]);
		}
		return $tabQuestions;
	}
}
