@extends('layouts.default')
@section('content')
    <div class="row">
        <h3>Products</h3>
        <span>
            <button id="sync-products" class="btn btn-floating btn-sm">
                <i class="fa fa-sync"></i>
            </button>
        </span>
        <h3>Add new product</h3>
        <form id="new_product" name="new_product">
            <label for="product_name">
                Product name:
                <input name="product_name"/>
            </label>
            <button id="create_product" type="submit">Create</button>
        </form>
        <div id="datatable-product" class="datatable">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Archived</th>
                    <th scope="col">Inventory</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data ?? [] as $product)
                    <tr>
                        <th>{{$product->id}}</th>
                        <td><a href="/product/{{$product->id}}">{{$product->name}}</a></td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->isArchived}}</td>
                        <td>{{$product->isInInventory}}</td>
                        <td>
                            <button data-id="{{$product->id}}" class="edit-product-button btn btn-floating btn-sm">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button data-id="{{$product->id}}" class="remove-product-button btn btn-floating btn-sm">
                                <i style="color: red;" class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop
