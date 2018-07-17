@csrf

<div class="form-group">
  <label for="userName">Nome</label>
  <input type="name" name="name" class="form-control {{ has_error('name', 'has-danger') }}" id="userName" placeholder="Nome do usuário" value="{{old('name') ?? $user->name ?? ''}}">
  @errorblock('name')
</div>

<div class="form-group">
  <label for="userEmail">Email</label>
  <input type="email" name="email" class="form-control {{ has_error('name', 'has-danger') }}" id="userEmail" placeholder="Digite o email" value="{{old('email') ?? $user->email ?? ''}}">
  @errorblock('email')
</div>

<div class="form-group">
  <label for="userPassword">Senha</label>
  <input type="password" name="password" class="form-control {{ has_error('name', 'has-danger') }}" id="userPassword" placeholder="Senha">
  @errorblock('password')
</div>

<div class="form-group">
  <label for="confirmPassword">Confirmar senha</label>
  <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="Confirmar senha">
</div>
