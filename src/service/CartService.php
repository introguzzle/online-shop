<?php

namespace service;

use entity\Cart;
use entity\CartBook;
use entity\User;
use modelview\CartBookView;
use modelview\CartView;
use repository\BookRepository;
use repository\CartBookRepository;
use repository\CartRepository;
use service\authentication\Authentication;

class CartService implements Service
{

    private CartRepository $cartRepository;
    private CartBookRepository $cartBookRepository;
    private BookRepository $bookRepository;

    public function __construct(
        CartRepository $cartRepository,
        CartBookRepository $cartBookRepository,
        BookRepository $bookRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartBookRepository = $cartBookRepository;
        $this->bookRepository = $bookRepository;
    }


    public function addFromCatalog(int $bookId): void
    {
        $user = Authentication::getUser();
        $book = $this->bookRepository->getById($bookId);

        if ($this->cartRepository->getByUserId($user->getId()) === null) {
            $this->saveCart($user);
        }

        $this->cartBookRepository->saveBook($user, $book);
    }

    public function getAllBooks(int $userId): array
    {
        $cart = $this->cartRepository->getByUserId($userId);
        return $this->cartBookRepository->getAllBooksByCartId($cart->getId());
    }

    public function getAllCartBooks(int $userId): array
    {
        $cart = $this->cartRepository->getByUserId($userId);
        return $this->cartBookRepository->getByCartId($cart->getId());
    }

    public function saveCart(User $user): void {
        $cart = new Cart($user->getId());
        $this->cartRepository->save($cart);
    }

    public function add(int $bookId): void
    {
        $this->change($bookId, 1);
    }

    public function remove(int $bookId): void
    {
        $this->change($bookId,-1);
    }

    public function change(int $bookId, int $value): void
    {
        $user = Authentication::getUser();
        $cart = $this->cartRepository->getByUserId($user->getId());
        $cartBook = $this->cartBookRepository->getByCartIdAndBookId(
            $cart->getId(),
            $bookId
        );

        $cartBookId = $cartBook->getId();

        $this->cartBookRepository->changeQuantityById($cartBookId, $value);
    }

    private function createCartBookViews(array $books, array $cartBooks): array
    {
        $views = [];

        foreach ($books as $book) foreach ($cartBooks as $cartBook)
            if ($book->getId() === $cartBook->getBookId()) {
                $views[] = new CartBookView($book, $cartBook);
            }

        return $views;
    }

    private function computeTotalPrice(array $cartBooks): int
    {
        return array_reduce($cartBooks, function(int $acc, CartBook $cartBook): int {
            $book = $this->bookRepository->getById($cartBook->getBookId());
            return $acc + ($book->getPrice() * $cartBook->getQuantity());
        }, 0);
    }

    public function getCartView(int $userId): CartView
    {
        $books     = $this->getAllBooks($userId);
        $cartBooks = $this->getAllCartBooks($userId);

        return new CartView(
            $this->createCartBookViews($books, $cartBooks),
            $this->computeTotalPrice($cartBooks)
        );
    }
}