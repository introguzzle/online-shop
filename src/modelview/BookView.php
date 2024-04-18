<?php

namespace modelview;

use entity\Book;
use entity\Review;

class BookView
{
    private Book $book;
    private array $reviewViews;

    private float|string $averageRating;

    public function __construct(
        Book $book,
        array $reviewViews,
        float|string $averageRating
    )
    {
        $this->book = $book;
        $this->reviewViews = $reviewViews;
        $this->averageRating = $averageRating;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getReviewViews(): array
    {
        return $this->reviewViews;
    }

    public function getAverageRating(): float|string
    {
        return $this->averageRating;
    }
}