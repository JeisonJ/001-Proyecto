<?php

class Utilities {


    public function getPaging(
        $page, $total_rows, $records_per_page, $page_url) {
        
        // Paging array.
        $paging_array = array();

        // Button for first page.
        $paging_array['first'] = $page > 1 ? "{$page_url}&page=1" : "";

        /* Count all products in the database to calculate total pages.
         * 
         * ceil — Redondear fracciones hacia arriba.
         * http://php.net/manual/es/function.ceil.php
         */
        $total_pages = ceil($total_rows / $records_per_page);

        // Range of links to shows.
        $range = 2;

        // Display links to 'range of page' around 'current page'.
        // Mostrar enlaces en un 'rango de páginas' en torno a la 'página actual'.
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range) + 1;

        $paging_array['pages'] = array();
        $page_count = 0;

        for($x = $initial_num; $x < $condition_limit_num; $x++) {
            // Asegúrese de que '$x es mayor que 0' Y' menor o igual a $total_pages'.
            if(($x > 0) && ($x <= $total_pages)){
                $paging_array['pages'][$page_count]["page"]=$x;
                $paging_array['pages'][$page_count]["url"]="{$page_url}&page={$x}";
                $paging_array['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
 
                $page_count++;
            }
               
        }
        
        // Button for last page.
        $paging_array["last"] = $page<$total_pages ? "{$page_url}&page={$total_pages}" : "";

        // json format.
        return $paging_array;
        
    }
}