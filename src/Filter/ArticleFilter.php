<?php

namespace App\Filter;

class ArticleFilter
{
    public function __construct(
        private ?string $query = null,
        private array $categories = [],
        private array $authors = [],
    ) {
    }

    /**
     * Get the value of query
     *
     * @return ?string
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * Set the value of query
     *
     * @param ?string $query
     *
     * @return self
     */
    public function setQuery(?string $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get the value of categories
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @param array $categories
     *
     * @return self
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get the value of authors
     *
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * Set the value of authors
     *
     * @param array $authors
     *
     * @return self
     */
    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }
}
