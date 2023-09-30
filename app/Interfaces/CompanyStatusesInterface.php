<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

class CompanyStatusesInterface {
    const BACKLOG = ['id' => 0, "title" => "Backlog", "hex" => "#FF5733"];
    const SENT_APPLY = ['id' => 1, "title" => "Sent Apply", "hex" => "#33FF57"];
    const SENT_REMINDER = ['id' => 2, "title" => "Sent Reminder", "hex" => "#5733FF"];
    const NO_RESPONSE = ['id' => 3, "title" => "No Response", "hex" => "#FF3357"];
    const PENDING_TASK = ['id' => 4, "title" => "Pending Task", "hex" => "#57FF33"];
    const FIRST_INTERVIEW = ['id' => 5, "title" => "First Interview", "hex" => "#3357FF"];
    const SECOND_INTERVIEW = ['id' => 6, "title" => "Second Interview", "hex" => "#FF5733"];
    const FINAL_INTERVIEW = ['id' => 7, "title" => "Final Interview", "hex" => "#33FF57"];
    const REJECTION = ['id' => 8, "title" => "Rejection", "hex" => "#5733FF"];

    public static function returnStatuesAsJson(): JsonResponse {
        $data = [];

        // Collect an array of statues constants
        $constants = [
            self::BACKLOG,
            self::SENT_APPLY,
            self::SENT_REMINDER,
            self::NO_RESPONSE,
            self::PENDING_TASK,
            self::FIRST_INTERVIEW,
            self::SECOND_INTERVIEW,
            self::FINAL_INTERVIEW,
            self::REJECTION
        ];

        foreach ($constants as $constant) {
            $data[] = [
                'text' => $constant['title'],
                'id' => $constant['id'],
                'dataField' => self::returnStateStyle($constant['title'])
            ];
        }

        return response()->json(['data' => json_encode($data, JSON_UNESCAPED_SLASHES)], 200);
    }

    public static function returnStateStyle($title) {
        return strtolower(str_replace(' ', '_', $title));
    }

    public static function getDetails($id) {
        // Collect an array of statues constants
        $constants = [
            self::BACKLOG,
            self::SENT_APPLY,
            self::SENT_REMINDER,
            self::NO_RESPONSE,
            self::PENDING_TASK,
            self::FIRST_INTERVIEW,
            self::SECOND_INTERVIEW,
            self::FINAL_INTERVIEW,
            self::REJECTION
        ];

        foreach ($constants as $constant) {
            if ($constant['id'] == $id) {
                return [
                    'id' => $constant['id'],
                    'title' => $constant['title'],
                    'hex' => $constant['hex'],
                    'state' => self::returnStateStyle($constant['title'])
                ];
                exit();
            }
        }

        return null;
    }
}
