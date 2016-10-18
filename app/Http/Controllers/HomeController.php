<?php

namespace App\Http\Controllers;

use App\Appeal;
use App\Board;
use App\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $data['appeals'] = Appeal::with(['event', 'board'])->get();
        return view('home', $data);
    }

    public function create()
    {
        return view('form');
    }

    public function show($id)
    {
        $data['appeal'] = Appeal::with(['event', 'board'])->find($id);
        return view('show', $data);

    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->event_name = $request->get('event_name');
        $event->session = $request->get('event_session');
        $event->level = $request->get('event_level');
        $event->nbo = $request->get('nbo');


        $board = new Board();
        $board->board_no = $request->get('board_no');
        $board->dealer = $request->get('dealer');
        $board->vul = $request->get('vul');
        $board->screen = (bool) $request->get('screen');
        $board->hand = $this->makeHand($request->get('deal'));
        $board->bidding = $this->cleanBidding($request->get('bidding'));
        $board->alerts = $this->removeWhiteSpace($request->get('alerts'));

        $appeal = new Appeal();
        $appeal->player_north = $request->get('player_north');
        $appeal->player_south = $request->get('player_south');
        $appeal->player_east = $request->get('player_east');
        $appeal->player_west = $request->get('player_west');
        $appeal->director = $request->get('director');
        $appeal->committee = $request->get('committee');
        $appeal->facts = $request->get('facts');
        $appeal->appeal_reason = $request->get('appeal_reason');
        $appeal->decision = $request->get('decision');
        $appeal->appeal_time = $request->get('date');

        $appeal->save();
        $appeal->event()->save($event);
        $appeal->board()->save($board);
    }

    // todo: refactor: move these out of the controller
    protected function makeHand($hand)
    {
        $ret = ['n' => '', 'w' => '', 'e' => '', 's' => ''];

        foreach($hand as $k => $seat){
            foreach ($seat as $suit) {
                $ret[$k] .= $this->sortHand($suit). '.';
            }
            $ret[$k] = substr($ret[$k], 0, -1);
        }

        return implode('|', $ret);
    }

    protected function sortHand($hand)
    {
        $p = [14 => 'A', 13=>'K', 12=>'Q', 11=>'J', 10=>'T'];
        $faces = $numbers = [];
        $arr = str_split(strtoupper($hand));
        foreach($arr as $k => $v){
            if(is_numeric($v)){
                $numbers[] = $v;
            }else{
                $faces[array_search($v, $p)] = $v;
            }
        }

        krsort($faces);
        rsort($numbers);
        return implode('', $faces) . implode('', $numbers);
    }

    protected function cleanBidding($biddingData)
    {
        return self::removeWhiteSpace($biddingData);
    }

    protected static function removeWhiteSpace($str, $delimiter='_')
    {
        $str = preg_replace(
            "/(\t|\n|\v|\f|\r| |\xC2\x85|\xc2\xa0|\xe1\xa0\x8e|\xe2\x80[\x80-\x8D]|\xe2\x80\xa8|\xe2\x80\xa9|\xe2\x80\xaF|\xe2\x81\x9f|\xe2\x81\xa0|\xe3\x80\x80|\xef\xbb\xbf)+/",
            $delimiter,
            $str
        );

        return $str;
    }
}
