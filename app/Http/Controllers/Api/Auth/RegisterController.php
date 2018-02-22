<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

use App\User;

// use App\Http\IssueTokenTrait;
class RegisterController extends Controller
{

    // use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function register(Request $req)
    {
        $this->validate($req,[
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed'
        ]);

        // dd($req->all());
        $user = User::create([
            'name'      => $req->name,
            'email'     => $req->email,
            'password'  => bcrypt($req->password)
        ]);


        $params = [
            'grant_type'    => 'password',
            'client_id'     => '1',
            'client_secret' => 'YFZR43iE21r4W8i4HqbL8nyyEH1Q1HsWd9Zm6qEj',
            'username'      => $req->email,
            'password'      => $req->password,
            'scope'         => '*'
        ];

        $req->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);
        // return $this->issueToken($req,'password');
    }
}
