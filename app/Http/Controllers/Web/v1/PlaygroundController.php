<?php

namespace App\Http\Controllers\Web\v1;

use App\Helpers\ApiResponseHandler;
use App\Helpers\AppException;
use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaygroundController extends Controller
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


// Example Usage:
            $n = 4;
            $firstRow = 2;
            $firstCol = 1;
            return self::solveNQueens($n, $firstRow, $firstCol);
        } catch (\Exception $e) {
//            AppException::log($e);
//            return ApiResponseHandler::failure(__('messages.general.failed'), $e->getMessage());
        }
    }


    public function isSafe($board, $row, $col, $n)
    {
        // Check if a queen can be placed on $board[$row][$col]
        // Check this row on left side
        for ($i = 0; $i < $col; $i++) {
            if ($board[$row][$i] == 1) {
                return false;
            }
        }
        // Check upper diagonal on left side
        for ($i = $row, $j = $col; $i >= 0 && $j >= 0; $i--, $j--) {
            if ($board[$i][$j] == 1) {
                return false;
            }
        }
        // Check lower diagonal on left side
        for ($i = $row, $j = $col; $i < $n && $j >= 0; $i++, $j--) {
            if ($board[$i][$j] == 1) {
                return false;
            }
        }
        return true;
    }

    public function solveNQueensUtil($board, $col, $n, $firstRow, $firstCol)
    {
        if ($col >= $n) {
            return true;
        }
        for ($i = 0; $i < $n; $i++) {
            if (self::isSafe($board, $i, $col, $n)) {
                if ($i == $firstRow && $col == $firstCol) {
                    continue;
                }
                $board[$i][$col] = 1;
                if (self::solveNQueensUtil($board, $col + 1, $n, $firstRow, $firstCol)) {
                    return true;
                }
                $board[$i][$col] = 0;
            }
        }
        return false;
    }

    public function solveNQueens($n, $firstRow, $firstCol)
    {
        $board = array_fill(0, $n, array_fill(0, $n, 0));
        $board[$firstRow][$firstCol] = 1;
        if (!self::solveNQueensUtil($board, 0, $n, $firstRow, $firstCol)) {
            echo "Solution does not exist";
            return false;
        }
        echo "One possible solution is: \n";
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                echo $board[$i][$j] . " ";
            }
            echo "\n";
        }
        return true;
    }
}
