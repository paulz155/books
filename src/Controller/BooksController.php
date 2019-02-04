<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\BookAuthor;

class BooksController extends AbstractController {

	/**
	 * @Route("/")
	 */
	public function index() {
		return $this->render('books.html.twig', []);
	}
	
	/**
	 * @Route("/books/all")
	 */
	public function actionAll() {
		$rows = [];
		foreach($this->getDoctrine()->getRepository(Book::class)->findAll() as $row) {
			$authors = [];
			foreach($row->getAuthors() as $a) {
				$au = $a->getAuthor();
				$authors[] = $au->getFamily() . ' ' . mb_substr($au->getName(), 0, 1) . '.' . mb_substr($au->getSecondName(), 0, 1) . '.';
			}
			$rows[] = [$row->getId(), $row->getTitle(), $row->getCreatedYear(), $row->getISBN(), $row->getPagesCount(), implode(',', $authors)];
		}
			
		return $this->render('json.html.twig', ['data' => ['success' => true, 'data' => $rows]]);
	}
	
	/**
	 * @Route("/books/add")
	 */
	public function actionSave() {
		$new = $_POST['book'];
		$rep = $this->getDoctrine()->getRepository(Book::class);
		$em = $this->getDoctrine()->getManager();
		
		if(empty($_POST['id'])) {
			$exist = $rep->findOneBy($new);		
		
			if($exist) 
				return $this->render('json.html.twig', ['data' => ['success' => false, 'error' => 'Уже есть такой']]);
			$book = new Book();
		}
		else {
			$book = $rep->find($_POST['id']);	
			if(!$book) 
				return $this->render('json.html.twig', ['data' => ['success' => false, 'error' => 'Не найден']]);			
		}
				
		$book->setTitle($new['Title']);
		$book->setCreatedYear($new['CreatedYear']);
		$book->setISBN($new['ISBN']);
		$book->setPagesCount($new['PagesCount']);

		$em->persist($book);
		$em->flush();
			
		return $this->render('json.html.twig', ['data' => ['success' => true]]);
	}
	
	/**
	 * @Route("/books/del")
	 */
	public function actionDel() {
		$id = $_POST['id'];
		$exist = $this->getDoctrine()->getRepository(Book::class)->find($id);		
		
		if(!$exist) 			
			return $this->render('json.html.twig', ['data' => ['success' => false, 'error' => 'Не найден']]);
		
		$em = $this->getDoctrine()->getManager();
		$em->remove($exist);
		$em->flush();
			
		return $this->render('json.html.twig', ['data' => ['success' => true]]);
	}
	
		/**
	 * @Route("/books/author")
	 */
	public function actionAuthor() {
		$new = $_POST['bookAuthor'];
		$book = $this->getDoctrine()->getRepository(Book::class)->find($new['Book']);
		$author = $this->getDoctrine()->getRepository(Author::class)->find($new['Author']);
		
		$em = $this->getDoctrine()->getManager();
			
		$link = new BookAuthor();
		$link->setBook($book);
		$link->setAuthor($author);

		$em->persist($link);
		$em->flush();
			
		return $this->render('json.html.twig', ['data' => ['success' => true]]);
	}
}
