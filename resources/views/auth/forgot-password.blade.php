<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Esqueceu sua senha? Sem problemas. Apenas informe seu ID que enviaremos um link que permitirá definir uma nova senha.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.forgot') }}">
            @csrf

            <!-- Email Address -->
            <div>
                

                <x-input id="username" class="block mt-1 w-full" type="text" name="username" placeholder="ID do Aluno" :value="old('username')" required autofocus />
                <x-label for="username" class="pt-2 text-gray-400" :value="__('Pode ser localizado no seu Contrato, Manual do Aluno ou no email/mensagem de confirmação!')" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Recupere sua senha') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
