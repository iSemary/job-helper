<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GPT {
    private $token;
    private $model = "text-davinci-003";
    private $maxTokens = 1000;
    private $temperature = 0.7;

    const END_POINT = "https://api.openai.com/v1/";

    /**
     * The function is a constructor that takes a string parameter and assigns it to the class property
     * "token".
     * 
     * @param string token The "token" parameter is a string that represents a token. It is passed to the
     * constructor of a class.
     */
    public function __construct(string $token) {
        $this->token = $token;
    }

    /**
     * The function "returnCompletions" takes a prompt as input and returns an array of completions based
     * on the prompt.
     * 
     * @param string prompt The "prompt" parameter is a string that represents the input prompt or starting
     * point for the completion. It is the text that you want to provide to the language model to generate
     * a completion or continuation.
     * 
     * @return array An array is being returned.
     */
    public function returnCompletions(string $prompt): array {
        $data = [];
        $data['model'] = $this->model;
        $data['prompt'] = $prompt;
        $data['max_tokens'] = $this->maxTokens;
        $data['temperature'] = $this->temperature;

        return $this->call($data);
    }

    /**
     * The function makes a POST request to an API endpoint with authorization headers and returns the
     * response data along with a status code.
     * 
     * @param array data The `` parameter is an array that contains the data to be sent in the HTTP
     * POST request to the specified endpoint. The specific structure and content of the `` array
     * would depend on the requirements of the API you are working with.
     * 
     * @return array an array with two keys: 'status' and 'data'. The value of 'status' is either 200 or
     * 400, depending on the success of the HTTP request. The value of 'data' is the JSON response from the
     * HTTP request if it was successful, or null if it was not successful.
     */
    private function call(array $data): array {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post(self::END_POINT . 'completions', $data);

        if ($response->successful()) {
            $jsonResponse = $response->json();
            $formattedResponse = $this->formattedResponse($jsonResponse);
            return [
                'status' => 200,
                'data' => $formattedResponse
            ];
        } else {
            return [
                'status' => 400,
                'data' => $response->json(),
            ];
        }
    }


    private function formattedResponse($jsonResponse):array {
        $data = [];
        $data['id'] = $jsonResponse['id'];
        $data['usage'] = $jsonResponse['usage'];
        $data['response'] = $jsonResponse['choices'][0]['text'];

        return $data;
    }
}
