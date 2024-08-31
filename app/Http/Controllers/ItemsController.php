<?php

namespace App\Http\Controllers;

use App\FoodIngredient;
use App\FoodIngredientItem;
use Illuminate\Http\Request;
use App\Items;
use App\Restorant;
use App\Extras;
use App\ExtraGroup;
use Image;

use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;


class ItemsController extends Controller
{

    private $imagePath="uploads/restorants/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('owner')){
            return view('items.index', ['categories' => auth()->user()->restorant->categories->reverse(), 'restorant_id' => auth()->user()->restorant->id]);
        }else
            return redirect()->route('orders.index')->withStatus(__('No Access'));
    }

    public function indexAdmin(Restorant $restorant)
    {
        if(auth()->user()->hasRole('admin')){
            return view('items.index', ['categories' => Restorant::findOrFail($restorant->id)->categories->reverse(), 'restorant_id' => $restorant->id]);
        }else
            return redirect()->route('orders.index')->withStatus(__('No Access'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Items;
        $item->name = strip_tags($request->item_name);
        $item->description = strip_tags($request->item_description);
        $item->price = strip_tags($request->item_price);
        $item->category_id = strip_tags($request->category_id);
        if($request->hasFile('item_image')){
            $item->image=$this->saveImageVersions(
                $this->imagePath,
                $request->item_image,
                [
                    ['name'=>'large','w'=>590,'h'=>400],
                    //['name'=>'thumbnail','w'=>300,'h'=>300],
                    ['name'=>'medium','w'=>295,'h'=>200],
                    ['name'=>'thumbnail','w'=>200,'h'=>200]
                ]
            );
        }
        $item->save();

        return redirect()->route('items.index')->withStatus(__('Item successfully updated.'));
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
    public function edit(Items $item)
    {
        //if item belongs to owner restorant menu return view
        if(auth()->user()->hasRole('owner') && $item->category->restorant->id == auth()->user()->restorant->id || auth()->user()->hasRole('admin')){
            return view('items.edit', ['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id , 'extraGroups' => ExtraGroup::where('createdBy',auth()->user()->id)->orWhere('createdBy',\App\User::whereHas('roles',function ($q){$q->name = 'admin';})->first()->id)->get() , 'foodIngredientGroups'=>FoodIngredient::where('createdBy',auth()->user()->id)->orWhere('createdBy',\App\User::whereHas('roles',function ($q){$q->name = 'admin';})->first()->id)->get()  ]);
        }else{
            return redirect()->route('items.index')->withStatus(__("No Access"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $item)
    {
        $item->name = strip_tags($request->item_name);
        $item->description = strip_tags($request->item_description);
        $item->price = strip_tags($request->item_price);

        if($request->hasFile('item_image')){

            if($request->hasFile('item_image')){
                $item->image=$this->saveImageVersions(
                    $this->imagePath,
                    $request->item_image,
                    [
                        ['name'=>'large','w'=>590,'h'=>400],
                        //['name'=>'thumbnail','w'=>300,'h'=>300],
                        ['name'=>'medium','w'=>295,'h'=>200],
                        ['name'=>'thumbnail','w'=>200,'h'=>200]
                    ]
                );

            }
        }

        $item->update();
        return redirect()->route('items.edit', $item)->withStatus(__('Item successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Items $item)
    {
        $item->delete();

        return redirect()->route('items.index')->withStatus(__('Item successfully deleted.'));
    }

    public function import(Request $request)
    {
        $restorant = Restorant::findOrFail($request->res_id);

        Excel::import(new ItemsImport($restorant), request()->file('items_excel'));

        //return redirect()->route('restorants.index')->withStatus(__('Items successfully imported'));
        return back()->withStatus(__('Items successfully imported'));
    }

    public function change(Items $item, Request $request)
    {
        $item->available = $request->value;
        $item->update();

        return response()->json([
            'data' => [
                'itemAvailable' => $item->available
            ],
            'status' => true,
            'errMsg' => ''
        ]);
    }

    public function storeExtras(Request $request, Items $item)
    {
        $extras = new Extras;
        $extras->name = strip_tags($request->extras_name);
        $extras->price = strip_tags($request->extras_price);
        $extras->extra_group_id = strip_tags($request->extra_group_id);
        $extras->item_id = $item->id;

        $extras->save();

        return redirect()->route('items.edit',['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Extras successfully added.'));
    }
    public function storeIngredients(Request $request, Items $item)
    {
        $foodIngredient = new FoodIngredientItem;
        $foodIngredient->name = strip_tags($request->ingredient_name);
        $foodIngredient->food_ingredient_id = strip_tags($request->food_ingredient_id);
        $foodIngredient->item_id = $item->id;
        $foodIngredient->save();

        return redirect()->route('items.edit',['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Food Item successfully added.'));
    }

    public function showExtras(Extras $extras)
    {
        return response()->json([
            'data' => [
                'name' => $extras->name,
                'price' => $extras->price,
                'extra_group_id' => $extras->extra_group_id,
            ],
            'status' => true,
            'errMsg' => ''
        ]);
    }
    public function showIngredients(FoodIngredientItem $foodIngredientItem)
    {
        return response()->json([
            'data' => [
                'name' => $foodIngredientItem->name,
                'food_ingredient_id' => $foodIngredientItem->food_ingredient_id,
            ],
            'status' => true,
            'errMsg' => ''
        ]);
    }

    public function editExtras(Request $request, Items $item)
    {
        $extras = Extras::where(['id'=>$request->extras_id])->get()->first();

        $extras->name = strip_tags($request->extras_name_edit);
        $extras->price = strip_tags($request->extras_price_edit);
        $extras->extra_group_id = strip_tags($request->extra_group_id_edit);

        $extras->update();

        return redirect()->route('items.edit',['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Extras successfully updated.'));
    }
    public function editIngredients(Request $request, Items $item)
    {
        $ingredient = FoodIngredientItem::where(['id'=>$request->ingredient_id])->first();

        $ingredient->name = strip_tags($request->ingredient_name_edit);
        $ingredient->food_ingredient_id = strip_tags($request->ingredient_group_id_edit);

        $ingredient->update();

        return redirect()->route('items.edit',['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Food Item successfully updated.'));
    }

    public function deleteExtras(Items $item, Extras $extras)
    {
        $extras->delete();

        return redirect()->route('items.edit',['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Extras successfully deleted.'));
    }
}
