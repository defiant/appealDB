<?php namespace app\Helpers;

/**
 * Class HandHelpers
 * This class contains a few of the helpers method for interacting with hands and contracts
 * @package app\Helpers
 */
/**
 * Class HandHelpers
 * @package app\Helpers
 */
class HandHelpers
{

    /**
     * Takes an array of four hands each with an array of four suits
     * and converts them to a delimited string.
     * @param array $hand
     * @return string
     */
    public function makeHand(array $hand)
    {
        $ret = ['n' => '', 'w' => '', 'e' => '', 's' => ''];

        foreach($hand as $k => $seat){
            foreach ($seat as $suit) {
                $ret[$k] .= $this->sortSuit($suit). '.';
            }
            $ret[$k] = substr($ret[$k], 0, -1);
        }

        return implode('|', $ret);
    }

    /**
     * Sorts a hand from A to 2
     * @param string $suit
     * @return string
     */
    public function sortSuit($suit)
    {
        $p = [14 => 'A', 13=>'K', 12=>'Q', 11=>'J', 10=>'T'];
        $faces = $numbers = [];
        $suit = self::removeWhiteSpace($suit, '');
        $arr = str_split(strtoupper($suit));
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

    /**
     * Cleans the data by removing white space and converting suits to UTF-8 suit symbols.
     * @param $data
     * @return array|mixed
     */
    public function cleanEntry($data)
    {
        if(is_array($data)){
            $ret = [];
            foreach ($data as $k => $v) {
                $v = str_replace(config('bridge.suits'), config('bridge.symbols'), $v);
                $ret[$k] = $v;
            }
            return $ret;
        }else{
            $data = str_replace(config('bridge.suits'), config('bridge.symbols'), $data);
            return self::removeWhiteSpace($data, ' ');
        }
    }


    /**
     * convert the BBO style suit markups to UTF-8 suit symbols;
     * @param $text
     * @return mixed
     */
    public function convertText($text)
    {
        $searchUpper = ['!S', '!H', '!D', '!C'];
        $searchLower = ['!s', '!h', '!d', '!c'];
        $text = str_replace($searchUpper, config('bridge.symbols'), $text);
        return str_replace($searchLower, config('bridge.symbols'), $text);
    }

    /**
     * Convert the given delimited string to an array
     * This is the inverse makeHand function
     * @param string $str
     * @return array
     */
    public function handToArray($str)
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


    /**
     * @param string $auction
     * @param int $dealer
     * @return array
     */
    public function  getAuction(string $auction, int $dealer)
    {
        if(!$auction) return [];
        // offset assuming west is on left
        $offset = $dealer > 2 ? 0 : $dealer+1;
        return array_merge(array_fill(0, $offset , ''), explode(' ', $auction));
    }

    /**
     * Removes the whitespace characters from the given string and replaces them with the $delimiter
     * @param $str
     * @param string $delimiter
     * @return mixed
     */
    public static function removeWhiteSpace($str, $delimiter=' ')
    {
        $str = preg_replace(
            "/(\t|\n|\v|\f|\r| |\xC2\x85|\xc2\xa0|\xe1\xa0\x8e|\xe2\x80[\x80-\x8D]|\xe2\x80\xa8|\xe2\x80\xa9|\xe2\x80\xaF|\xe2\x81\x9f|\xe2\x81\xa0|\xe3\x80\x80|\xef\xbb\xbf)+/",
            $delimiter,
            $str
        );

        return $str;
    }

    /**
     * Gets the score obtained by the given string table result
     * @param $contract
     * @param bool $vul
     * @return int
     */
    public static function getScore($contract, $vul = false)
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

                if($tricksTaken === 12 && $tricksRequired == 12){
                    if($vul){
                        $score += 750;
                    }else{
                        $score += 500;
                    }
                }elseif($tricksTaken === 13 && $tricksRequired == 13){
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

    public function score($tableResult, $declarer, $boardNo)
    {
        if($tableResult && $declarer){
            return $this->getScore($tableResult, $this->isVul($boardNo, $declarer));
        }else{
            return null;
        }
        // $data['appeal']->board->table_result != null && $data['appeal']->board->declarer != null ? $helper->getScore($data['appeal']->board->table_result, $helper->isVul($data['appeal']->board->board_no, $data['appeal']->board->declarer)) : null;
    }

    /**
     * Return a human readable representation of the given string contract
     * @param $contract
     * @return string
     */
    public function resultToHuman($contract)
    {
        if(!$contract) return '';

        $contract = strtoupper($contract);

        if($contract == 'P'){
            return 'Passed out';
        }

        $suits = ['C' => 'Clubs', 'D' => 'Diamonds', 'H' => 'Hearts', 'S' => 'Spades', 'N' => 'NT'];

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
            $result = 'made plus '.substr($contract, $x+1, 1);
        }elseif($x = strpos($contract, '-')){
            $result = 'down '.substr($contract, $x+1, 1);
        }elseif($x = strpos($contract, '=')){
            $result = 'just made';
        }

        return "$level {$suits[$suit]} $penalty, $result";
    }

    public function getVul($board){
        $vul = [
            'none','ns','ew','all',
            'ns','ew','all','none',
            'ew','all','none','ns',
            'all','none','ns','ew',
        ];
        $x = $board % 16;

        $x = $x ? $x-1 : 0;

        return $vul[$x];
    }

    public function isVul($board, $declarer)
    {
        $vul = $this->getVul($board);

        if($vul == 'none'){
            return false;
        }

        if($vul == 'all'){
            return true;
        }

        return strpos($vul, strtolower($declarer)) !== false;
    }
}