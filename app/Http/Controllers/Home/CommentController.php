<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function store(Request $request , Product $product)
    {
        if(auth()->check())
        {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|min:5|max:7000',
                'rate' => 'required|digits_between:0,5'
            ]);

            if ($validator->fails()) {
                return redirect()->to(url()->previous() . '#comments')->withErrors($validator);
            }

            try {
                DB::beginTransaction();

                Comment::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'text' => $request->comment
                ]);

                if ($product->rates()->where('user_id', auth()->id())->exists())
                {
                    $productRate = $product->rates()->where('user_id', auth()->id())->first();
                    $productRate->update([
                        'rate' => $request->rate
                    ]);
                }
                else
                {
                    ProductRate::create([
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                        'rate' => $request->rate
                    ]);
                }

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                return back()->with('errorComment' , 'کامنت با موفقیت ثبت نشد');
            }
        }
        else
        {
            return back()->with('errorComment' , 'ابتدا وارد شوید');
        }

        return back()->with('successComment' , 'بعد از تایید نمایش داده می شود');
    }

    public function userComments()
    {
        $comments = Comment::where('user_id' , auth()->id())->where('approved', 1)->get();
        return view('home.user_profile.comments', compact('comments'));
    }

}
