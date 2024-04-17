<?php

namespace entity;

class Book extends Entity
{
    private int $id;
    private string $name;
    private string $author;
    private string $description;
    private int $price;
    private int $year;
    private string $imageUrl;

    public function __construct(
        int $id,
        string $name,
        string $author,
        string $description,
        int $price,
        int $year,
        string $imageUrl
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
        $this->description = $description;
        $this->price = $price;
        $this->year = $year;
        $this->imageUrl = $imageUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }
}