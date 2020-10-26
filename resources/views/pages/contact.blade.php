@extends('layouts.default')
@section('content')
    <div class="row">
        <h3>contact <b>{{$data->name}}</b></h3>
        <div class="md-form">
            <input
                type="hidden"
                name="edit-contact-id"
                class="form-control"
                aria-describedby="contact-id"
                value="{{$data->id}}"
            />
            <div class="input-group mb-3">
                <span class="input-group-text" id="contact-name">Name</span>
                <input
                    type="text"
                    name="edit-contact-name"
                    class="form-control"
                    aria-describedby="contact-name"
                    value="{{$data->name}}"
                />
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="contact-description">Description</span>
                <textarea
                    class="form-control"
                    aria-describedby="contact-name"
                    name="edit-contact-description">{{$data->description ?? ''}}</textarea>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="contact-name">ID</span>
                <input
                    disabled
                    readonly
                    type="text"
                    class="form-control"
                    aria-describedby="contact-name"
                    value="{{$data->contact_id}}"
                />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="contact-name">Organization</span>
                <input
                    disabled
                    readonly
                    type="text"
                    class="form-control"
                    aria-describedby="contact-name"
                    value="{{$data->organization_id}}"
                />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="contact-name">Account</span>
                <input
                    disabled
                    readonly
                    type="text"
                    class="form-control"
                    aria-describedby="contact-name"
                    value="{{$data->account_id}}"
                />
            </div>

            <div class="col-12">
                <button id="edit-contact-button" class="btn btn-primary" type="submit">Save</button>
            </div>
        </div>
    </div>
@stop

