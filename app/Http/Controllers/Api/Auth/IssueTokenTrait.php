<?php

namespace App\Http\Controller\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Token Oauth
 */
trait IssueTokenTrait{
    public function issueToken(
            Request $req,
            $grantType,
            $scope = "*"
        )
    {
        $params = [
            'grant_type'    => $grantType,
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $req->username ?: $req->email,
            'scope'         => $scope
        ];

        $req->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);
    }
}
