<form method="POST"
      action="{{ route('login') }}"
      x-data="{component: new Login($el)}"
      x-on:submit.prevent="await component.submit()">
    @csrf


    <div>
        <x-input-label for="name" :value="__('Username')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />

        <ul class="text-sm text-red-600 space-y-1" x-show="component.errors.length">
            <template x-for="error in component.errors">
                <li x-text="error"></li>
            </template>
        </ul>
    </div>

    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mt-5">Sign In / Create</button>
</form>
