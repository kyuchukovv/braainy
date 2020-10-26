@extends('layouts.default')
@section('content')
    <div class="row">
        <h3>Products</h3>
        <p></p>
        <h3>Add new product</h3>
        <form id="new_product" name="new_product" >
            <label for="product_name">
                Product name:
                <input name="product_name" />
            </label>
            <button id="create_product" type="submit" >Create</button>
        </form>
    </div>
@stop
