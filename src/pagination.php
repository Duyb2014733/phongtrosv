<?php
namespace website\src;

use PDO;
class Pagination {
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;
    private $baseUrl;
    private $queryParameters;

    public function __construct($totalItems, $itemsPerPage, $currentPage, $baseUrl, $queryParameters = array()) {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->baseUrl = $baseUrl;
        $this->queryParameters = $queryParameters;
    }

    public function generatePaginationHtml() {
        $pagination = '<ul class="pagination style="align-items: center;"">';

        $totalPages = ceil($this->totalItems / $this->itemsPerPage);

        if ($this->currentPage > 1) {
            $prevPage = $this->currentPage - 1;
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $this->buildUrl($prevPage) . '">Previous</a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $pagination .= '<li class="page-item ' . ($i == $this->currentPage ? 'active' : '') . '"><a class="page-link" href="' . $this->buildUrl($i) . '">' . $i . '</a></li>';
        }

        if ($this->currentPage < $totalPages) {
            $nextPage = $this->currentPage + 1;
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $this->buildUrl($nextPage) . '">Next</a></li>';
        }

        $pagination .= '</ul>';

        return $pagination;
    }

    private function buildUrl($page) {
        $queryParameters = array_merge($this->queryParameters, ['page' => $page]);
        return $this->baseUrl . '?' . http_build_query($queryParameters);
    }

    
}
