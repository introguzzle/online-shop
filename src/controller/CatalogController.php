<?php

namespace controller;

use dto\DTO;
use dto\ReviewDTO;
use entity\Review;
use entity\Role;
use request\ReviewRequest;
use service\authentication\Authentication;
use service\CatalogService;
use util\Requests;
use validation\ReviewValidator;

class CatalogController extends Controller
{

    private CatalogService $catalogService;
    private ReviewValidator $reviewValidator;

    public function __construct(
        CatalogService $catalogService,
        ReviewValidator $reviewValidator
    )
    {
        parent::__construct();

        $this->catalogService = $catalogService;
        $this->reviewValidator = $reviewValidator;
    }

    public function view(): void
    {
        $books = $this->catalogService->getAllBooks();

        require_once $this->renderer->render(
            "catalog.phtml",
            "Catalog"
        );
    }

    public function viewBook(): void
    {
        $bookView = $this->catalogService->getBookView($_GET["id"]);

        if ($bookView === null) {
            header("Location: /404");
            return;
        }

        require_once $this->renderer->render(
            "book.phtml",
            "Book"
        );
    }

    public function addReview(ReviewRequest $reviewRequest): void
    {
        $dto = $this->compact($reviewRequest);
        $errors = $this->reviewValidator->validate($dto);

        if ($errors->hasNone() && $this->catalogService->addReview($dto)->hasNone()) {
            $from = $reviewRequest->getFrom();
            header("Location: $from");
            return;
        }
    }
    
    public function deleteReview(ReviewRequest $reviewRequest): void
    {
        if (Authentication::getRole() == Role::USER) {
            return;
        }
        
        $this->catalogService->deleteReview($reviewRequest->getId());

        $from = $reviewRequest->getFrom();
        header("Location: $from");
    }

    private function compact(ReviewRequest $reviewRequest): DTO | ReviewDTO
    {
        return Requests::toDTO($reviewRequest, ReviewDTO::class);
    }
}