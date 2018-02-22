<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    // use IssueTokenTrait;
    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }


    public function login(Request $req)
    {
        $this->validate($req,[
            'username'  => 'required',
            'password'  => 'required'
        ]);

        $params = [
            'grant_type'    => 'password',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $req->username,
            'password'      => $req->password,
            'scope'         => '*'
        ];

        $req->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);

        // return $this->issueToken($req,'password');
    }

    public function refresh(Request $req)
    {

        $this->validate($req,[
            'refresh_token'     => 'required'
        ]);

        $params = [
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $req->username,
            'password'      => $req->password,
        ];

        $req->request->add($params);
        
        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);
        // return $this->issueToken($req,'refresh_token');
    }

    public function logout(Request $req)
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id',$accessToken->id)
            ->update(['revoked'=>true]);

        $accessToken->revoke();

        return response()->json([],204);
    }
}
