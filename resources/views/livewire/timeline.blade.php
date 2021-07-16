<div>
    <div class="flex justify-around">
        <div class="mb-4">

            <select wire:model="columnOrderCriteria"
                class="form-control ml-4">
                <option value="created_at">Ordered by creation date</option>
                <option value="date">Ordered by date</option>
            </select>
        </div>


        <div class="mb-3 ml-2">
            <input type="text"
                                wire:model="search"
                                id="search"
                                name="search"
                                value="{{old('search')}}"
                                placeholder=""
                                class="border border-gray-500 p-2"
                                >


        </div>

        <div class="block mr-4">
            <label for="startDate" class="block text-center">Start date:</label>

            <input type="date"
                wire:model="startDate"
                id="startDate"
                name="startDate"
                class="ml-4 mb-4"
                >

        </div>


        <div class="block mr-6">
            <label for="endDate" class="block text-center">End date:</label>

            <input type="date"
                wire:model="endDate"
                id="endDate"
                name="endDate"
                class="ml-4 mb-4"
                >

        </div>

        <div class="flex mr-4">
            <label class="flex block items-center">
              <input
               type="checkbox"
               wire:model="ignoreYearFromQuery"
               class="form-checkbox">
              <span class="ml-2">Search interval over all years</span>
            </label>
          </div>

        <div class="mr-4 text-center">
            <button
                wire:click="removeFilters"
                class="cursor-pointer">
                    <span class="items-center">Reset filters</span>
                    <img
                        src ="images/filter-remove.png"
                        width="30"
                        class="mr-2 items-center transform hover:scale-110"
                        >
            </button>
        </div>

        <div class="block">
            <label for="date" class="block text-center">Pick a date:</label>

            <input type="date"
                wire:model="searchDate"
                id="searchDate"
                name="searchDate"
                class="ml-4 mb-4"
                >

        </div>
    </div>


    <div class="border border-b-gray-300 rounded-xl">

        @forelse ($events as $event)
        <div class="p-4 border-b border-b-gray-400 rounded-xl ml-2 mr-2' }}">
            <div class="flex flex-row justify-between">
                <div>
                    <div>
                        <p class="text-sm mb-3"> {{ $event->date }} </p>
                    </div>
                    <div>
                        <p class="text-sm mb-3"> {{ $event->eventDescription }} </p>
                    </div>
                </div>
                <div class= "flex">
                    <div class="icon-container col-xs-12 col-sm-4 mr-2 p-4">
                        @if($event->yearly())
                        <div>
                            <div>
                                <img src="images/calendar_icon.svg" width="20">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mr-4">
                        <button class="btn bg-blue-600 text-white rounded-xl p-2 cursor-pointer hover:bg-blue-800"
                            id="copyToClipboard"
                            data-clipboard-text="{{$event->eventDescription . " - " . date_format(date_create($event->date), "F m, Y")}}">
                            Copy to clipboard
                        </button>
                    </div>
                </div>

            </div>
        </div>
        @empty
            <p class="p-4">No events yet</p>
        @endforelse

        {{$events->links()}}

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    new ClipboardJS('#copyToClipboard');
</script>
