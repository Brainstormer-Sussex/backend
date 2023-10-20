<?php

namespace App\Http\Controllers\Web\v1;

use App\Helpers\ApiResponseHandler;
use App\Helpers\AppException;
use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const NumberOfQueen = 8;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            //        $chess = [[0,0,0,0,0],[0,0,0,0,0],[0,0,0,1,0],[0,0,0,0,0],[0,0,0,0,0]];
            $chess = self::generateChessBoard();

            if (self::placeQueens($chess, 0) == false){
                $message = 'Dead end. Unable to generate possible combinations. Do try again with other combination.';
                return json_encode(['result' => false, 'error_msg' => $message]);
            }

            $chessBoard = self::printChessBoard($chess);
//            echo "<pre/>";
            return ApiResponseHandler::success($chessBoard['board'], 'Success');
//            echo "<br/>";
//            echo "<br/>";
//            echo "<br/>";
//            return $chessBoard['placements'];
        } catch (\Exception $e) {
//            AppException::log($e);
            return ApiResponseHandler::failure(__('messages.general.failed'), $e->getMessage());
        }
    }

    //Store the queens in particular place
    public function placeQueens(&$chess, $col)
    {
        //when N queens are placed successfully
        if ($col >= self::NumberOfQueen)
            return true;

        //for each row, check if storing the queen is possible
        for ($i = 0; $i < self::NumberOfQueen; $i++) {//for each row, check placing of queen is possible or not
            if (self::checkForPossibleCombinations($chess, $i, $col)) {
                //if possible, place the queen at place (i, col)
                $chess[$i][$col] = 1;//if validate, place the queen at place (i, col)

                //  if solveNQueen(board, col+1) = true, then; return true;  Go for the other columns recursively
                if (self::placeQueens($chess, $col + 1))
                    return true;
                //otherwise remove queen from place (i, col) from board.
                $chess[$i][$col] = 0;
            }
        }

        return false;     //when no possible order is found
    }

    private function generateChessBoard() {
        $arr = [];
        for ($i=0; $i < self::NumberOfQueen; ++$i){
            $arr[] = array_fill(0, self::NumberOfQueen, 0);
        }
        return $arr;
    }

    public function printChessBoard(&$chess)
    {
        //Print the final answer
//        for ($i = 0; $i < self::NumberOfQueen; ++$i) {
//            for ($j = 0; $j < self::NumberOfQueen; ++$j)
//                echo $chess[$i][$j] . " ";
//
//            echo "<br/>";
//        }
        $board = [];
        $placement = '';
        //Print the final answer
        for ($i = 0; $i < self::NumberOfQueen; ++$i) {
            for ($j = 0; $j < self::NumberOfQueen; ++$j){
                $board[$i][$j] = $chess[$i][$j];
                $placement .= $chess[$i][$j] . " ";
            }

            $placement .= "<br/>";
        }
        return [
            'board' => $board,
            'placements' => $placement
        ];
    }

    public function checkForPossibleCombinations(&$chess, $row, $col)
    {
        //Navigate through tree and check conditions

//        Begin
//           if there is a queen at the left of current col, then
//              return false
//           if there is a queen at the left upper diagonal, then
//              return false
//           if there is a queen at the left lower diagonal, then
//              return false;
//           return true //otherwise it is valid place
//        End

        $i;
        $j;
        //check if any queen in the left
        for ($i = 0; $i < $col; ++$i)
            if ($chess[$row][$i])
                return false;
        //check if any queen in the left upper diagonal
        for ($i = $row, $j = $col; $i >= 0 && $j >= 0; --$i, --$j)
            if ($chess[$i][$j])
                return false;
        //check if any queen in the left lower diagonal
        for ($i = $row, $j = $col; $j >= 0 && $i < self::NumberOfQueen; ++$i, --$j)
            if ($chess[$i][$j])
                return false;

        return true;
    }

}
