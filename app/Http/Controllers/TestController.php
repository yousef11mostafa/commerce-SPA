<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    //

    public function __construct(){

    }

    public function index(){

        // Role::create(['name'=>'admin']);

        // User::find(auth()->user()->id)->assignRole('seller');

        // Mail::to("yousefmostafanawar@gmail.com")->send(new RegisterEmail('yousef'));



        return 'hellow';


    }
}
