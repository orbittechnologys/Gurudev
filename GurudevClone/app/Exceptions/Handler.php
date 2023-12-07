<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception){
        $response = parent::render($request, $exception);
        //dd(json_decode($response->content())->message);
        if(request()->is('api/*')){
            if($response->getStatusCode()==401)
                return response([['error' => json_decode($response->content())->message,'status'=>$response->getStatusCode() ?: 400]],401);
            else
                 return response([['error' => json_decode($response->content())->message,'status'=>$response->getStatusCode() ?: 400]]);
        }
        return parent::render($request, $exception);
    }
}
