<?php

namespace entity;

use DateTime;

class Review extends Entity
{
    private int $id;
    private int $userId;
    private int $bookId;
    private string $text;
    private float $rating;
    private string $createdAt;

    public function __construct(
        int $userId,
        int $bookId,
        string $text,
        float $rating,
        int $id = 0
    )
    {
        $this->userId = $userId;
        $this->bookId = $bookId;
        $this->text = $text;
        $this->rating = $rating;
        $this->createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): void
    {
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

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}