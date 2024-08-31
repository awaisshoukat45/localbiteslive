@extends('layouts.front', ['class' => ''])
<script>
    var items=[];
    var selectionTypesCount = 0;
    var extrasSelected=[];
    var selectionsSelected=[];
    var CASHIER_CURRENCY = "<?php echo  env('CASHIER_CURRENCY','usd') ?>";
    var LOCALE="<?php echo  App::getLocale() ?>";
    function setCurrentItem(id){
        var item=items[id];
        selectionTypesCount = 0;
        $('#modalTitle').text(item.name);
        $('#modalName').text(item.name);
        $('#modalPrice').html(item.price);
        $('#modalID').text(item.id);
        $("#modalImg").attr("src",item.image);
        $('#modalDescription').html(item.description);
        $('#productModal').modal('show');

        //initially empty all Area
        $('#exrtas-area').hide();
        $('#sizes-area').hide();
        $('#deselection-area').hide();
        $('#exrtas-area-inside').empty();
        $('#sizes-area-inside').empty();
        $('#deselection-area-inside').empty();
        $('#selection-area').empty();
        $('#selection-extra-area').empty();

        extrasSelected=[];
        selectionsSelected=[];

        //Now set the extrast
        if(item.extras.length==0){
            console.log('has no extras');
            $('#exrtas-area-inside').empty();
            $('#exrtas-area').hide();
            $('#sizes-area-inside').empty();
            $('#sizes-area').hide();
            $('#deselection-area-inside').empty();
            $('#deselection-area').hide();
            $('#selection-extra-area').hide();
            $('#selection-extra-area').empty();
        }else{
            let hasSizes =false;
            let hasExtras =false;
            let hasDeselection =false;
            let smallAdded = false;
            let hasOtherTypeExtra = false;
            console.log('has extras');
            $('#exrtas-area-inside').empty();
            item.extras.forEach(element => {
                if(element.extras_group.name == "Sizes"){
                    hasSizes = true;
                    if(!smallAdded){
                        smallAdded = true;
                        $('#sizes-area-inside').append('<div class="custom-control custom-radio mb-3"><input onclick="recalculatePrice('+id+');" class="custom-control-input" id="'+0+'" name="size"  value="'+0+'" type="radio" checked="checked"><label class="custom-control-label" for="0"><span class="item-spec">Regular</span><span class="item-price text-right">$'+items[id]['priceNotFormated']+'</span></label></div>');
                        $('#sizes-area-inside').append('<div class="custom-control custom-radio mb-3"><input onclick="recalculatePrice('+id+');" class="custom-control-input" id="'+element.id+'" name="size"  value="'+element.price+'" type="radio"><label class="custom-control-label" for="'+element.id+'"><span class="item-spec">'+element.name+'</span><span class="item-price text-right">+'+element.priceFormated+'</span></label></div>');
                    }else{
                        $('#sizes-area-inside').append('<div class="custom-control custom-radio mb-3"><input onclick="recalculatePrice('+id+');" class="custom-control-input" id="'+element.id+'" name="size"  value="'+element.price+'" type="radio"><label class="custom-control-label" for="'+element.id+'"><span class="item-spec">'+element.name+'</span><span class="item-price text-right">+'+element.priceFormated+'</span></label></div>');

                    }
                }
                if(element.extras_group.name == "Deselection"){
                    hasDeselection = true;
                    $('#deselection-area-inside').append('<div class="custom-control custom-checkbox mb-3"><input onclick="recalculatePrice('+id+');" class="custom-control-input" id="'+element.id+'" name="extra"  value="'+element.price+'" type="checkbox"><label class="custom-control-label" for="'+element.id+'"><span class="item-spec">'+element.name+'</label></div>');
                }
                if(element.extras_group.name == "Add-Ons"){
                    hasExtras = true;
                    $('#exrtas-area-inside').append('<div class="custom-control custom-checkbox mb-3"><input onclick="recalculatePrice('+id+');" class="custom-control-input" id="'+element.id+'" name="extra"  value="'+element.price+'" type="checkbox"><label class="custom-control-label" for="'+element.id+'"><span class="item-spec">'+element.name+'</span><span class="item-price text-right">+'+element.priceFormated+'</span></label></div>');
                }
                if(element.extras_group.name != "Add-Ons" && element.extras_group.name != "Sizes" && element.extras_group.name != "Deselection"){
                    hasOtherTypeExtra = true;
                }

            });
            let selectedExtraParents = [];
            if(hasOtherTypeExtra){
                $('#selection-extra-area').show();
                $('#selection-extra-area').empty();

                item.extras.forEach(element => {
                    if(element.extras_group.name != "Add-Ons" && element.extras_group.name != "Sizes" && element.extras_group.name != "Deselection"){
                        let parentId = element.extras_group.id;
                        if($.inArray(parentId, selectedExtraParents) == -1){
                            selectedExtraParents.push(parentId);
                            let filteredArray = item.extras
                                .filter((element) =>
                                    element.extras_group.id === parentId);
                            selectionTypesCount +=1;
                            $("#selection-extra-area").append('<div id="selection-extra-area'+parentId+'"><label class="form-control-label">Want to add '+element.extras_group.name+' ?</label><label style="float: right;color: gray;" class="notrequiredP">Optional</label><div id="selection-extra-area-inside'+parentId+'"></div></div>');
                            filteredArray.forEach(tempItem => {
                                $('#selection-extra-area-inside'+parentId).append('<div class="custom-control custom-radio mb-3"><input required onclick="recalculatePrice('+id+');" class="custom-control-input" id="'+tempItem.id+'" name="selectionExtra'+parentId+'"  value="'+tempItem.price+'" type="radio"><label class="custom-control-label" for="'+tempItem.id+'"><span class="item-spec">'+tempItem.name+'</span><span class="item-price text-right">+'+tempItem.priceFormated+'</span></label></div>');
                            })
                        }
                    }
                });
            }
            $('#exrtas-area').show();
            $('#sizes-area').show();
            $('#deselection-area').show();
            if(!hasSizes){
                $('#sizes-area').hide();
            }
            if(!hasDeselection){
                $('#deselection-area').hide();
            }
            if(!hasExtras){
                $('#exrtas-area').hide();
            }
        }
        // $("input[name='size']").click(function() {
        //     var checked = $(this).attr('checked');
        //     // alert(checked);
        //     console.log(checked , $(this).is('checked'));
        //     if (checked) {
        //         $(this).prop('checked', false);
        //         $(this).attr('checked', false);
        //     }
        //     else {
        //         $(this).prop('checked', true);
        //         $(this).attr('checked', true);
        //     }
        // });
        //set Must Selection Food Items
        let selectedFoodParents = [];
        if(item.foodItems.length==0){
            console.log('has no foodItem');
            $('#selection-area').hide();
            $('#selection-area').empty();
        }else{
            $('#selection-area').show();
            item.foodItems.forEach(element => {
                let parentId = element.ingredient_group.id;
                if($.inArray(parentId, selectedFoodParents) == -1){
                        selectedFoodParents.push(parentId);
                        let filteredArray = item.foodItems
                            .filter((element) =>
                                element.ingredient_group.id === parentId);
                    selectionTypesCount +=1;
                    $("#selection-area").append('<div id="selection-area'+parentId+'"><label class="form-control-label">Please Select your '+element.ingredient_group.name+'</label><label style="float: right;color: gray;" class="requiredP">1 Required</label><label class="requiredL">Select 1</label><div id="selection-area-inside'+parentId+'"></div></div>');
                    filteredArray.forEach(tempItem => {
                        $('#selection-area-inside'+parentId).append('<div class="custom-control custom-radio mb-3"><input required onclick="recalculateSelection('+id+');" class="custom-control-input" id="'+tempItem.id+'" name="selection'+parentId+'"  value="'+tempItem.price+'" type="radio"><label class="custom-control-label" for="'+tempItem.id+'">'+tempItem.name+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></div>');
                    })

                }
            });
    }

    }

    function recalculatePrice(id,value){
        //console.log("Triger price recalculation: "+id);
        // console.log(items[id]);
        var mainPrice=parseFloat(items[id]['priceNotFormated']);
        extrasSelected=[];

        //Get the selected check boxes
        //prices=[];
        $.each($("input[name='extra']:checked"), function(){
            //prices.push(parseFloat(($(this).val()+"")));
            mainPrice+=parseFloat(($(this).val()+""));
            extrasSelected.push($(this).attr('id'));
        });
        $.each($("input[name^='selectionExtra']:checked"), function(){
            //prices.push(parseFloat(($(this).val()+"")));
            mainPrice+=parseFloat(($(this).val()+""));
            extrasSelected.push($(this).attr('id'));
        });
        $.each($("input[name='size']:checked"), function(){
            //prices.push(parseFloat(($(this).val()+"")));
            mainPrice+=parseFloat(($(this).val()+""));
            if($(this).attr('id')  != 0){
                extrasSelected.push($(this).attr('id'));
            }
        });

        var formatter = new Intl.NumberFormat(LOCALE, {
            style: 'currency',
            currency:  CASHIER_CURRENCY,
        });

        var formated=formatter.format(mainPrice); /* $2,500.00 */
        //console.log(formated);
        $('#modalPrice').html(formated);

    }
    function recalculateSelection(id,value){
        selectionsSelected=[];

        //Get the selected check boxes
        //prices=[];
        $.each($("input[name^='selection']:checked"), function(){
            //prices.push(parseFloat(($(this).val()+"")));
            selectionsSelected.push($(this).attr('id'));
        });

    }
    <?php
    $items=[];
    foreach ($restorant->categories as $key => $category) {

        foreach ($category->items as $key => $item) {

            $formatedExtras=$item->extras;
            $formatedFoodItems=$item->subItems;

            foreach ($formatedExtras as &$element) {
                $element->priceFormated=@money($element->price, env('CASHIER_CURRENCY','usd'),true)."";
            }

            $theArray=array(
                'name'=>$item->name,
                'id'=>$item->id,
                'priceNotFormated'=>$item->price,
                'price'=>@money($item->price, env('CASHIER_CURRENCY','usd'),true)."",
                'image'=>$item->logom,
                'extras'=>$formatedExtras,
                'foodItems'=>$formatedFoodItems,
                'description'=>$item->description
            );
            echo "items[".$item->id."]=".json_encode($theArray).";";
        }
    }
    ?>
    // $(document).ready(function (){
    //     $("input[name='size']").click(function() {
    //         var checked = $(this).attr('checked');
    //         alert(checked);
    //         if (checked) {
    //             $(this).attr('checked', false);
    //         }
    //         else {
    //             $(this).attr('checked', true);
    //         }
    //     });
    // });
</script>

@section('content')
    @include('restorants.partials.modals')
    <section class="section-profile-cover section-shaped grayscale-05 d-none d-md-none d-lg-block d-lx-block">
      <!-- Circles background -->
      <img class="bg-image" src="{{ $restorant->coverm }}" style="width: 100%;">
      <!-- SVG separator -->
      <div class="separator separator-bottom separator-skew">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section>
    <section class="section section-lg pt-lg-0 mt--9 d-none d-md-none d-lg-block d-lx-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title white"  <?php if($restorant->description || $openingTime && $closingTime){echo 'style="border-bottom: 1px solid #f2f2f2;"';} ?> >
                        <h1 class="display-3 text-white">{{ $restorant->name }}</h1>
                        <p class="display-4" style="margin-top: 120px">{{ $restorant->description }}</p>
                        @if(!empty($openingTime) && !empty($closingTime))
                            <p>{{ __('Today working hours') }}: <span><strong>{{ $openingTime }}</strong></span> - <span><strong>{{ $closingTime }}</strong></span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg d-md-block d-lg-none d-lx-none" style="padding-bottom: 0px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title">
                        <h1 class="display-3 text">{{ $restorant->name }}</h1>
                        <p class="display-4 text">{{ $restorant->description }}</p>
                        @if(!empty($openingTime) && !empty($closingTime))
                            <p>{{ __('Today working hours') }}: <span><strong>{{ $openingTime }}</strong></span> - <span><strong>{{ $closingTime }}</strong></span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg pt-lg-0" id="restaurant-content" style="padding-top: 0px">
        <div class="container container-restorant">
            @if(!$restorant->categories->isEmpty())
            @foreach ( $restorant->categories as $category)
                @if(!$category->items->isEmpty())
                <div class="">
                    <h1>{{ $category->name }}</h1><br />
                </div>
                @endif
                <div class="row">
                    @foreach ($category->items as $item)
                        @if($item->available == 1)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="strip">
                                <figure>
                                    <a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)"><img src="{{ $item->logom }}" data-src="{{ config('global.restorant_details_image') }}" class="img-fluid lazy" alt=""></a>
                                </figure>
                                <span class="res_title"><b><a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)">{{ $item->name }}</a></b></span><br />
                                <span class="res_description">{{ $item->short_description}}</span><br />
                                <span class="res_mimimum">@money($item->price, env('CASHIER_CURRENCY','usd'),true)</span>

                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            @else
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <p class="text-muted mb-0">{{ __('Hmmm... Nothing found!')}}</p>
                        <br/><br/><br/>
                        <div class="text-center" style="opacity: 0.2;">
                            <img src="https://www.jing.fm/clipimg/full/256-2560623_juice-clipart-pizza-box-pizza-box.png" width="200" height="200"></img>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </section>
@endsection
