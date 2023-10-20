<?php

namespace App\Helpers;

use App\Models\Country;
use App\Models\MerchantStore;
use App\Models\Order;
use App\Models\Payment;
use App\Models\SsoRequest;

class Http
{
    public static $RequestHeaders = [
        'accessToken'   =>  'x-access-token',
    ];

    public static $CurlContentTypes = [
        'JSON'                  =>  'Application/json',
        'MultiPartFormData'     =>  'Multipart/form-data',
    ];

    //in case of successful create, read, update, delete & any successful operation
    const SUCCESS = 'success';
    const CREATED = 'created';

    //in case of operational or process failure
    const BAD_REQUEST = 'bad_request';

    //in case of authentication failure, trying to access any protected route with expired or no API token
    const UNAUTHORISED = 'unauthorised';

    //in case of authentication failure, trying to access any protected route with expired or no API token
    const MAINTENANCE = 'maintenance';

    //in case of validation failure
    const INPROCESSABLE = 'inprocessable';

    //in case of internal server error
    const SERVER_ERROR = 'server_error';

    //server is unable to authorize a particular request made by a user.
    const AUTHORIZATION_ERROR = 'authorization_error';

    public static $Codes = [
        self::SUCCESS           => 200,
        self::CREATED           => 201,
        self::BAD_REQUEST       => 400,
        self::UNAUTHORISED      => 401,
        self::INPROCESSABLE     => 422,
        self::MAINTENANCE       => 503,
        self::SERVER_ERROR      => 500,
    ];

    public static function getApiPossibleCodes()
    {
        return array_values(self::$Codes);
    }
}
