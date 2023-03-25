<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Services\InstagramService;
use App\Http\Controllers\Controller;

/**
 * Undocumented class
 */
class HomeController extends Controller
{
    /**
     * Undocumented function
     *
     * @return View
     */
    public function index(): View
    {
        $userInfo = InstagramService::getUserInfo();
        $picturesData = InstagramService::getPicturesFromUser($userInfo['user_id'], 5);

        return view('home', [
            'userInfo' => $userInfo,
            'pictures' => $picturesData['pictures'],
            'errors' => $picturesData['errors']
        ]);
    }
}
