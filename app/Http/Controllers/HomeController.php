<?php namespace App\Http\Controllers;

use App\Appeal;
use App\Board;
use App\Event;
use App\Http\Requests\AppealFormRequest;
use App\Helpers\HandHelpers;
use App\Repositories\AppealRepositoryInterface;

class HomeController extends Controller
{
    protected $appeal;

    public function __construct(AppealRepositoryInterface $appeal)
    {
        $this->appeal = $appeal;
    }

    public function index()
    {
        $data['appeals'] = $this->appeal->all();
        return view('home', $data);
    }

    public function create()
    {
        return view('form');
    }

    public function show($id)
    {
        $helper = new HandHelpers();
        $data['appeal'] = $this->appeal->find($id);
        $data['hands'] = $helper->handToArray($data['appeal']->board->hand);
        $data['auction'] = $helper->getAuction($data['appeal']->board->bidding, $data['appeal']->board->dealer);
        $data['alerts'] = json_decode($data['appeal']->board->alerts, true);
        $data['row'] = 0;

        return view('show', $data);

    }

    public function store(AppealFormRequest $request)
    {
        $appeal = $this->appeal->create($request);

        return redirect('/'.$appeal->id);
    }
}
