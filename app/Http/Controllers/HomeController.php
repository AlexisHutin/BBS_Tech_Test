<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Services\InstagramService;
use App\Http\Controllers\Controller;

/**
 * Home page controller
 */
class HomeController extends Controller
{
    /**
     * Index page controller
     *
     * @return View
     */
    public function index(): View
    {
        try {
            $userInfo = InstagramService::getUserInfo();
            $pictures = InstagramService::getPicturesFromUser($userInfo['user_id'], 10);
        } catch (\Exception $e) {
            $errors = $e->getMessage();
        }
        
        return view('home', [
            'userInfo' => $userInfo ?? [],
            'pictures' => $pictures ?? [],
            'errors' => $errors ?? null
        ]);
    }
}
