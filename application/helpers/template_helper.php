<?php
defined('BASEPATH') OR exit('No direct script access allowed');
defined('PUBLICPATH') OR exit('No direct script access allowed');
if ( ! function_exists('asset'))
{
    function asset($asset_path) {
        return PUBLICPATH . 'assets/' . $asset_path;
    }
}