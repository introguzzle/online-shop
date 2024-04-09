<?php

namespace dto;

class Book extends DTO {
    private int $id;
    private string $name;
    private string $author;
    private string $description;
    private int $price;
    private int $year;
    private string $imageUrl;

    public function __construct(int $id,
                                string $name,
                                string $author,
                                string $description,
                                int $price,
                                int $year,
                                string $imageUrl) {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
        $this->description = $description;
        $this->price = $price;
        $this->year = $year;
        $this->imageUrl = $imageUrl;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getPrice(): int {
        return $this->price;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function getImageUrl(): string {
        return $this->imageUrl;
    }
}