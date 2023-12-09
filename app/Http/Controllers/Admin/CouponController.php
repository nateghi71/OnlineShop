<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('admin.coupons.index' , compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'percentage' => 'required_if:type,=,percentage',
            'max_percentage_amount' => 'required_if:type,=,percentage',
            'expired_at' => 'required',
            'description' => 'nullable'
        ]);

        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'percentage' => $request->percentage,
            'max_percentage_amount' => $request->max_percentage_amount,
            'expired_at' => $request->expired_at,
            'description' => $request->description,
        ]);

        return back()->with( 'message' ,'کوپن مورد نظر ایجاد شد');
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show' , compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit' , compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'percentage' => 'required_if:type,=,percentage',
            'max_percentage_amount' => 'required_if:type,=,percentage',
            'expired_at' => 'required',
            'description' => 'nullable'
        ]);

        $coupon->update([
            'name' => $request->name,
            'code' => $request->code,
            'percentage' => $request->percentage,
            'max_percentage_amount' => $request->max_percentage_amount,
            'expired_at' => $request->expired_at,
            'description' => $request->description,
        ]);

        return back()->with( 'message' ,'کوپن مورد نظر بروزرسانی شد');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back();
    }
}
