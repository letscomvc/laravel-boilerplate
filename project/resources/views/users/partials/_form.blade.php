@csrf

<div class="flex flex-wrap mb-6">
    <label for="userName" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
    <input type="text" name="name" class="form-input w-full @error('name') border-red-500 @enderror"
           id="userName" placeholder="Nome do usuário" value="{{old('name') ?? $user->name ?? ''}}">
    @errorblock('name')
</div>

<div class="flex flex-wrap mb-6">
    <label for="userEmail" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
    <input type="email" name="email" class="form-input w-full @error('email') border-red-500 @enderror"
           id="userEmail" placeholder="Email do usuário" value="{{old('email') ?? $user->email ?? ''}}">
    @errorblock('email')
</div>

<div class="flex flex-wrap mb-6">
    <label for="userPassword" class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
    <input type="password" name="password" class="form-input w-full @error('password') border-red-500 @enderror"
           id="userPassword" placeholder="Senha">
    @errorblock('password')
</div>

<div class="flex flex-wrap mb-6">
    <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2">Confirmar senha</label>
    <input type="password" name="password_confirmation" class="form-input w-full @error('password_confirmation') border-red-500 @enderror"
           id="confirmPassword" placeholder="Confirmar senha">
</div>
