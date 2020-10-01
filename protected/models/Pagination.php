<?php

// TODO probably models is the wrong directory for a service type class like this.
class Pagination
{
    /**
     * Check if the given pagination params are correctly formed and otherwise sane.
     *
     * @param $pagesize int number of pages
     * @param $page int the specific page to find
     * @return string|bool false if the params are ok, a string containing an error message otherwise.
     */
    public static function checkPageParams($pagesize, $page)
    {
        // Return a detailed error message when we've given incorrect params.
        $error = false;

        // First check pagesize.
        if (!is_numeric($pagesize)) {
            $error .= "Pagesize must be a number\n";
        } else if ($pagesize < 1) {
            $error .= "Pagesize must be greater than zero.\n";
        }
        // Check page.
        if (!is_numeric($page)) {
            $error .= "Page must be a number.\n";
        } else if ($page < 1) {
            $error .= "Page must be greater than zero.\n";
        }
        return $error;
    }
}
