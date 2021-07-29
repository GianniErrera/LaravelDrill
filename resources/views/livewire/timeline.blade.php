<div>

    @livewire('reminders')

    <div class="lg:flex lg:justify-around">
        <div>
            <select wire:model="columnOrderCriteria"
                class="form-control ml-4">
                <option value="created_at">Ordered by creation date</option>
                <option value="date">Ordered by date</option>
            </select>
        </div>


        <div class="lg:mb-3 @if($singleDateQuery) hidden @endif">
            <label for="search" class="block text-center">Search over dates range:</label>
            <input
                wire:model="searchRange"
                id="searchRange"
                name="searchRange"
                class="ml-4 mb-4 p-2 border border-gray-800"
            >
        </div>


        <div class="block @unless ($singleDateQuery)hidden @endunless">
            <label for="date" class="block text-center">Pick a date:</label>

            <input
                wire:model="searchDate"
                id="searchDate"
                name="searchDate"
                type="text"
                class="ml-4 mb-4 p-2 border border-gray-800"
                >

        </div>

        <div class="lg:mb-3">
            <div class="block mb-2">
                <span class="ml-2">Sigle date query</span>
            </div>
            <div class="block text-center">
                <input
                type="checkbox"
                wire:model="singleDateQuery"
                class="flex-none ">
            </div>

        </div>


        <div class="mb-3">
            <label for="search" class="block text-center">Search events:</label>
            <input type="text"
                    wire:model="search"
                    id="search"
                    name="search"
                    value="{{old('search')}}"
                    placeholder=""
                    class="border border-gray-800 mb-4 p-2"
                    >
        </div>


        <div class="mb-3">
            <div class="block mb-2">
                <span class="ml-2">Search interval over all years</span>
            </div>
            <div class="block text-center">
                <input
                type="checkbox"
                wire:model="ignoreYearFromQuery"
                class="flex-none ">
            </div>

        </div>

        <div>
            <div class="block">
                <span class="text-center">Reset filters</span>
                <div class="text-center m-2">
                    <button
                        wire:click="removeFilters"
                        class="cursor-pointer align-center">

                            <img
                                src ="images/filter-remove.png"
                                width="30"
                                class="transform hover:scale-110"
                                >
                    </button>
                </div>
            </div>
        </div>


    </div>

    <br class="mb-2">

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
    <script>
        const picker= new Litepicker({
            element: document.getElementById('searchDate'),
            format: 'DD-MM-YYYY',
            resetButton: true,
            singleMode: true,
            allowRepick: true,
            autoRefresh: true,
            setup: (picker) => {

                picker.on('selected', (date) => {
                Livewire.emit('selectDate', date.format('YYYY-MM-DD'));
                document.getElementById('searchDate').value = date.format('YYYY-MM-DD')
                })
            },
            resetButton: () => {
                let btn = document.createElement('button');
                btn.innerText = 'Clear';
                btn.addEventListener('click', (evt) => {
                    evt.preventDefault();

                    Livewire.emit('resetSearchDate');
                });

                return btn;
            }

            })
    </script>
    <script>

            const rangepicker= new Litepicker({
                element: document.getElementById('searchRange'),
                format: 'DD-MM-YYYY',
                singleMode: false,
                resetButton: true,
                setup: (picker) => {

                    picker.on('selected', (startDate, endDate) => {
                        console.log(startDate, endDate);
                        Livewire.emit('searchRange', startDate.format('YYYY-MM-DD'), endDate.format('YYYY-MM-DD'));
                    })
                },
                resetButton: () => {
                let btn = document.createElement('button');
                btn.innerText = 'Clear';
                btn.addEventListener('click', (evt) => {
                    evt.preventDefault();

                    Livewire.emit('resetDateRange');
                });

                return btn;
                }

            })


    </script>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    new ClipboardJS('#copyToClipboard');
</script>





