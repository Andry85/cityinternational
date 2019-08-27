<?php
namespace IllicitWeb;

class MainDisplayProductCats
{
    const MAX_CATS = 8; // -1 for no limit

    private $terms; // Array of ProductCategory

    public function __construct()
    {
        $this->populateTermsArray();
        $this->filterTermsArray();
        $this->sortTermsArray();
        $this->limitTermsArray();
    }

    // $fn must accept 1 ProductCategory instance
    public function forEachTerm($fn)
    {
        foreach ($this->terms as $term)
        {
            $fn($term);
        }
    }

    public function isEmpty()
    {
        return count($this->terms) === 0;
    }

    private function populateTermsArray()
    {
        $terms = get_terms(WC_PRODUCT_CAT);

        if (is_array($terms))
        {
            $this->terms = ProductCategory::fromWpTerms($terms);
        }
        else
        {
            $this->terms = [];
        }
    }

    private function filterTermsArray()
    {
        $this->terms = array_filter($this->terms, function (ProductCategory $term) {
            return $term->shouldDisplay();
        });
    }

    private function sortTermsArray()
    {
        @usort($this->terms, function (ProductCategory $term_a, ProductCategory $term_b) {
            return $term_a->displayOrder() - $term_b->displayOrder();
        });
    }

    private function getMaxCategories()
    {
        return self::MAX_CATS;
    }

    private function limitTermsArray()
    {
        $limit = $this->getMaxCategories();

        if ($limit >= 0)
        {
            $this->terms = array_slice($this->terms, 0, $limit);
        }
    }
}
