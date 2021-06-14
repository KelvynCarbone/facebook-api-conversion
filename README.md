# facebook-api-conversion
Class Service to make integration with Facebook API Conversation

I create this service working with GuzzleHttp & Laravel Framework. I recommend you to use this service with Job (Queue) in your application.

## If you use Laravel Framework you follow this steps:
- Create a directory Services in app (app/Services).
- Download this class and put in app/Services.
- Run composer dumpautoload


## Example of use:

#### In your .env file put this variables:
```bash
FB_PIXEL_ID = "{your_facebook_pixel_id}"
FB_TEST_CODE = "{your_facebook_test_code}" //see facebook test code section
FB_ACCESS_TOKEN = "{your_facebook_api_conversion}"
```

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


# How to generate your Facebook Conversion API
![Example of integration](https://habrastorage.org/files/b2a/380/96b/b2a38096b6e648978a464430e1537673.png)
