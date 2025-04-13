<?php

namespace App\Http\Controllers;

use App\Repositories\{
    UserRepository
};

class DashboardController extends Controller
{
    /**
     *
     * @var UserRepository
     */
    protected $user;

    public function __construct(
        UserRepository $user
    ) {
        $this->user = $user;
    }

    /**
     * show the index of page
     *
     * @return  mixed
     */
    public function index()
    {
        return view('dashboard');
    }
}
