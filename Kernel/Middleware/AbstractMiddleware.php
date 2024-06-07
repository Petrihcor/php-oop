<?php

namespace App\Kernel\Middleware;

use App\Kernel\Auth\Auth;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\Request;

abstract class AbstractMiddleware
{
    public function __construct(
        protected Request $request,
        protected Auth $auth,
        protected Redirect $redirect
    ){
    }

    abstract public function handle(): void;
}