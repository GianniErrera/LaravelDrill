<div>

    @livewire('reminders')

    <div class="lg:flex lg:justify-around">
        <div class="text-center mb-4 mt-8">
            <select wire:model="columnOrderCriteria"
                class="select select-bordered">
                <option value="created_at">Ordered by creation date</option>
                <option value="date">Ordered by date</option>
            </select>
        </div>


        <div class="md:mb-3 block text-center @if($singleDateQuery) hidden @endif">
            <label for="search" class="block text-center mb-3 font-size-14px font-semibold">Search over dates range:</label>
            <input
                id="searchRange"
                name="searchRange"
                type="text"
                class="ml-4 mb-4 p-2 input input-bordered border border-gray-800"
                size="22"
                readonly
            >
        </div>


        <div class="block md:mb-3 text-center @unless ($singleDateQuery)hidden @endunless">
            <label for="date" class="block text-center mb-3 font-semibold">Pick a date:</label>

            <input
                id="searchDate"
                name="searchDate"
                type="text"
                class="text-center ml-4 mb-4 p-2 input input-bordered border border-gray-800"
                size="22"
                readonly
            >

        </div>

        <div class="mb-3 text-center">
            <div class="block mb-5">
                <span class="text-center font-semibold">Sigle date query</span>
            </div>
            <div class="block text-center">
                <input
                    type="checkbox"
                    wire:model="singleDateQuery"
                    class="flex-none checkbox"
                >
            </div>

        </div>


        <div class="mb-3 text-center ">
            <label for="search" class="block text-center mb-3 font-semibold">Search events:</label>

            <input
                type="text"
                wire:model="search"
                id="search"
                name="search"
                value="{{old('search')}}"
                placeholder=""
                class="input input-bordered border border-gray-800 mb-4 p-2"
            >
        </div>


        <div class="mb-3 text-center">
            <div class="block mb-5">
                <span class="text-center font-semibold">Search interval over all years</span>
            </div>
            <div class="block text-center">
                <input
                type="checkbox"
                wire:model="ignoreYearFromQuery"
                class="flex-none checkbox">
            </div>

        </div>

        <div>
            <div class="block text-center mb-">
                <span class="ml-2 text-center font-semibold">Reset filters</span>
                <div class="text-center m-4">
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

    <div>
        @if (session()->has('message'))
            <div class="success"
            x-transition:enter.duration.500ms
            x-transition:leave.duration.400ms
            >

                {{ session('message') }}

            </div>

        @endif
    </div>

    <div class="border border-b-gray-300 rounded-xl">

        @forelse ($events as $event)
        <div class="p-4 border-b border-b-gray-400 rounded-xl ml-2 mr-2' }}">
            <div class="flex flex-row justify-between">
                <div class="w-1/3">
                    <div>
                        <p class="mb-3"> {{ $event->date }} </p>
                    </div>
                    <div>
                        <p class="mb-3 leading-relaxed"> {{ $event->eventDescription }} </p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="icon-container col-xs-12 col-sm-4 lg:mr-2 p-4">
                        @if($event->yearly())
                        <div>
                            <div>
                                <img src="images/calendar_icon.svg" width="20">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="lg:mr-4">
                        <button class="btn btn-primary hover:text-yellow-100"
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
        const singlePicker= new Litepicker({
            element: document.getElementById('searchDate'),
            format: 'D-MMM-YYYY',
            resetButton: true,
            singleMode: true,
            allowRepick: true,
            autoRefresh: true,
            dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
            setup: (picker) => {
                picker.on('selected', (date) => {
                    Livewire.emit('singleDate', date.format('YYYY-MM-DD'));
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

            const rangePicker= new Litepicker({
                element: document.getElementById('searchRange'),
                format: 'D-MMM-YYYY',
                singleMode: false,
                resetButton: true,
                dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
                setup: (picker) => {
                    picker.on('selected', (startDate, endDate) => {
                        Livewire.emit('searchRange', startDate.format('YYYY-MM-DD'), endDate.format('YYYY-MM-DD'));
                    })
                },
                resetButton: () => {
                    let btn = document.createElement('button');
                    btn.innerText = 'Clear';
                    btn.addEventListener('click', (evt) => {
                        evt.preventDefault();/*
                        Livewire.emit('resetDateRange'); */
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

<script>

    window.addEventListener('load', () => { // this will clear single datepicker selection
        Livewire.on('clearSingleDatepicker', () => {
        singlePicker.clearSelection();
        })
    });

    window.addEventListener('load', () => { // this will clear rangepicker selection
        Livewire.on('clearRangeDatepicker', () => {
        rangePicker.clearSelection();
        })
    });

</script>





