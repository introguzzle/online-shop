<?php

namespace dto;

class ReviewDTO extends DTO
{
    private string $text;
    private string $rating;
    private string $bookId;

    public function __construct(
        string $text,
        string $rating,
        string $bookId
    )
    {
        $this->text = $text;
        $this->rating = $rating;
        $this->bookId = $bookId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getRating(): string
    {
        return $this->rating;
    }

    public function setRating(string $rating): void
    {
        $this->rating = $rating;
    }

    public function getBookId(): string
    {
        return $this->bookId;
    }

    public function setBookId(string $bookId): void
    {
        $this->bookId = $bookId;
    }


}