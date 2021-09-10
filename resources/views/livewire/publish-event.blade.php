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
                <div class="lg:mr-4 lg:p-4 mb-6 text-center">
                    <div>
                        <span class="block mb-2 text-center font-semibold">Pick a date:</span>

                        <input
                            wire:model="date"
                            id="date"
                            name="date"
                            value="{{old('date')}}"
                            class="ml-4 mb-4 input input-bordered border-gray-800"
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
                        <span class="text-sm lg:invisible font-semibold">Event name and description   </span>
                    </div>
                    <div>
                        <input type="text"
                            wire:model="eventDescription"
                            id="eventDescription"
                            name="eventDescription"
                            value="{{old('eventDescription')}}"
                            size="400"
                            placeholder="Event name and description"
                            class="w-full input input-border border border-gray-500 p-2"
                            >
                    </div>
                    <div>
                        @error('eventDescription')
                            <p class="text-red-500 text-sm mt-2"> {{ $message}}</p>
                        @enderror
                    </div>
                </div>



            </div>

            <div class="flex ml-5 mt-6 mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox"
                        wire:model="isItYearly"
                        class="toggle cursor-pointer"
                        value="{{$isItYearly}}">
                    <span class="ml-2 font-semibold">Does this event recur every year?</span>
                </label>
            </div>



            <hr class="mb-4">

            <footer class="text-center lg:text-right lg:mr-0 items-center mr-4">



                <button
                    type="submit"
                    class="btn btn-primary rounded-xl hover:text-yellow-100"
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
        dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
        setup: (picker) => {

            picker.on('selected', (date) => {
            Livewire.emit('publishDate', date.format('YYYY-MM-DD'));
            document.getElementById('date').value = date.format('YYYY-MM-DD');
            })
        },

        })
</script>

