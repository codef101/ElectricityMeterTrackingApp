<form action="{{ route('meternumbertable.update', $MeterNumber) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>Consumer Name:</strong>
                <input type="text" name="Consumer" value="{{ $MeterNumber->Consumer }}" class="form-control" placeholder="Consumer name">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>Company Email:</strong>
                <input type="email" name="email" class="form-control" placeholder="Company Email" value="{{ $MeterNumber->email }}">
                 <div class="form-group">
                <strong>Company Address:</strong>
                <input type="text" name="address" value="{{ $MeterNumber->address }}" class="form-control" placeholder="Company Address">
                    @error('address')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary ml-3">Submit</button>
        </div>
    </form>