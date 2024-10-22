<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(DiscountCoupon::select('*'))
                ->addColumn('action', function ($coupon) {
                    return view('admin.action', ['path' => 'admin.coupons.edit', 'id' => $coupon->id]);
                })
                ->addColumn('discount_amount', function ($coupon) {
                    return ($coupon->type == 'fixed') ?  number_format($coupon->discount_amount, 0, ',', '.') . ' ₫' : $coupon->discount_amount . '%';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.coupon.index');
    }
    public function create()
    {
        return view("admin.coupon.create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required|in:0,1',
            'start_at' => 'nullable|date_format:Y-m-d H:i:s|after:now',
            'expires_at' => 'nullable|date_format:Y-m-d H:i:s|after:start_at',
        ]);


        if ($validator->passes()) {
            DiscountCoupon::create($validator->validated());
            session()->flash('success', 'Discount coupon created successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Discount coupon created successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function edit($id)
    {
        $coupon = DiscountCoupon::find($id);
        return view('admin.coupon.edit', compact('coupon'));
    }


    public function update(Request $request, $id)
    {
        $coupon = DiscountCoupon::find($id);

        if ($coupon == null) {
            return response()->json([
                'status' => false,
                'message' => 'Discount coupon not found.'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required|in:0,1',
            'start_at' => 'nullable|date_format:Y-m-d H:i:s|after:now',
            'expires_at' => 'nullable|date_format:Y-m-d H:i:s|after:start_at',
        ]);

        if ($validator->passes()) {
            $coupon->update($validator->validated());
            session()->flash('success', 'Discount coupon updated successfully.');
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($id)
    {
        $coupon = DiscountCoupon::find($id);
        if ($coupon) {
            $coupon->delete();
            return response()->json([
                'status' => true,
                'message' => 'Discount coupon deleted successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Discount coupon not found.'
        ]);
    }
}
