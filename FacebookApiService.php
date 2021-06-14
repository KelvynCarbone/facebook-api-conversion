<?php namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class FacebookApiService extends BaseService
{
    protected $api;
    protected $access_token;
    protected $pixel_id;
    protected $facebook_api_url;

    public function __construct($access_token = null,$pixel_id=null)
    {
        $this->access_token = isset($access_token) ? $access_token :env("FB_ACCESS_TOKEN");
        $this->pixel_id = isset($pixel_id) ? $pixel_id :env("FB_PIXEL_ID");

        if (is_null($this->access_token) || is_null($this->pixel_id)) {
            throw new Exception('Você precisa do access_token, app_pixel para utilizar a API de Conversão do Facebook.');
        }

        $this->facebook_api_url = env("FB_API_URL") ? env("FB_API_URL") : "https://graph.facebook.com/v11.0/".$this->pixel_id;
        $this->api = new Client([
            'verify' => false
        ]);
    }

    public function request($method, $path, $data = null)
    {
        try {
            $response = $this->api->request(
                $method,
                $this->facebook_api_url . $path,
                ['form_params' => array_merge($data,['access_token' => $this->access_token])]
            );

            $rt = json_decode((string)$response->getBody(), true);

            return [
                "data" => $rt,
                "status" => $response->getStatusCode()
            ];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new \Exception("Erro ao efetuar a request para o Facebook: " . $e->getMessage());
        }
    }

    public function test()
    {
        $test_code = env("FB_TEST_CODE") ? env("FB_TEST_CODE") : request()->get("test_code");
        if(!isset($test_code))
            throw new \Exception("Você precisa passar o código de teste de teste do facebook via url (?test_code=) ou pelo arquivo .env");

        return $this->request("POST","/events",
            [
                'data' => [
                    0 => [
                        'event_name' => 'TestKelvyn',
                        'event_time' => Carbon::now()->timestamp,
                        'user_data' => [
                            'client_ip_address' => $_SERVER['REMOTE_ADDR'],
                            'client_user_agent' => $_SERVER['HTTP_USER_AGENT']
                        ],
                        'custom_data' => [
                            'currency' => 'BRL',
                            'value' => 10,
                        ],
                        'event_source_url' => 'https://kelvyncarbone.com.br',
                        'action_source' => 'website',
                    ],
                ],
                'test_event_code' => $test_code,
            ]
        );
    }
}

