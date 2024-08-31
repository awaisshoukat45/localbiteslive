<?php

namespace App\Http\Controllers;

use App\FoodIngredient;
use App\FoodIngredientItem;
use Illuminate\Http\Request;

class FoodIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FoodIngredient $foodIngredients)
    {
        if(auth()->user()->hasRole('owner') || auth()->user()->hasRole('admin')){
            return view('food_ingredients.index', ['foodIngredients' => $foodIngredients->where('createdBy',auth()->user()->id)->orWhere('createdBy',\App\User::whereHas('roles',function ($q){$q->name = 'admin';})->first()->id)->orderBy('id', 'desc')->paginate(10)]);
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
            return view('food_ingredients.addEdit');
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
            'name' => ['required', 'string', 'unique:food_ingredients,name', 'max:255'],
        ]);
        $foodIngredient = new FoodIngredient;
        $foodIngredient->name = strip_tags($request->name);
        $foodIngredient->createdBy = auth()->id();
        $foodIngredient->save();
        return redirect()->route('ingredient-groups.index')->withStatus(__('Food Item Group successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FoodIngredient  $foodIngredient
     * @return \Illuminate\Http\Response
     */
    public function show(FoodIngredient $foodIngredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FoodIngredient  $foodIngredient
     * @return \Illuminate\Http\Response
     */
    public function edit($id,FoodIngredient $foodIngredient)
    {
        $foodIngredient = FoodIngredient::findOrFail($id);
        return view('food_ingredients.addEdit',['foodIngredient' => $foodIngredient]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FoodIngredient  $foodIngredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $foodIngredient = FoodIngredient::findOrFail($id);
        $foodIngredient->name = strip_tags($request->name);
        $foodIngredient->save();

        return redirect()->route('ingredient-groups.index')->withStatus(__('Food Item Group successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FoodIngredient  $foodIngredient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $foodIngredient = FoodIngredient::findOrFail($id);
        if(auth()->user()->id  == $foodIngredient->createdBy || auth()->user()->hasRole('admin')){
            FoodIngredientItem::where('food_ingredient_id',$foodIngredient->id)->delete();
            $foodIngredient->delete();
            return redirect()->route('ingredient-groups.index')->withStatus(__('Food Item Group successfully deleted.'));
        }else{
            return redirect()->route('ingredient-groups.index')->withStatus(__("Sorry you don't have access to do this."));
        }
    }
}
