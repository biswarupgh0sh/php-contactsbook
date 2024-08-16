<?php
define("SITE", "/contactsbook/");

function print_arr($arr)
{
    echo "<pre>";
    print_r($arr);
}

function getPagination($total_records, $current_page = 1, $per_page = 5)
{
    $total_pages = ($total_records > 0) ? ceil($total_records / $per_page) : 0;
    $pagination = '';
    if ($total_pages > 1) {

        $pagination .= '<nav>
            <ul class="pagination justify-content-center">';
        $prevClass = ($current_page <= 1) ? " disabled" : "";
        $pagination .= '<li class="page-item' . $prevClass . '">
                <a class="page-link" href="' . SITE . 'index.php?page=' . ($current_page - 1) . '" >Previous</a>
                </li>';
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                $pagination .= '<li class="page-item active"><a class="page-link" href="' . SITE . 'index.php?page=' . $i . '">' . $i . '</a></li>';
            } else {
                $pagination .= '<li class="page-item"><a class="page-link" href="' . SITE . 'index.php?page=' . $i . '">' . $i . '</a></li>
                ';
            }
        }

        $nextClass = ($current_page >= $total_pages) ? " disabled" : "";

        $pagination .= '<li class="page-item' . $nextClass . '">
                <a class="page-link" href="' . SITE . 'index.php?page=' . ($current_page + 1) . '">Next</a>
            </li>';

        $pagination .= '</ul>
        </nav>';
    }
    echo $pagination;
}
