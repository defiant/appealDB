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
        $data['appeal'] = Appeal::with(['event', 'board'])->findOrFail($id);
        $data['hands'] = $this->handToArray($data['appeal']->board->hand);
        $data['auction'] = array_merge(array_fill(0, $data['appeal']->board->dealer , ''), explode(' ' ,$data['appeal']->board->bidding));
        $alerts = explode('!', $data['appeal']->board->alerts);
        array_shift($alerts);
        $data['alerts'] = $alerts;
        $data['row'] = 0;

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
        $board->alerts = $this->removeWhiteSpace($request->get('alerts'), ' ');
        $board->lead = $request->get('lead', null);
        $board->table_result = $request->get('table_result', null);

        $appeal = new Appeal();
        $appeal->category_id = $request->get('appeal_category');
        $appeal->user_id = Auth::user()->id;
        $appeal->player_north = $request->get('player_north');
        $appeal->player_south = $request->get('player_south');
        $appeal->player_east = $request->get('player_east');
        $appeal->player_west = $request->get('player_west');
        $appeal->director = $request->get('director');
        $appeal->committee = $request->get('committee');
        $appeal->facts = $request->get('facts');
        $appeal->ruling = $request->get('ruling');
        $appeal->appeal_reason = $request->get('appeal_reason');
        $appeal->decision = $request->get('decision');
        $appeal->laws = $request->get('laws');
        $appeal->appeal_time = $request->get('date');

        $appeal->save();
        $appeal->event()->save($event);
        $appeal->board()->save($board);

        return redirect('/'.$appeal->id);
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
        $hand = self::removeWhiteSpace($hand, '');
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
        return self::removeWhiteSpace($biddingData, ' ');
    }

    protected function handToArray($str)
    {
        $seats = ['n', 'w', 'e', 's'];
        $o = 0;
        $ret = [];

        foreach (explode('|', $str) as $item) {
            $seat = [];
            foreach (explode('.', $item) as $i) {
                $seat[] = $i;
            }
            $ret[$seats[$o++]] = $seat;
        }

        return $ret;
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

    protected static function getScore($contract, $vul = false)
    {
        $contract = strtoupper($contract);
        $score = 0;

        if($contract == 'P'){
            return $score;
        }

        $dbl = $rdbl = false;
        $minors = ['C', 'D'];

        $tricksRequired = 6 + substr($contract, 0, 1);

        $level = substr($contract, 0, 1);
        $trump = substr($contract, 1, 1);


        foreach(['=', '+', '-'] as $sign){
            $pos = strpos($contract, $sign);
            if($pos){
                $made = $sign == '=' ? 0 : substr($contract, $pos);
            }
        }

        if(strpos($contract, 'XX')){
            $rdbl = true;
        }elseif(strpos($contract, 'X')){
            $dbl = true;
        }

        $tricksTaken = $tricksRequired + $made;

        if($tricksRequired <= $tricksTaken){
            if(in_array($trump, $minors)){
                $score += $level * 20;
            }else{
                $score += $level * 30;
                if($trump == 'N'){
                    $score += 10;  // For NT, add a 10 point bonus.
                }
            }

            if($dbl){
                $score *= 2;
            }elseif($rdbl){
                $score *= 4;
            }

            if($score >= 100){
                if($vul){
                    $score += 500;
                }else{
                    $score += 300;
                }

                if($tricksTaken === 12){
                    if($vul){
                        $score += 750;
                    }else{
                        $score += 500;
                    }
                }elseif($tricksTaken === 13){
                    if($vul){
                        $score += 1500;
                    }else{
                        $score += 1000;
                    }
                }
            }else{
                $score += 50;
            }

            if($dbl){
                $score += 50;
            }elseif($rdbl){
                $score += 100;
            }

            // Add over trick scores
            $overTricks = $tricksTaken - $tricksRequired;
            if($dbl){
                if($vul){
                    $score += $overTricks * 200;
                }else{
                    $score += $overTricks * 100;
                }
            }elseif($rdbl){
                if($vul){
                    $score += $overTricks * 400;
                }else{
                    $score += $overTricks * 200;
                }
            }else{
                if(in_array($trump, $minors)){
                    $score += $overTricks * 20;
                }else{
                    $score += $overTricks * 30;
                }
            }
        }else{

            $underTricks = $tricksRequired - $tricksTaken;
            if($rdbl){
                if($vul) {
                    $score -= 400 + ($underTricks - 1) * 600;
                }else{
                    $score -= 200 + ($underTricks - 1) * 400;
                    if($underTricks > 3)
                        $score -= ($underTricks - 3) * 200;
                }
            }elseif($dbl){
                if($vul) {
                    $score -= 200 + ($underTricks - 1) * 300;
                }else{
                    $score -= 100 + ($underTricks - 1) * 200;
                    if($underTricks > 3)
                        $score -= ($underTricks - 3) * 100;
                }
            }else{
                if($vul){
                    $score -= $underTricks * 100;
                }else{
                    $score -= $underTricks * 50;
                }
            }
        }

        return $score;
    }

    public function resultToHuman($contract)
    {
        $contract = strtoupper($contract);

        if($contract == 'P'){
            return 'Passed out';
        }

        $suits = ['C' => 'Clubs', 'D' => 'Diamonds', 'H' => 'Hearts', 'S' => 'Spades', 'N' => 'No Trump'];

        $level = substr($contract, 0, 1);
        $suit = substr($contract, 1, 1);

        $penalty = '';
        if(substr($contract, 2, 1) == 'X'){
            $penalty = 'doubled';
            if(substr($contract, 3, 1) == 'X'){
                $penalty = 'redoubled';
            }
        }

        $result = '';
        if($x = strpos($contract, '+')){
            $result = "made plus ".substr($contract, $x+1, 1);
        }elseif($x = strpos($contract, '-')){
            $result = "down ".substr($contract, $x+1, 1);
        }elseif($x = strpos($contract, '=')){
            $result = 'just made';
        }

        return "$level {$suits[$suit]} $penalty, $result";
    }
}
