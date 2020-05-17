<?php
function check_logged() {
    return isset($_SESSION['isLoggedIn']);
}
//function to return the pagination string
function get_pagination_string($pageSize, $total, $targetPage, array $queryParams = [], $adjacents = 1, $pageParam = 'page')
{
    //defaults
    if(!$adjacents) $adjacents = 1;
    $limit = $pageSize;
    $totalItems = $total;
    if(!$pageParam) $pageParam = 'page';


    if(isset($queryParams[$pageParam])) {
        $currentPage = $queryParams[$pageParam];
        unset($queryParams[$pageParam]);
    }else{
        $currentPage = 1;
    }
    $targetPage .= '?' . http_build_query($queryParams);
    $pageString = $queryParams ? '&page=' : 'page=';
    //other vars
    $prev = $currentPage - 1;									//previous page is page - 1
    $next = $currentPage + 1;									//next page is page + 1
    $lastPage = ceil($totalItems / $limit);				//lastpage is = total items / items per page, rounded up.
    $lpm1 = $lastPage - 1;								//last page minus 1

    /*
		Now we apply our rules and draw the pagination object.
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
    $pagination = '';
    if($lastPage > 1)
    {
        $pagination .= '<ul class="pagination">';

        //previous button
        if ($currentPage > 1)
            $pagination .= '<li class="paginate_button previous"><a href="' . $targetPage . $pageString . $prev . '">«</a></li>';
        else
            $pagination .= '<li class="paginate_button previous disabled"><a href="#">«</a></li>';

        //pages
        if ($lastPage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
        {
            for ($counter = 1; $counter <= $lastPage; $counter++)
            {
                if ($counter == $currentPage)
                    $pagination .= '<li class="paginate_button active"><a href="#">'.$counter.'</a></li>';
                else
                    $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $counter . '">'.$counter.'</a></li>';
            }
        }
        elseif($lastPage >= 7 + ($adjacents * 2))	//enough pages to hide some
        {
            //close to beginning; only hide later pages
            if($currentPage < 1 + ($adjacents * 3))
            {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if ($counter == $currentPage)
                        $pagination .= '<li class="paginate_button active"><a href="#">'.$counter.'</a></li>';
                    else
                        $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $counter . '">'.$counter.'</a></li>';
                }
                $pagination .= '<li class="paginate_button"><span class="elipses">...</span></li>';
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $lpm1 . '">'.$lpm1.'</a></li>';
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $lastPage . '">'.$lastPage.'</a></li>';
            }
            //in middle; hide some front and some back
            elseif($lastPage - ($adjacents * 2) > $currentPage && $currentPage > ($adjacents * 2))
            {
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . '1">1</a></li>';
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . '2">2</a></li>';
                $pagination .= '<li class="paginate_button"><span class="elipses">...</span></li>';
                for ($counter = $currentPage - $adjacents; $counter <= $currentPage + $adjacents; $counter++)
                {
                    if ($counter == $currentPage)
                        $pagination .= '<li class="paginate_button active"><a href="#">'.$counter.'</a></li>';
                    else
                        $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $counter . '">'.$counter.'</a></li>';
                }
                $pagination .= '<li class="paginate_button"><span class="elipses">...</span></li>';
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $lpm1 . '">'.$lpm1.'</a></li>';
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $lastPage . '">'.$lastPage.'</a></li>';
            }
            //close to end; only hide early pages
            else
            {
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . '1">1</a></li>';
                $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . '2">2</a></li>';
                $pagination .= '<li class="paginate_button"><span class="elipses">...</span></li>';
                for ($counter = $lastPage - (1 + ($adjacents * 3)); $counter <= $lastPage; $counter++)
                {
                    if ($counter == $currentPage)
                        $pagination .= '<li class="paginate_button active"><a href="#">'.$counter.'</a></li>';
                    else
                        $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $counter . '">'.$counter.'</a></li>';
                }
            }
        }

        //next button
        if ($currentPage < $counter - 1)
            $pagination .= '<li class="paginate_button"><a href="' . $targetPage . $pageString . $next . '">»</a></li>';
        else
            $pagination .= '<li class="paginate_button disabled">»</li>';
        $pagination .= "</ul>";
    }

    return $pagination;

}
