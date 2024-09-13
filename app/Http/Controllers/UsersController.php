<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Traits\ApiResponse;

class UsersController extends Controller
{
    //
    use ApiResponse;
    public function index(Request $request){


        $user = User::firstOrCreate(
            [
                'email' => $request->input('email')
            ],
            [
                'password' => Hash::make(Str::random(12)),
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code')
            ]
        );

        try {
            //create new customer on stripe dashboard or if exists get him

            $user->createOrGetStripeCustomer();

            $payment = $user->charge(
                $request->input('amount'),
                $request->input('payment_method_id'),
                ['return_url' => $request->input('return_url')]
            );

            $payment = $payment->asStripePaymentIntent();



            // return $payment->amount;

            $order = $user->orders()
                ->create([
                    'transaction_id' => $payment->id,
                    'total' => (int) $payment->amount
                ]);

            foreach (json_decode($request->input('cart'), true) as $item) {

                // start increase the product numbber of selling
                $product = Product::find($item['id']);
                $product->number_of_selling += $item['quantity'];
                $product->save();
                // end
                
                $order->products()
                    ->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            $order->load('products');
            return $order;



        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function users() {
        // View all users
        return User::withCount('orders')->paginate(10);
    }




    public function update(Request $request, $user) {
        // Edit user details
        $user=User::find($user);
        $validData=$request->validate([
            'name'=>'required',
        ]);

        $user->name=$request->input('name');
        $user->save();

        return $this->successResponse(message:"user updated successfully");

    }


    public function destroy($user) {
        // Delete a user
        $user=User::find($user);
        $user->orders()->delete();
        $user->products()->delete();
        $user->delete();
        return $this->successResponse(message:"user deleted successfully");
    }




}

