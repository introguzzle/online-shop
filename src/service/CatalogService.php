<?php

namespace service;

use entity\Book;
use repository\BookRepository;
use repository\CartRepository;
use session\Authentication;

class CatalogService implements Service {
    private BookRepository $bookRepository;
    private CartRepository $cartRepository;

    public function __construct() {
        $this->bookRepository = new BookRepository();
        $this->cartRepository = new CartRepository();
    }

    public function getAllBooks(): array {
        return $this->bookRepository->getAll();
    }

    public function add(): void {
       $bookId = $_POST["book_id"];

       $user = Authentication::getUser();
       $book = $this->bookRepository->getById($bookId);

       $this->cartRepository->saveBook($user, $book);
    }
}