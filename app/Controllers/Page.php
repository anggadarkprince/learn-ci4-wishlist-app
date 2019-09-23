<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Page extends BaseController
{
    /**
     * Show static page.
     *
     * @param $page
     * @return string
     */
    public function index($page)
    {
        if (!is_file(APPPATH . '/Views/static/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }

        return view('static/' . $page);
    }

}
