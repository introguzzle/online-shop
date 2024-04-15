<?php

namespace controller;

use entity\Book;
use entity\CartBook;
use repository\BookRepository;
use repository\CartBookRepository;
use repository\CartRepository;
use service\CartService;
use session\Authentication;

class CartController extends Controller
{
    private BookRepository $bookRepository;
    private CartRepository $cartRepository;
    private CartBookRepository $cartBookRepository;

    public function __construct()
    {
        parent::__construct();

        $this->bookRepository = new BookRepository();
        $this->cartRepository = new CartRepository();
        $this->cartBookRepository = new CartBookRepository();
    }

    public function view(): void
    {
        $user = Authentication::getUser();
        $cart = $this->cartRepository->getByUserId($user->getId());
        $books = $this->cartBookRepository->getAllBooksByCartId($cart->getId());

        usort($books, function(Book $b1, Book $b2): int {
            return $b1->getId() - $b2->getId();
        });

        $cartBooks = $this->cartBookRepository->getByCartId($cart->getId());
        $totalPrice = $this->computeTotalPrice($cartBooks);
        $quantityOfBooks = $this->bindQuantityToBooks($books, $cartBooks);

        require_once $this->renderer->render("cart.phtml", "Cart");
    }

    private function bindQuantityToBooks(array $books, array $cartBooks): array
    {
        $bound = [];

        foreach ($books as $book) {
            foreach ($cartBooks as $cartBook) {
                if ($book->getId() === $cartBook->getBookId()) {
                    $bound[$book->getId()] = $cartBook->getQuantity();
                }
            }
        }

        return $bound;
    }

    private function computeTotalPrice(array $cartBooks): int
    {
        return array_reduce($cartBooks, function(int $acc, CartBook $cartBook): int {
            $book = $this->bookRepository->getById($cartBook->getBookId());
            return $acc + ($book->getPrice() * $cartBook->getQuantity());
        }, 0);
    }

    public function addFromCatalog(): void
    {
        $bookId = $_POST["book_id"];

        $user = Authentication::getUser();
        $book = $this->bookRepository->getById($bookId);

        $this->cartBookRepository->saveBook($user, $book);

        header("Location: /catalog");
    }

    public function add(): void
    {
        $this->change(1);
    }

    public function remove(): void
    {
        $this->change(-1);
    }

    public function change(int $value): void
    {
        $bookId = $_POST["book_id"];

        $user = Authentication::getUser();
        $cart = $this->cartRepository->getByUserId($user->getId());
        $cartBooks = $this->cartBookRepository->getByCartIdAndBookId(
            $cart->getId(),
            $bookId
        );

        $cartBookId = ($cartBooks[0])->getId();

        $this->cartBookRepository->changeQuantityById($cartBookId, $value);

        header("Location: /cart");
    }
}