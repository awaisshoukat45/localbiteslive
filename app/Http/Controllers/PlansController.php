<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plans;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Plans $plans)
    {
        return view('plans.index', ['plans' => $plans->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = new Plans;
        $plan->name = strip_tags($request->name);
        $plan->price = strip_tags($request->price);
        $plan->limit_items = strip_tags($request->items_limit);
        $plan->limit_orders = strip_tags($request->orders_limit);
        $plan->paddle_id = strip_tags($request->paddle_id);
        $plan->period = $request->period == "monthly" ? 1 : 2;

        $plan->save();

        return redirect()->route('plans.index')->withStatus(__('Plan successfully created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plans $plan)
    {
        $plan->delete();

        return redirect()->route('plans.index')->withStatus(__('Plan successfully deleted!'));
    }
}
