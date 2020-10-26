@extends('layouts.default')
@section('content')
    <div class="row">
        <h3>Product <b>{{$data->name}}</b></h3>
        <div class="md-form">
            <input
                type="hidden"
                name="edit-product-id"
                class="form-control"
                aria-describedby="product-id"
                value="{{$data->id}}"
            />
            <div class="input-group mb-3">
                <span class="input-group-text" id="product-name">Name</span>
                <input
                    type="text"
                    name="edit-product-name"
                    class="form-control"
                    aria-describedby="product-name"
                    value="{{$data->name}}"
                />
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="product-description">Description</span>
                <textarea
                    class="form-control"
                    aria-describedby="product-name"
                    name="edit-product-description">{{$data->description ?? ''}}</textarea>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="product-name">ID</span>
                <input
                    disabled
                    readonly
                    type="text"
                    class="form-control"
                    aria-describedby="product-name"
                    value="{{$data->product_id}}"
                />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="product-name">Organization</span>
                <input
                    disabled
                    readonly
                    type="text"
                    class="form-control"
                    aria-describedby="product-name"
                    value="{{$data->organization_id}}"
                />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="product-name">Account</span>
                <input
                    disabled
                    readonly
                    type="text"
                    class="form-control"
                    aria-describedby="product-name"
                    value="{{$data->account_id}}"
                />
            </div>

            <div class="col-12">
                <button id="edit-product-button" class="btn btn-primary" type="submit">Save</button>
            </div>
        </div>
    </div>
@stop

