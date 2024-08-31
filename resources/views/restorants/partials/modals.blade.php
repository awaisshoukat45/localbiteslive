<div class="modal fade" id="productModal" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title" id="modal-title-new-item"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                    <!--<div class="container">-->
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg col-lg text-center">
                                <img id="modalImg" src="" width="100%" height="200px">
                            </div>
                            <div class="col-sm col-md col-lg col-lg">
                                <!--<h5><a href=""><span  id="modalName"></span></a></h5>-->
                                <input id="modalID" type="hidden"></input>
                                <span id="modalPrice" class="new-price"></span>
                                <p id="modalDescription"></p>
                                <div id="sizes-area">
                                    <label class="form-control-label" for="quantity">{{ __('Sizes') }}</label>
                                    <div id="sizes-area-inside">

                                    </div>
                                </div>
                                <div id="selection-area">
                                </div>
                                <div id="deselection-area">
                                    <label class="form-control-label" for="quantity">{{ __('Choose items to Exclude From Food') }}</label>
                                    <div id="deselection-area-inside">

                                    </div>
                                </div>
                                <div id="selection-extra-area">
                                </div>
                                <div id="exrtas-area">
                                    <label class="form-control-label" for="quantity">{{ __('Add-Ons') }}</label>
                                    <div id="exrtas-area-inside">

                                    </div>
                                </div>
                                <div class="quantity-area">

                                    <div class="form-group">
                                        <label class="form-control-label" for="quantity">{{ __('Quantity') }}</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control form-control-alternative" placeholder="{{ __('1') }}" value="1" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="comment">{{ __('Special instructions') }}</label>
                                        <textarea name="comment" id="comment" class="form-control" placeholder="e.g. No mayo"></textarea>
                                    </div>
                                    <div class="quantity-btn">
                                        <div id="addToCart1">
                                            <button class="btn btn-primary" v-on:click='addToCartAct'
                                                <?php
                                                    if(auth()->user()){
                                                        if(auth()->user()->hasRole('client')) {echo "";} else {echo "disabled";}
                                                    }else if(auth()->guest()) {echo "";}
                                                ?>
                                            >{{ __('Add To Cart') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-import-restaurants" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Import restaurants from CSV') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="col-md-10 offset-md-1">
                        <form role="form" method="post" action="{{ route('import.restaurants') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group text-center{{ $errors->has('item_image') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="resto_excel">Import your file</label>
                                <div class="text-center">
                                    <input type="file" class="form-control form-control-file" name="resto_excel" accept=".csv, .ods, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                </div>
                            </div>
                            <input name="category_id" id="category_id" type="hidden" required>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
