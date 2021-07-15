<div class="mt-4">
    <div>
        @if (session()->has('message'))
        <div class="p-3 bg-green-300 text-green-800 rounded shadow-sm">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <div class="border border-blue-400 rounded-lg px-8 py-6 ml-6 mb-6 mr-2">
        <form wire:submit.prevent="publish">

            <div class="flex p-4">
                <div>
                    <div>
                        <label for="start">Pick a date:</label>

                        <input type="date"
                            wire:model="date"
                            id="date"
                            name="date"
                            value="{{old('date')}}"
                            class="ml-4 mb-4"
                            >
                    </div>

                    <div>
                        @error('date')
                        <p class="text-red-500 text-sm mt-2"> {{ $message}}</p>
                        @enderror
                    </div>
                </div>



                <div class="ml-4 mr-4 mb-4  justify-center">
                    <div>
                        <input type="text"
                            wire:model="eventDescription"
                            id="eventDescription"
                            name="eventDescription"
                            value="{{old('eventDescription')}}"
                            placeholder="Event name and description"
                            class="border border-gray-500 p-2"
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
                    class="bg-indigo-500 rounded-lg shadow p-2 mr-2 text-white"
                    >Publish event
                </button>

            </footer>
        </form>
    </div>

</div>

