<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AmazingSaleRequest;
use App\Http\Requests\Admin\Market\CommonDiscountRequest;
use App\Http\Requests\Admin\Market\CopanRequest;
use App\Models\Market\AmazingSale;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Copan;
use App\Models\Market\Product;
use App\Models\User;

class DiscountController extends Controller
{
    public function copan()
    {
        $copans = Copan::all();
        return view('admin.market.discounts.copan', compact('copans'));
    }
    public function copanCreate()
    {
        $users = User::all();
        return view('admin.market.discounts.copan-create', compact('users'));
    }

    public function copanStore(CopanRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int) $realTimestampEnd);
        if ($inputs['type'] == 0) {
            $inputs['user_id'] = null;
        }
        $amazingSale = Copan::create($inputs);
        return redirect()->route('admin.market.discounts.copan')->with('swal-success', __('admin.New discount coupon code has been successfully registered'));
    }

    public function copanEdit(Copan $copan)
    {
        $users = User::all();
        return view('admin.market.discounts.copan-edit', compact('copan', 'users'));
    }

    public function copanUpdate(CopanRequest $request, Copan $copan)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int) $realTimestampEnd);
        if ($inputs['type'] == 0) {
            $inputs['user_id'] = null;
        }
        $copan->update($inputs);
        return redirect()->route('admin.market.discounts.copan')->with('swal-success', __('admin.The discount coupon code has been successfully edited'));
    }

    public function copanDestroy(Copan $copan)
    {
        $result = $copan->delete();
        return redirect()->route('admin.market.discounts.copan')->with('swal-success', __('admin.The discount coupon code has been successfully removed'));
    }

    public function commonDiscount()
    {
        $commonDiscounts = CommonDiscount::all();
        return view('admin.market.discounts.common', compact('commonDiscounts'));
    }

    public function commonDiscountCreate()
    {
        return view('admin.market.discounts.common-create');
    }

    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int) $realTimestampEnd);
        $commonDiscount = CommonDiscount::create($inputs);
        return redirect()->route('admin.market.discounts.commonDiscount')->with('swal-success', __('admin.New common discount has been successfully registered'));
    }

    public function commonDiscountEdit(CommonDiscount $commonDiscount)
    {
        return view('admin.market.discounts.common-edit', compact('commonDiscount'));
    }

    public function commonDiscountUpdate(CommonDiscountRequest $request, CommonDiscount $commonDiscount)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int) $realTimestampEnd);
        $commonDiscount->update($inputs);
        return redirect()->route('admin.market.discounts.commonDiscount')->with('swal-success', __('admin.The common discount has been successfully edited'));
    }

    public function commonDiscountDestroy(CommonDiscount $commonDiscount)
    {
        $result = $commonDiscount->delete();
        return redirect()->route('admin.market.discounts.commonDiscount')->with('swal-success', __('admin.The common discount has been successfully removed'));
    }

    public function amazingSale()
    {
        $amazingSales = AmazingSale::all();
        return view('admin.market.discounts.amazing', compact('amazingSales'));
    }
    public function amazingSaleCreate()
    {
        $products = Product::all();
        return view('admin.market.discounts.amazing-create', compact('products'));
    }

    public function amazingSaleStore(AmazingSaleRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int) $realTimestampEnd);
        $amazingSale = AmazingSale::create($inputs);
        return redirect()->route('admin.market.discounts.amazingSale')->with('swal-success', __('admin.New amazing sell has been successfully registered'));
    }

    public function amazingSaleEdit(AmazingSale $amazingSale)
    {
        $products = Product::all();
        return view('admin.market.discounts.amazing-edit', compact('amazingSale', 'products'));
    }

    public function amazingSaleUpdate(AmazingSaleRequest $request, AmazingSale $amazingSale)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int) $realTimestampEnd);
        $amazingSale->update($inputs);
        return redirect()->route('admin.market.discounts.amazingSale')->with('swal-success', __('admin.The amazing sell has been successfully edited'));
    }

    public function amazingSaleDestroy(AmazingSale $amazingSale)
    {
        $result = $amazingSale->delete();
        return redirect()->route('admin.market.discounts.amazingSale')->with('swal-success', __('admin.The amazing sell has been successfully removed'));
    }
}
