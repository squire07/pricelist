@extends('layouts.app')

@section('content') 
<div class="row">
<div class="col-lg-12 mt-1 mr-1">
    <div class="float-right">
        <a class="btn btn-danger" href="/distributor">X</a>
    </div>
</div>
</div>          
                <form action="{{ route('distributor.store') }}" method="POST">
                    @csrf
                        <div class="col-4">
                            <div class="form-group">
                                <strong>BCID:</strong>
                                <input type="text" name="bcid" class="form-control" placeholder="BCID">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="distributor" class="form-control" placeholder="Name">
                            </div>
                        </div>

                        {{-- <div class="col-4">
                            <div class="form-group">
                            <label for="department">Group:</label><br>
                                <select name="clientgroup_id" id="clientgroup">
                            <option value="option_select" disabled selected>---Select Group---</option>
                            @foreach ($clientgroups as $clientgroup)
                            <option value="{{ $clientgroup->id }}">{{ $clientgroup->client_group }}</option>
                            @endforeach
                            </select>
                            </div>
                        </div> --}}

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection