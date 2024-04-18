<?php

namespace service;

use dto\Errors;
use dto\ReviewDTO;

use entity\Book;
use entity\Entity;
use entity\Review;

use modelview\BookView;
use modelview\ReviewView;

use repository\BookRepository;
use repository\ReviewRepository;
use repository\UserRepository;
use service\authentication\Authentication;
use Throwable;

class CatalogService implements Service
{
    private BookRepository $bookRepository;
    private ReviewRepository $reviewRepository;
    private UserRepository $userRepository;

    public function __construct(
        BookRepository $bookRepository,
        ReviewRepository $reviewRepository,
        UserRepository $userRepository
    )
    {
        $this->bookRepository = $bookRepository;
        $this->reviewRepository = $reviewRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->getAll();
    }

    public function getBookById(int $id): Book | Entity | null
    {
        return $this->bookRepository->getById($id);
    }

    public function getAllReviewsByBookId(int $bookId): array
    {
        return $this->reviewRepository->getByBookId($bookId);
    }

    public function getReviewViewsByBookId(int $bookId): array
    {
        $reviews = $this->getAllReviewsByBookId($bookId);

        return array_map(function(Review $review) {
            return new ReviewView(
                $review,
                $this->userRepository->getById($review->getUserId())
            );
        }, $reviews);
    }

    private function computeAverageRating(array $allReviewsByBookId): float|int|string
    {
        $count = $this->reviewRepository->count();

        if ($count == 0) {
            return "No enough reviews";
        }

        $all = array_reduce($allReviewsByBookId, function(float $acc, Review $review) {
            return $acc + $review->getRating();
        }, 0.0);

        return $all / (float) $count;
    }

    public function getBookView(mixed $bookId): ?BookView
    {
        $book = $this->getBookById($bookId);

        if ($book === null) {
            return null;
        }

        return new BookView(
            $this->getBookById($bookId),
            $this->getReviewViewsByBookId($bookId),
            $this->computeAverageRating($this->getAllReviewsByBookId($bookId))
        );
    }

    public function addReview(ReviewDTO $dto): Errors
    {
        $errors = Errors::create();

        try {
            $review = $this->createReview($dto);
            $this->reviewRepository->save($review);
        } catch (Throwable $t) {
            print_r($t);
            $errors->add("internal", "Internal server error");
        }

        return $errors;
    }

    private function createReview(ReviewDTO $dto): Review
    {
        return new Review(
            Authentication::getUser()->getId(),
            intval($dto->getBookId()),
            $dto->getText(),
            floatval($dto->getRating())
        );
    }

    public function deleteReview(int $reviewId): Errors
    {
        $errors = Errors::create();

        $this->reviewRepository->deleteById($reviewId);

        return $errors;
    }

}