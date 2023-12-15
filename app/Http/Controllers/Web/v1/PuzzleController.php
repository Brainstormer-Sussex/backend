<?php

namespace App\Http\Controllers\Web\v1;

use App\Helpers\ApiResponseHandler;
use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PuzzleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $requestData = $request->all();
            $validator = Validator::make($request->all(), [
                'dimensions' => 'required',
                'position' => 'required|array',
                'position.row' => 'required',
                'position.col' => 'required',
            ]);

            if ($validator->fails()) {
                return ApiResponseHandler::validationError($validator->errors());
            }

            $n = $requestData['dimensions'];
            $row = $requestData['position']['row'];
            $col = $requestData['position']['col'];


            $chessboard = self::generateChessBoard($n);

            $eightQueens = new self();
            $solvedPuzzle = $eightQueens->solveNQueens($chessboard);
            if (empty($solvedPuzzle)) {
                return ApiResponseHandler::failure('No possible combinations found!! Try again with a different combination');
            }

            $solutionsForDefinedRowAndCol = self::hasDefinedSolutions($solvedPuzzle, $row, $col);
            $result = [
                'solutions' => $solutionsForDefinedRowAndCol,
                'allSolutions' => $solvedPuzzle
            ];
            if (empty($solutionsForDefinedRowAndCol)) {
                if (!empty($solvedPuzzle) && $solvedPuzzle != [[]]) {
                    $errMsg = "Possible combinations exists. But not for this combination try again with a different combination instead.";
                } else {
                    $result = [];
                    $errMsg = "No possible combinations found!! Try again with a different combination";
                }
                return ApiResponseHandler::failure($errMsg, '', $result);
            }
            return ApiResponseHandler::success($result, 'Success');
        } catch (\Exception $e) {
            return ApiResponseHandler::failure(__('messages.general.failed'), $e->getMessage());
        }
    }

    private function generateChessBoard($n)
    {
        return array_fill(0, $n, array_fill(0, $n, 0));
    }

    private function solveNQueens($chessboard)
    {
        $result = array();
        $this->placeQueen($chessboard, 0, $result);
        return $result;
    }

    private function placeQueen(&$chessboard, $colIndex, &$result)
    {
        if ($colIndex == count($chessboard)) {
            // If the current column index is equal to the length of the chessboard, it means all queens have been successfully placed
            $this->addResult($chessboard, $result);
        } else {
            for ($rowIndex = 0; $rowIndex < count($chessboard); $rowIndex++) {
                if ($this->isPlaceValid($chessboard, $rowIndex, $colIndex)) {
                    $chessboard[$rowIndex][$colIndex] = 1;
                    $this->placeQueen($chessboard, $colIndex + 1, $result);
                    $chessboard[$rowIndex][$colIndex] = 0;
                }
            }
        }
    }

    private function isPlaceValid($chessboard, $rowIndex, $colIndex)
    {
        for ($i = 0; $i < $colIndex; $i++) {
            // check for queen is same col
            if ($chessboard[$rowIndex][$i] == 1)
                return false;
        }
        for ($i = $rowIndex, $j = $colIndex; $i >= 0 && $j >= 0; $i--, $j--) {
            // check for queen in upper-right diagonal
            if ($chessboard[$i][$j] == 1)
                return false;
        }
        for ($i = $rowIndex, $j = $colIndex; $i < count($chessboard) && $j >= 0; $i++, $j--) {
            // check for queen in upper-left diagonal
            if ($chessboard[$i][$j] == 1)
                return false;
        }
        return true;
    }

    private function addResult(&$chessboard, &$result)
    {
        $str = array();
        for ($i = 0; $i < count($chessboard); $i++) {
            for ($j = 0; $j < count($chessboard); $j++) {
                $str[$i][$j] = ($chessboard[$i][$j] == 1) ? "1 " : "0 ";
            }
        }
        $result[] = $str;
    }

    private function hasDefinedSolutions($solvedPuzzle, $row, $col)
    {
        $result = [];
        foreach ($solvedPuzzle as $object) {
            if (!empty($object) && array_key_exists($col, $object[$row])) {
                if ($object[$row][$col] == 1) {
                    $result[] = $object;
                    continue;
                }
            }
        }
        unset($object);
        $obj = $result ?? false;
        return $obj;
    }

}

