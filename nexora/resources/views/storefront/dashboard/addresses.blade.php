<x-layouts.dashboard active="addresses" title="Addresses">

    <div x-data="{ open: false, editing: null, form: { label: '', name: '', line1: '', city: '', country: '', phone: '' } }">

        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">Addresses</h1>
                <p class="mt-1 text-sm text-primary-500 dark:text-primary-400">Manage your shipping addresses.</p>
            </div>
            <button type="button" @click="editing = null; form = { label: '', name: '', line1: '', city: '', country: '', phone: '' }; open = true" class="btn-primary">+ Add New Address</button>
        </div>

        @if ($addresses->isEmpty())
            <div class="mt-16 flex flex-col items-center justify-center text-center">
                <h2 class="text-xl font-semibold text-primary-900 dark:text-white">No addresses yet</h2>
                <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Add a shipping address to speed up checkout.</p>
            </div>
        @else
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                @foreach ($addresses as $address)
                    <div class="card-surface relative p-6">
                        @if ($address['isDefault'])
                            <span class="absolute right-4 top-4 rounded-full bg-accent-600/10 px-3 py-1 text-xs font-semibold text-accent-600">Default</span>
                        @endif
                        <p class="text-sm font-semibold uppercase tracking-wide text-primary-400">{{ $address['label'] }}</p>
                        <p class="mt-2 text-sm font-semibold text-primary-900 dark:text-white">{{ $address['name'] }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-primary-500 dark:text-primary-400">
                            {{ $address['line1'] }}<br>
                            {{ $address['city'] }}, {{ $address['country'] }}<br>
                            {{ $address['phone'] }}
                        </p>
                        <div class="mt-4 flex gap-4 border-t border-primary-900/10 pt-4 text-sm font-medium dark:border-white/10">
                            <button type="button" @click="editing = {{ $address['id'] }}; form = {{ Illuminate\Support\Js::from(['label' => $address['label'], 'name' => $address['name'], 'line1' => $address['line1'], 'city' => $address['city'], 'country' => $address['country'], 'phone' => $address['phone']]) }}; open = true" class="text-accent-600 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('dashboard.addresses.destroy', $address['id']) }}" onsubmit="return confirm('Delete this address?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                            @if (!$address['isDefault'])
                                <form method="POST" action="{{ route('dashboard.addresses.default', $address['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-primary-500 hover:underline dark:text-primary-400">Set as default</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Add / Edit modal --}}
        <div x-cloak x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click="open = false" class="fixed inset-0 bg-primary-900/40 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-primary-900">
                <h2 class="text-lg font-semibold text-primary-900 dark:text-white" x-text="editing ? 'Edit Address' : 'Add New Address'"></h2>

                <form method="POST" :action="editing ? '{{ url('/dashboard/addresses') }}/' + editing : '{{ route('dashboard.addresses.store') }}'" class="mt-5 space-y-4">
                    @csrf
                    <template x-if="editing"><input type="hidden" name="_method" value="PATCH"></template>

                    <div>
                        <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Label</label>
                        <input type="text" name="label" x-model="form.label" required placeholder="Home, Work..." class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Full Name</label>
                        <input type="text" name="name" x-model="form.name" required class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Address</label>
                        <input type="text" name="line1" x-model="form.line1" required class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">City</label>
                            <input type="text" name="city" x-model="form.city" required class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Country</label>
                            <input type="text" name="country" x-model="form.country" required class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Phone</label>
                        <input type="tel" name="phone" x-model="form.phone" required class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="open = false" class="btn-outline flex-1">Cancel</button>
                        <button type="submit" class="btn-accent flex-1">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.dashboard>
