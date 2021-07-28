<div class="block mr-4">
    <label for="searchRange" class="block text-center">Select start date and end date:</label>

    <input
        id="searchRange"
        name="searchRange"
        class="ml-4 mb-4 p-2 border border-gray-800"
        >
        <div>
            @error('endDate')
            <p class="text-red-500 text-sm m-2"> {{ $message}}</p>
            @enderror
        </div>

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
            }

            })
        </script>
</div>
