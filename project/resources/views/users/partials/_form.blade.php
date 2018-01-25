@csrf
<div class="form-group{{ has_error_class('name') }}">
    <label for="name" class="col-md-4 control-label">Name</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?? @$user->name ?? '' }}" required autofocus>
        @errorblock('name')
    </div>
</div>

<div class="form-group{{ has_error_class('email') }}">
    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

    <div class="col-md-6">
        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') ?? @$user->email ?? '' }}" required>
        @errorblock('email')
    </div>
</div>

<div class="form-group{{ has_error_class('password') }}">
    <label for="password" class="col-md-4 control-label">Password</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control" name="password" required>
        @errorblock('password')
    </div>
</div>

<div class="form-group">
    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>
</div>
