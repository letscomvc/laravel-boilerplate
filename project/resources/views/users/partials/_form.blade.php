@csrf

<div class="form-group {{ has_error_class('name') }}">
  <label for="userName">Nome</label>
  <input type="name" name="name" class="form-control" id="userName" placeholder="Nome do usuário" value="{{old('name') ?? $user->name ?? ''}}">
  @errorblock('name')
</div>

<div class="form-group {{ has_error_class('email') }}">
  <label for="userEmail">Email</label>
  <input type="email" name="email" class="form-control" id="userEmail" placeholder="Digite o email" value="{{old('email') ?? $user->email ?? ''}}">
  @errorblock('email')
</div>

<div class="form-group">
  <label for="userPassword">Senha</label>
  <input type="password" name="password" class="form-control" id="userPassword" placeholder="Senha">
  @errorblock('password')
</div>

<div class="form-group">
  <label for="confirmPassword">Confirmar senha</label>
  <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="Confirmar senha">
</div>
