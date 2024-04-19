<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailStoreRequest;
use App\Http\Requests\OrderDetailUpdateRequest;
use App\Models\OrderDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderDetailController extends Controller
{
    public function index(Request $request): Response
    {
        $orderDetails = OrderDetail::all();

        return view('orderDetail.index', compact('orderDetails'));
    }

    public function create(Request $request): Response
    {
        return view('orderDetail.create');
    }

    public function store(OrderDetailStoreRequest $request): Response
    {
        $orderDetail = OrderDetail::create($request->validated());

        $request->session()->flash('orderDetail.id', $orderDetail->id);

        return redirect()->route('orderDetail.index');
    }

    public function show(Request $request, OrderDetail $orderDetail): Response
    {
        return view('orderDetail.show', compact('orderDetail'));
    }

    public function edit(Request $request, OrderDetail $orderDetail): Response
    {
        return view('orderDetail.edit', compact('orderDetail'));
    }

    public function update(OrderDetailUpdateRequest $request, OrderDetail $orderDetail): Response
    {
        $orderDetail->update($request->validated());

        $request->session()->flash('orderDetail.id', $orderDetail->id);

        return redirect()->route('orderDetail.index');
    }

    public function destroy(Request $request, OrderDetail $orderDetail): Response
    {
        $orderDetail->delete();

        return redirect()->route('orderDetail.index');
    }
}
