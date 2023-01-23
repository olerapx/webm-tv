<form method="POST"
      action="{{ route('login') }}"
      x-data="{login: new Login($el)}"
      x-on:submit.prevent="await login.submit()">
    @csrf

    <div>
        <div class="mb-5 text-lg">Sign in or create an account</div>

        <x-input-label for="name" :value="__('Username')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />

        <ul class="text-sm text-red-600 space-y-1" x-show="login.errors.length">
            <template x-for="error in login.errors">
                <li x-text="error"></li>
            </template>
        </ul>
    </div>

    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-5">Sign In</button>
    <span class="text-sm pl-3">to access watch history & bookmark videos</span>
</form>
