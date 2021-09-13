<div>
    @forelse ($reminders as $reminder)
    <div class="flex m-4 p-4 justify-between bg-blue-800 text-white">
        <div class="flex reminder"
            id ="{{$loop->iteration}}">
            {{$reminder->date . " - " . $reminder->eventDescription}}
        </div>
        <button onclick="this.parentElement.style.display = 'none';" >
            <div class="flex font-xl font-bold text-grey-900 text-center">
                X
            </div>
        </button>
    </div>

    @empty

    @endforelse
</div>
