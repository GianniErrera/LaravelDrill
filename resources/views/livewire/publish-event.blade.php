<div class="mt-4">
    <div>
        @if (session()->has('message'))
        <div class="p-3 bg-green-300 lg:text-green-800 rounded shadow-sm">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <div class="border border-blue-400 rounded-lg px-8 py-6 lg:ml-6 mb-6 mr-2 md:mx-auto">
        <form wire:submit.prevent="publish">

            <div class="lg:flex p-4 text-center">
                <div class="lg:ml-6 lg:mr-4 lg:p-4 mb-6 text-center">
                    <div>
                        <span class="block mb-2 text-center">Pick a date:</span>

                        <input
                            wire:model="date"
                            id="date"
                            name="date"
                            value="{{old('date')}}"
                            class="ml-4 mb-4 border border-gray-800"
                            readonly
                            >

                    </div>

                    <div>
                        @error('date')
                        <p class="text-red-500 text-sm mt-2"> {{ $message}}</p>
                        @enderror
                    </div>
                </div>



                <div class="lg:ml-6 lg:mr-4 lg:p-4 mb-6 justify-center">
                    <div class="block mb-2">
                        <span class="text-sm lg:invisible">Event name and description   </span>
                    </div>
                    <div>
                        <input type="text"
                            wire:model="eventDescription"
                            id="eventDescription"
                            name="eventDescription"
                            value="{{old('eventDescription')}}"
                            size="400"
                            placeholder="Event name and description"
                            class="w-full border border-gray-500 p-2"
                            >
                    </div>
                    <div>
                        @error('eventDescription')
                            <p class="text-red-500 text-sm mt-2"> {{ $message}}</p>
                        @enderror
                    </div>
                </div>



            </div>

            <div class="flex mt-6 mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox"
                        wire:model="isItYearly"
                        class="form-checkbox cursor-pointer"
                        value="{{$isItYearly}}">
                    <span class="ml-2">Does this event recurr every year?</span>
                </label>
            </div>



            <hr class="mb-4">

            <footer class="flex justify-between items-center mr-4">
                <div class="flex items-center">
                    <img class="rounded-full"
                        src="https://i.pravatar.cc/500?u={{auth()->user()->email}}"
                        width="65"
                        alt="">
                </div>


                <button
                    type="submit"
                    class="bg-indigo-500 rounded-lg shadow p-2 ml-2 mr-2 text-white"
                    >Publish event
                </button>

            </footer>
        </form>
    </div>

</div>

<script>
    const datepicker= new Litepicker({
        element: document.getElementById('date'),
        format: 'DD-MM-YYYY',
        resetButton: true,
        singleMode: true,
        allowRepick: true,
        autoRefresh: true,
        splitView: true,
        setup: (picker) => {

            picker.on('selected', (date) => {
            Livewire.emit('publishDate', date.format('YYYY-MM-DD'));
            document.getElementById('date').value = date.format('YYYY-MM-DD')
            })
        },

        })
</script>

