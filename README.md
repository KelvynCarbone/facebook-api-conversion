# facebook-api-conversion
Service Class to make integration with Facebook API Conversation

I create this service working with GuzzleHttp & Laravel Framework. I recommend to you use this service with Job (Queue) in your application.

## If you use Laravel Framework you follow this steps:
- Create a directory Services in app (app/Services).
- Download this class and put in app/Services.
- Run composer dumpautoload

#### In your .env file put this variables:
```bash
FB_PIXEL_ID = "{your_facebook_pixel_id}"
FB_TEST_CODE = "{your_facebook_test_code}" //see facebook test code section
FB_ACCESS_TOKEN = "{your_facebook_api_conversion}"
```

## Example 1 of use:

```php
<?php
namespace App\Http\Controllers;
use App\Services\FacebookApiService;
class TestController extends Controller
{
    public function __construct(FacebookApiService $fbApiService)
    {
        dd($fbApiService->test());
    }
}
```

## Example 2 of use:

```php
<?php
namespace App\Http\Controllers;
use App\Services\FacebookApiService;
use Carbon\Carbon;

class TestController extends Controller
{
    public function __construct(FacebookApiService $fbApiService)
    {
        dd($fbApiService->request("POST","/events",[
            'data' => [
                0 => [
                    'event_name' => 'Purchase',
                    'event_time' => Carbon::now()->timestamp,
                    'user_data' => [
                        'client_ip_address' => $_SERVER['REMOTE_ADDR'],
                        'client_user_agent' => $_SERVER['HTTP_USER_AGENT']
                    ],
                    'custom_data' => [
                        'currency' => 'BRL',
                        'value' => 50,
                    ],
                    'event_source_url' => 'https://kelvyncarbone.com.br',
                    'action_source' => 'website',
                ],
            ],
            'test_event_code' => env("FB_TEST_CODE"),
        ]));
    }
}
```
![image](https://user-images.githubusercontent.com/5288360/121966848-b4853b80-cd45-11eb-9dfa-363315066a6b.png)

After your tests ok, remove the line **'test_event_code' => xxxxxx** of yours requests to make this work in production

# How to generate your Facebook Conversion API
- Start creating your Conversion API, see: [https://developers.facebook.com/docs/marketing-api/conversions-api/get-started] 
- Generate your API Conversion Access Token ![step-1](https://user-images.githubusercontent.com/5288360/121966455-15f8da80-cd45-11eb-97a3-b62d668f4618.png)
- Get your test code: ![step-2](https://user-images.githubusercontent.com/5288360/121966439-0e393600-cd45-11eb-8b5d-2afb945ab43c.png)
- Run Example 1 and Example 2
