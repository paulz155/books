<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Author;

class AuthorController extends AbstractController {

	/**
	 * @Route("/authors")
	 */
	public function index() {
		return $this->render('author.html.twig', []);
	}
	
	/**
	 * @Route("/authors/all")
	 */
	public function actionAll() {
		$rows = [];
		foreach($this->getDoctrine()->getRepository(Author::class)->findAll() as $row)
		{
			$rows[] = [$row->getId(), $row->getName(), $row->getSecondName(), $row->getFamily()];
		}
			
		return $this->render('json.html.twig', ['data' => ['success' => true, 'data' => $rows]]);
	}
	
	/**
	 * @Route("/authors/add")
	 */
	public function actionSave() {
		$new = $_POST['author'];
		$rep = $this->getDoctrine()->getRepository(Author::class);
		$em = $this->getDoctrine()->getManager();
		
		if(empty($_POST['id'])) {
			$exist = $rep->findOneBy($new);		
		
			if($exist) 
				return $this->render('json.html.twig', ['data' => ['success' => false, 'error' => 'Уже есть такой']]);
			$author = new Author();
		}
		else {
			$author = $rep->find($_POST['id']);	
			if(!$author) 
				return $this->render('json.html.twig', ['data' => ['success' => false, 'error' => 'Не найден']]);			
		}
				
		$author->setName($new['Name']);
		$author->setSecondName($new['SecondName']);
		$author->setFamily($new['Family']);

		$em->persist($author);
		$em->flush();
			
		return $this->render('json.html.twig', ['data' => ['success' => true]]);
	}
	
	/**
	 * @Route("/authors/del")
	 */
	public function actionDel() {
		$id = $_POST['id'];
		$exist = $this->getDoctrine()->getRepository(Author::class)->find($id);		
		
		if(!$exist) 			
			return $this->render('json.html.twig', ['data' => ['success' => false, 'error' => 'Не найден']]);
		
		$em = $this->getDoctrine()->getManager();
		$em->remove($exist);
		$em->flush();
			
		return $this->render('json.html.twig', ['data' => ['success' => true]]);
	}
}
