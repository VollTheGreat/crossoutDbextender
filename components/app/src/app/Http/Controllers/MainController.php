<?php

namespace App\Http\Controllers;

use App\CrossoutDB\CrossoutDbManager;

class MainController extends Controller
{
    /**
     * @var CrossoutDbManager
     */
    private $crossoutDbManager;

    /**
     * MainController constructor.
     * @param CrossoutDbManager $crossoutDbManager
     */
    public function __construct(CrossoutDbManager $crossoutDbManager)
    {
        $this->crossoutDbManager = $crossoutDbManager;
    }

    /**
     * GET /
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('welcome');
    }

    /**
     * GET /api/stats
     *
     * @return array
     */
    public function stats()
    {
        return $this->epics();
    }

    /**
     * GET /api/epics
     *
     * @return array
     */
    public function epics()
    {
        return $this->crossoutDbManager->getFormattedData('Epic', 'Rare');
    }

    /**
     * GET /api/stats
     *
     * @return array
     */
    public function rares()
    {
        return $this->crossoutDbManager->getFormattedData('Rare', 'Common');
    }
}
