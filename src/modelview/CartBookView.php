<?php

namespace modelview;

use entity\Book;
use entity\CartBook;

class CartBookView
{
    private Book $book;
    private CartBook $cartBook;

    public function __construct(Book $book, CartBook $cartBook)
    {
        $this->book = $book;
        $this->cartBook = $cartBook;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getCartBook(): CartBook
    {
        return $this->cartBook;
    }
}