<?php

namespace request;

class ReviewRequest extends Request
{
    public function __construct(
        array $body
    )
    {
        parent::__construct(
            "POST",
            "/catalog/add-review",
            ["Content-Type: application/x-www-form-urlencoded"],
            $body
        );
    }

    public function getText()
    {
        return $this->getBody()["text"];
    }

    public function getRating()
    {
        return $this->getBody()["rating"];
    }

    public function getBookId()
    {
        return $this->getBody()["book-id"];
    }

    public function getFrom()
    {
        return $this->getBody()["from"];
    }

    public function getId()
    {
        return $this->getBody()["review-id"];
    }
}