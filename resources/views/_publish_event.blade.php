<div>
    <div>
        @if (session()->has('message'))
        <div class="p-3 bg-green-300 text-green-800 rounded shadow-sm">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <div class="border border-blue-400 rounded-lg px-8 py-6 ml-6 mb-6 mr-6">
        <form wire:submit.prevent="publishEvent">
            <div class="flex w-auto">
                <div>
                    <label for="start">Start date:</label>

                    <input type="date"
                        wire:model="date"
                        id="date"
                        name="date"
                        value="{{old('date')}}"
                        class="ml-4 mb-4"
                        >
                </div>

                @error('date')
                    <p class="text-red-500 text-sm mt-2"> {{ $message}}</p>
               @enderror

                <div>
                <input type="text"
                    wire:model="eventDescription"
                    id="eventDescription"
                    name="eventDescription"
                    value="{{old('eventDescription')}}"
                    class=" ml-4 mr-4 justify-center"
                    >
                </div>

                @error('eventDescription')
                    <p class="text-red-500 text-sm mt-2"> {{ $message}}</p>
               @enderror

            </div>

            <div class="flex mt-6 mb-6">
                <label class="flex items-center">
                    <input type="checkbox"
                        wire:model="isItYearly"
                        class="form-checkbox"
                        value="checked">
                    <span class="ml-2">Does this event recurr every year?</span></span>
                </label>
            </div>



            <hr class="mb-4">

            <footer class="flex justify-between items-center mr-4">
                <div class="flex items-center">
                    <img class="rounded-full"
                        src="https://i.pravatar.cc/100"
                        width="65"
                        alt="">
                </div>


                <button
                    type="submit"
                    class="bg-indigo-500 rounded-lg shadow p-2 mr-8 text-white"
                    >Publish event
                </button>

            </footer>
        </form>
    </div>

</div>
