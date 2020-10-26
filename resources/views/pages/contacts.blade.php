@extends('layouts.default')
@section('content')
    <div class="row">
        <h3>contacts</h3>
        <span>
            <button id="sync-contacts" class="btn btn-floating btn-sm">
                <i class="fa fa-sync"></i>
            </button>
        </span>
        <h3>Add new contact</h3>
        <form id="new_contact" name="new_contact">
            <label for="contact_name">
                Name:
                <input name="contact_name"/>
            </label>
            <label for="contact_type">
                Type:
                <select id="contact-type-selector" name="contact_type" class="browser-default custom-select">
                    <option value="company">Company</option>
                    <option value="person">Person</option>
                </select>
            </label>

            <button id="create_contact" type="submit">Create</button>
        </form>
        <div id="datatable-contact" class="datatable">
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
                @foreach($data ?? [] as $contact)
                    <tr>
                        <th>{{$contact->id}}</th>
                        <td><a href="/contact/{{$contact->id}}">{{$contact->name}}</a></td>
                        <td>{{$contact->description}}</td>
                        <td>{{$contact->isArchived}}</td>
                        <td>{{$contact->isInInventory}}</td>
                        <td>
                            <button data-id="{{$contact->id}}" class="edit-contact-button btn btn-floating btn-sm">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button data-id="{{$contact->id}}" class="remove-contact-button btn btn-floating btn-sm">
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
