<div>
    <div class="flex">
        <div class="mb-4">

            <select wire:model="columnOrderCriteria"
                class="form-control ml-4">
                <option value="created_at">Ordered by creation date</option>
                <option value="date">Ordered by date</option>
            </select>
        </div>


        <div class="mb-3 ml-2 flex-grow">
            <input type="text"
                                wire:model="search"
                                id="search"
                                name="search"
                                value="{{old('search')}}"
                                placeholder=""
                                class="border border-gray-500 p-2"
                                >


        </div>

        <div>
            <label for="start">Pick a date:</label>

            <input type="date"
                wire:model="searchDate"
                id="searchDate"
                name="searchDate"
                value="{{old('searchDate')}}"
                class="ml-4 mb-4"
                >

                {{ $searchDate}}
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
                <div class="icon-container col-xs-12 col-sm-4 mr-2">
                    @if($event->yearly())
                    <div>
                        <div>
                            <img src="images/calendar_icon.svg" width="20">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
        @empty
            <p class="p-4">No events yet</p>
        @endforelse


    </div>
</div>
