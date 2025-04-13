<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function index(): View
    {
        return view('superadmin.dashboard');
    }
}
