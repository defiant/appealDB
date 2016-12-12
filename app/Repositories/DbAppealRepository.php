<?php namespace App\Repositories;

use App\Appeal;
use App\Board;
use App\Event;
use App\Helpers\HandHelpers;

class DbAppealRepository implements AppealRepositoryInterface
{
    public function all()
    {
        return Appeal::with(['event', 'board'])->get();
    }

    public function find($id)
    {
        return Appeal::with(['event', 'board'])->findOrFail($id);
    }

    public function create($request)
    {
        $helper = new HandHelpers();

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
        $board->hand = $helper->makeHand($request->get('deal'));
        $board->bidding = $helper->cleanEntry($request->get('bidding'));
        $board->alerts = $request->get('alert', null) ? json_encode($request->get('alert')) : null;
        $board->lead = $request->get('lead', null);
        $board->table_result = $request->get('table_result', null);
        $board->declarer = $request->get('declarer', null);

        $appeal = new Appeal();
        $appeal->category_id = $request->get('appeal_category');
        $appeal->user_id = \Auth::user()->id;
        $appeal->casebook = $request->get('casebook');
        $appeal->player_north = $request->get('player_north');
        $appeal->player_south = $request->get('player_south');
        $appeal->player_east = $request->get('player_east');
        $appeal->player_west = $request->get('player_west');
        $appeal->director = $request->get('director');
        $appeal->committee = $request->get('committee');
        $appeal->side_appealing = $request->get('side_appealing') ?? null;
        $appeal->facts = $helper->convertText($request->get('facts'));
        $appeal->ruling = $helper->convertText($request->get('ruling'));
        $appeal->appeal_reason = $helper->convertText($request->get('appeal_reason'));
        $appeal->decision = $helper->convertText($request->get('decision'));
        $appeal->laws = $request->get('laws');
        $appeal->appeal_time = $request->get('date');
        $appeal->scoring_id = $request->get('scoring');

        if($request->get('result_stands', false)){
            $appeal->table_result_stands = true;
            $appeal->td_ruling = null;
            /*$board->table_result
                ? $helper->resultToHuman($board->table_result) . ', ' . $helper->getScore($board->table_result, $board->declarer)
                : null;*/
        }else{
            $appeal->table_result_stands = false;
            $appeal->td_ruling = null;
        }

        if($request->get('ruling_upheld', true)){
            $appeal->ruling_upheld = true;
            $appeal->ac_ruling = $appeal->td_ruling;
        }else{
            $appeal->ruling_upheld = false;
            $appeal->ac_ruling = $request->get('ac_ruling');
        }

        $appeal->save();
        $appeal->event()->save($event);
        $appeal->board()->save($board);

        return $appeal;
    }
}