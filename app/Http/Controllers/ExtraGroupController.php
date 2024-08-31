<?php

namespace App\Http\Controllers;

use App\ExtraGroup;
use Illuminate\Http\Request;

class ExtraGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExtraGroup $extraGroup
     * @return \Illuminate\Http\Response
     */
    public function index(ExtraGroup $extraGroup)
    {
        if(auth()->user()->hasRole('owner') || auth()->user()->hasRole('admin')){
            return view('extra_groups.index', ['extraGroups' => $extraGroup->where('createdBy',auth()->user()->id)->orWhere('createdBy',\App\User::whereHas('roles',function ($q){$q->name = 'admin';})->first()->id)->orderBy('id', 'desc')->paginate(10)]);
        }else return redirect()->route('orders.index')->withStatus(__('No Access'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
            return view('extra_groups.addEdit');
        }else return redirect()->route('orders.index')->withStatus(__('No Access'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:extra_groups,name', 'max:255'],
        ]);

        $extraGroup = new ExtraGroup;
        $extraGroup->name = strip_tags($request->name);
        $extraGroup->createdBy = auth()->id();
        $extraGroup->save();

        return redirect()->route('extra-groups.index')->withStatus(__('Extra Group successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExtraGroup  $extraGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraGroup $extraGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraGroup  $extraGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraGroup $extraGroup)
    {
        if(auth()->user()->id  == $extraGroup->createdBy || auth()->user()->hasRole('admin')){
        }else{
            return redirect()->route('extra-groups.index')->withStatus(__("Sorry you don't have access to do this."));
        }
        return view('extra_groups.addEdit',['extraGroup' => $extraGroup]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExtraGroup  $extraGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraGroup $extraGroup)
    {
        if(auth()->user()->id  == $extraGroup->createdBy || auth()->user()->hasRole('admin')){
        }else{
            return redirect()->route('extra-groups.index')->withStatus(__("Sorry you don't have access to do this."));
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $extraGroup->name = strip_tags($request->name);
        $extraGroup->save();

        return redirect()->route('extra-groups.index')->withStatus(__('Extra Group successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraGroup  $extraGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraGroup $extraGroup)
    {
        if(auth()->user()->id  == $extraGroup->createdBy || auth()->user()->hasRole('admin')){
            $extraGroup->delete();
            return redirect()->route('extra-groups.index')->withStatus(__('Extra Group successfully deleted.'));
        }else{
            return redirect()->route('extra-groups.index')->withStatus(__("Sorry you don't have access to do this."));
        }
    }
}
