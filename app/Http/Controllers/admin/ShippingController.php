<?php

namespace App\Http\Controllers\admin;

use App\Models\Cities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create()
    {
        // Lấy dữ liệu của bảng Cities
        $cities = Cities::query()
            ->get();

        // Lấy ra city_id của bảng Shipping
        $shippingID = Shipping::query()->pluck('city_id')->toArray();

        // Lấy dữ liệu của bảng Shipping
        $shippings = Shipping::query()
            ->select('shopping_charges.*', 'cities.name')
            ->leftJoin('cities', 'shopping_charges.city_id', 'cities.id')
            ->get();

        // Trả về view
        return view(
            'admin.shipping.create',
            compact('cities', 'shippings', 'shippingID')
        );
    }

    public function store(Request $request)
    {
        // kiểm tra đầu vào các trường dữ liệu
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        // Nếu đúng
        if ($validator->passes()) {

            // Thực hiện thêm mới
            Shipping::create($validator->validated());

            // Thông báo thêm mới thành công
            session()->flash('success', 'Shipping created successfully.');

            // Trả về dữ liệu
            return response()->json([
                'status' => true,
            ]);
        } else {

            // Nếu sai, trả về lỗi
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id)
    {
        // Lấy dữ liệu của bảng Cities
        $cities = Cities::get();

        // Lấy ra city_id của bảng Shipping
        $shippingID = Shipping::query()
        ->where('id', '!=', $id)
        ->pluck('city_id')
        ->toArray();

        // Kiểm tra dữ liệu có tồn tại trong database không
        $shipping = Shipping::findOrFail($id);

        // Trả dữ liệu về viewing
        return view(
            'admin.shipping.edit',
            compact('cities', 'shipping', 'shippingID')
        );
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra tồn tại dữ liệu
        $shipping = Shipping::findOrFail($id);

        // kiểm tra đầu vào các trường dữ liệu
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|unique:shopping_charges,city_id,' . $id,
            'amount' => 'required|numeric',
        ]);

        // Nếu đúng
        if ($validator->passes()) {

            // Thực hiện thay đổi
            $shipping->update($validator->validated());

            // Thống báo thay đổi
            session()->flash('success', 'Shipping updated successfully.');

            // Trả về dữ liệu
            return response()->json([
                'status' => true,
            ]);
        } else {

            // Nếu sai, trả về lỗi
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id)
    {
        // Kiểm tra dữ liệu có tồn tại trong database không
        $shipping = Shipping::findOrFail($id);

        // Xóa dữ liệu
        $shipping->delete();

        // Trả về dữ liệu
        return response()->json([
            'status' => true,
            'message' => 'Shipping deleted successfully.',
            'shipping' => Shipping::query()
                ->select('shopping_charges.*', 'cities.name')
                ->leftJoin('cities', 'shopping_charges.city_id', 'cities.id')
                ->get(),
        ]);
    }
}
